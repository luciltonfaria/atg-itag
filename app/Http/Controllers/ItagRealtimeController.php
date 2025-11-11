<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\StudentTag;
use App\Services\AutoCadastroService;
use App\Services\AntennaResolver;

class ItagRealtimeController extends Controller
{
    public function __construct(
        private AutoCadastroService $auto,
        private AntennaResolver $antennaResolver
    ) {}

    private function base(): string
    {
        return rtrim(config('services.itag_monitor.base'), '/');
    }

    // Comandos do Monitor: iniciar, parar, limparLeitura
    public function start()
    {
        return $this->command('iniciar');
    }
    public function stop()
    {
        return $this->command('parar');
    }
    public function clear()
    {
        return $this->command('limparLeitura');
    }

    private function command(string $cmd)
    {
        $url = $this->base() . "/CarregaComando";
        try {
            $res = Http::timeout(2)->connectTimeout(1)->get($url, ['comando' => $cmd]);
            return response()->json([
                'ok' => $res->ok(),
                'body' => $res->json() ?? $res->body()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'error' => 'iTAG Monitor não disponível: ' . $e->getMessage()
            ], 503);
        }
    }

    // Snapshot imediato (RetornaTag e RetornaTime)
    public function tags()
    {
        $tagsUrl = $this->base() . "/RetornaTag";
        $timeUrl = $this->base() . "/RetornaTime";

        try {
            $tags = Http::timeout(2)->connectTimeout(1)->get($tagsUrl)->json();
            $time = Http::timeout(2)->connectTimeout(1)->get($timeUrl)->json();
            return response()->json(['time' => $time, 'tags' => $tags]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'iTAG Monitor não disponível',
                'message' => $e->getMessage()
            ], 503);
        }
    }

    // SSE: polling leve no Monitor e envio incremental ao navegador
    public function stream(Request $request)
    {
        $response = new StreamedResponse(function () {
            echo "retry: 2000\n";
            $base = $this->base();
            $tagsUrl = "$base/RetornaTag";
            $timeUrl = "$base/RetornaTime";
            $seen = [];
            $start = time();

            while (time() - $start < 120) { // janela de ~2 min
                try {
                    $tags = Http::timeout(2)->connectTimeout(1)->get($tagsUrl)->json();
                    $time = Http::timeout(2)->connectTimeout(1)->get($timeUrl)->json();
                } catch (\Throwable $e) {
                    echo "event: error\ndata: " . json_encode(['message' => 'monitor_offline']) . "\n\n";
                    @ob_flush();
                    @flush();
                    usleep(500000);
                    continue;
                }

                $now = is_array($time) ? ($time['time'] ?? $time[0] ?? now()->toISOString()) : (string)$time;
                $list = is_array($tags) ? $tags : [];

                foreach ($list as $tag) {
                    $epc = $tag['epc'] ?? $tag['EPC'] ?? $tag['codigo'] ?? null;
                    if (!$epc || isset($seen[$epc])) continue;
                    $seen[$epc] = true;

                    // Monta payload mínimo para auto-cadastro de hierarquia
                    $payloadHierarchy = [
                        'epc'        => $epc,
                        'nome'       => $tag['nome']       ?? null, // se vier do inventário
                        'referencia' => $tag['referencia'] ?? null,
                        'extra1'     => $tag['extra1']     ?? null, // escola
                        'extra2'     => $tag['extra2']     ?? null, // turma
                    ];

                    // 1) Garante Escola/Turma/Aluno/Tag
                    $alunoId = null;
                    try {
                        $tagModel = $this->auto->ensureHierarchy($payloadHierarchy);
                        $alunoId  = $tagModel->aluno_id;
                    } catch (\Throwable $e) {
                        // segue mesmo sem hierarquia
                    }

                    // 2) Resolve/Cria Antenna (por escola do aluno) a partir do campo 'antenna' do evento
                    $antennaCode = $tag['antenna'] ?? null; // pode ser número (porta) ou string
                    $antennaModel = null;
                    try {
                        $antennaModel = $this->antennaResolver->resolveForAluno($alunoId, $antennaCode !== null ? (string)$antennaCode : null);
                    } catch (\Throwable $e) {
                        $antennaModel = null;
                    }

                    // 3) Persistência do evento
                    try {
                        DB::table('movement_events')->insert([
                            'epc'         => $epc,
                            'seen_at'     => now(),
                            'source'      => 'monitor',
                            'antenna_id'  => $antennaModel?->id,
                            'antenna'     => $antennaCode !== null ? (string)$antennaCode : null,
                            'rssi'        => $tag['rssi'] ?? null,
                            'raw'         => json_encode($tag),
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ]);
                    } catch (\Throwable $e) {
                    }

                    // 4) Envia ao front (SSE)
                    $payloadEvent = [
                        'epc'        => $epc,
                        'aluno_id'   => $alunoId,
                        'antenna'    => $antennaCode !== null ? (string)$antennaCode : null,
                        'antenna_id' => $antennaModel?->id,
                        'rssi'       => $tag['rssi'] ?? null,
                        'time'       => $now,
                    ];
                    echo "event: tag\n";
                    echo "data: " . json_encode($payloadEvent) . "\n\n";
                }

                @ob_flush();
                @flush();
                usleep(500000);
            }

            echo "event: end\ndata: {}\n\n";
            @ob_flush();
            @flush();
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('X-Accel-Buffering', 'no'); // nginx
        return $response;
    }
}
