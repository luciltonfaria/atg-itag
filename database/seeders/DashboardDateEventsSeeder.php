<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Escola;
use App\Models\Tag;
use App\Models\Antenna;

class DashboardDateEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command?->info('📡 Gerando eventos de movimentação para 10/11/2025 e 11/11/2025...');

        // Datas alvo (formato YYYY-MM-DD)
        $dates = [
            Carbon::create(2025, 11, 10),
            Carbon::create(2025, 11, 11),
        ];

        // Limpar eventos existentes nas datas alvo para evitar duplicidade
        foreach ($dates as $date) {
            DB::table('movement_events')
                ->whereDate('seen_at', $date->toDateString())
                ->delete();
        }

        $escolas = Escola::all();
        if ($escolas->isEmpty()) {
            $this->command?->warn('⚠️ Nenhuma escola encontrada. Execute os seeders de estrutura antes.');
            return;
        }

        foreach ($escolas as $escola) {
            // Garantir ao menos uma antena ativa por escola
            $antenna = Antenna::firstOrCreate(
                ['escola_id' => $escola->id, 'codigo' => '1'],
                ['descricao' => 'Portão Principal', 'ativo' => true]
            );

            // Selecionar tags vinculadas aos alunos da escola
            $tags = Tag::whereHas('aluno.turma', function ($q) use ($escola) {
                $q->where('escola_id', $escola->id);
            })
                ->inRandomOrder()
                ->limit(60)
                ->get();

            if ($tags->isEmpty()) {
                $this->command?->warn("⚠️ Escola '{$escola->nome}' sem tags/alunos. Pulando.");
                continue;
            }

            // Dividir conjuntos para variar presença entre os dias
            $half = (int) max(1, floor($tags->count() / 2));
            $subsetA = $tags->slice(0, $half);
            $subsetB = $tags->slice($half);

            foreach ($dates as $i => $date) {
                $subset = $i === 0 ? $subsetA : ($subsetB->isNotEmpty() ? $subsetB : $subsetA);

                foreach ($subset as $tag) {
                    // 1-2 eventos por tag no dia
                    $eventsCount = rand(1, 2);
                    for ($k = 0; $k < $eventsCount; $k++) {
                        $time = $date->copy()->setTime(rand(7, 18), rand(0, 59), rand(0, 59));

                        DB::table('movement_events')->insert([
                            'epc' => $tag->epc,
                            'seen_at' => $time,
                            'source' => 'monitor',
                            'antenna_id' => $antenna->id,
                            'antenna' => $antenna->codigo,
                            'rssi' => rand(-75, -35),
                            'raw' => json_encode([
                                'epc' => $tag->epc,
                                'timestamp' => $time->toISOString(),
                                'antenna' => $antenna->codigo,
                                'rssi' => rand(-75, -35),
                            ]),
                            'created_at' => $time,
                            'updated_at' => $time,
                        ]);
                    }
                }
            }

            $this->command?->info("✅ Eventos gerados para escola: {$escola->nome}");
        }

        $total = DB::table('movement_events')
            ->whereIn(DB::raw('DATE(seen_at)'), array_map(fn($d) => $d->toDateString(), $dates))
            ->count();
        $this->command?->info("📈 Total de eventos inseridos (10/11 e 11/11): {$total}");
    }
}