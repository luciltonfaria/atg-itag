<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\MovementEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PresencesController extends Controller
{
    /**
     * Histórico detalhado de presença por aluno, com busca e timeline.
     */
    public function history(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $alunoId = $request->get('aluno_id');
        $from = $request->get('from');
        $to = $request->get('to');

        $alunos = [];
        if ($q !== '') {
            $alunos = Aluno::query()
                ->where('nome', 'like', "%{$q}%")
                ->orderBy('nome')
                ->limit(20)
                ->get();
        }

        $selectedAluno = null;
        $timeline = collect();
        if ($alunoId) {
            $selectedAluno = Aluno::with('tags')->find($alunoId);
            if ($selectedAluno && $selectedAluno->tags->count()) {
                $epcs = $selectedAluno->tags->pluck('epc')->all();
                $events = MovementEvent::with('antenna')->forEpcs($epcs, $from, $to)->get();
                $timeline = $events->map(function ($e) {
                    $antennaName = $e->antenna ?: ($e->antenna?->descricao ?? null);
                    return [
                        'seen_at' => $e->seen_at,
                        'source' => $e->source,
                        'epc' => $e->epc,
                        'antenna' => $antennaName,
                        'rssi' => $e->rssi,
                        'raw' => $e->raw,
                    ];
                });
            }
        }

        return view('presences.history', [
            'q' => $q,
            'alunos' => $alunos,
            'selectedAluno' => $selectedAluno,
            'timeline' => $timeline,
            'from' => $from,
            'to' => $to,
        ]);
    }

    /**
     * Exporta histórico detalhado em PDF para o aluno selecionado.
     */
    public function historyPdf(Request $request)
    {
        $alunoId = $request->get('aluno_id');
        $from = $request->get('from');
        $to = $request->get('to');
        $school = \App\Models\Escola::find(optional($request->user())->escola_id);

        $aluno = Aluno::with('tags')->findOrFail($alunoId);
        $epcs = $aluno->tags->pluck('epc')->all();
        $events = MovementEvent::with('antenna')->forEpcs($epcs, $from, $to)->get();
        $eventsForPdf = $events->map(function ($e) {
            $antennaName = $e->antenna ?: ($e->antenna?->descricao ?? null);
            return [
                'seen_at' => $e->seen_at,
                'source' => $e->source,
                'epc' => $e->epc,
                'antenna' => $antennaName,
                'rssi' => $e->rssi,
            ];
        });

        // Usaremos PDF::loadView quando a biblioteca estiver instalada
        if (!class_exists('Barryvdh\\DomPDF\\Facade\\Pdf')) {
            // Fallback simples: retorna HTML mesmo
            return view('presences.history-pdf', [
                'aluno' => $aluno,
                'events' => $eventsForPdf,
                'from' => $from,
                'to' => $to,
                'school' => $school,
            ]);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('presences.history-pdf', [
            'aluno' => $aluno,
            'events' => $eventsForPdf,
            'from' => $from,
            'to' => $to,
            'school' => $school,
        ]);

        return $pdf->download('historico-'.$aluno->id.'.pdf');
    }
}