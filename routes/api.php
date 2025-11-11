<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\ItagRealtimeController;
use App\Services\AutoCadastroService;
use App\Services\AntennaResolver;

Route::prefix('itag')->group(function () {
    Route::post('/start', [ItagRealtimeController::class, 'start']);
    Route::post('/stop',  [ItagRealtimeController::class, 'stop']);
    Route::post('/clear', [ItagRealtimeController::class, 'clear']);
    Route::get('/tags',   [ItagRealtimeController::class, 'tags']);   // snapshot
    Route::get('/stream', [ItagRealtimeController::class, 'stream']); // SSE

    // Endpoint de teste para "detecção" sem o hardware
    Route::post('/mock-detect', function (Request $r, AutoCadastroService $auto) {
        // Body JSON pode conter epc, nome, referencia, extra1 (escola), extra2 (turma)
        $payload = $r->validate([
            'epc'        => 'required|string|max:64',
            'nome'       => 'nullable|string|max:160',
            'referencia' => 'nullable|string|max:60',
            'extra1'     => 'nullable|string|max:120',
            'extra2'     => 'nullable|string|max:120',
        ]);
        $tag = $auto->ensureHierarchy($payload);

        DB::table('movement_events')->insert([
            'epc'        => $payload['epc'],
            'seen_at'    => now(),
            'source'     => 'mock',
            'raw'        => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true, 'tag_id' => $tag->id]);
    });

    // Endpoint de teste para simular evento com antena
    Route::post('/mock-event', function (Request $r, AutoCadastroService $auto, AntennaResolver $resolver) {
        $payload = $r->validate([
            'epc'        => 'required|string|max:64',
            'antenna'    => 'nullable',
            'nome'       => 'nullable|string|max:160',
            'referencia' => 'nullable|string|max:60',
            'extra1'     => 'nullable|string|max:120', // escola
            'extra2'     => 'nullable|string|max:120', // turma
        ]);

        // Hierarquia
        $tagModel = $auto->ensureHierarchy($payload);
        $alunoId  = $tagModel->aluno_id;

        // Antena
        $antennaModel = $resolver->resolveForAluno($alunoId, isset($payload['antenna']) ? (string)$payload['antenna'] : null);

        // Evento
        DB::table('movement_events')->insert([
            'epc'         => $payload['epc'],
            'seen_at'     => now(),
            'source'      => 'mock',
            'antenna_id'  => $antennaModel?->id,
            'antenna'     => isset($payload['antenna']) ? (string)$payload['antenna'] : null,
            'raw'         => json_encode($payload),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return response()->json([
            'ok' => true,
            'aluno_id' => $alunoId,
            'antenna_id' => $antennaModel?->id,
        ]);
    });
});
