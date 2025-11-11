<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Escola;

class RelatorioController extends Controller
{
    // Relatório 1: Movimentação por Aluno
    public function movimentacaoPorAluno(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $turmas = Turma::where('escola_id', $escolaId)->orderBy('nome')->get();

        $movimentacoes = null;
        $aluno = null;

        if ($request->has('aluno_id')) {
            $request->validate([
                'aluno_id' => 'required|exists:alunos,id',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
            ]);

            $aluno = Aluno::with('turma')->findOrFail($request->aluno_id);

            $movimentacoes = DB::table('movement_events as me')
                ->join('tags as t', 't.epc', '=', 'me.epc')
                ->where('t.aluno_id', $request->aluno_id)
                ->whereBetween('me.seen_at', [
                    $request->data_inicio . ' 00:00:00',
                    $request->data_fim . ' 23:59:59'
                ])
                ->select('me.seen_at', 'me.antenna', 'me.rssi', 'me.source')
                ->orderBy('me.seen_at', 'asc')
                ->get();
        }

        return view('relatorios.movimentacao-aluno', compact('turmas', 'movimentacoes', 'aluno'));
    }

    // Relatório 2: Movimentação por Turma
    public function movimentacaoPorTurma(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $turmas = Turma::where('escola_id', $escolaId)->orderBy('nome')->get();

        $resultados = null;
        $eventos = null;
        $turma = null;
        $ordenacao = 'alfabetica';

        if ($request->has('turma_id')) {
            $request->validate([
                'turma_id' => 'required|exists:turmas,id',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'ordenacao' => 'nullable|in:alfabetica,data',
            ]);

            $ordenacao = $request->input('ordenacao', 'alfabetica');
            $turma = Turma::findOrFail($request->turma_id);

            // Todos os alunos da turma
            $alunos = Aluno::where('turma_id', $request->turma_id)->get();

            $resultados = $alunos->map(function ($aluno) use ($request) {
                $movimentacoes = DB::table('movement_events as me')
                    ->join('tags as t', 't.epc', '=', 'me.epc')
                    ->where('t.aluno_id', $aluno->id)
                    ->whereBetween('me.seen_at', [
                        $request->data_inicio . ' 00:00:00',
                        $request->data_fim . ' 23:59:59'
                    ])
                    ->select('me.seen_at')
                    ->orderBy('me.seen_at', 'asc')
                    ->get();

                return [
                    'aluno' => $aluno,
                    'tem_movimentacao' => $movimentacoes->isNotEmpty(),
                    'primeira_movimentacao' => $movimentacoes->first()?->seen_at,
                    'ultima_movimentacao' => $movimentacoes->last()?->seen_at,
                    'total_movimentacoes' => $movimentacoes->count(),
                ];
            });

            // Ordenação
            if ($ordenacao === 'alfabetica') {
                $resultados = $resultados->sortBy('aluno.nome')->values();
            } else {
                $resultados = $resultados->sortBy('primeira_movimentacao')->values();
            }

            // Listagem detalhada de eventos da turma (com nome do aluno)
            $eventos = DB::table('movement_events as me')
                ->join('tags as t', 't.epc', '=', 'me.epc')
                ->join('alunos as a', 'a.id', '=', 't.aluno_id')
                ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
                ->where('a.turma_id', $request->turma_id)
                ->where('tu.escola_id', $escolaId)
                ->whereBetween('me.seen_at', [
                    $request->data_inicio . ' 00:00:00',
                    $request->data_fim . ' 23:59:59'
                ])
                ->select(
                    'me.seen_at',
                    'me.antenna',
                    'me.rssi',
                    'me.source',
                    'a.nome as aluno_nome',
                    'tu.nome as turma_nome'
                )
                ->orderBy('me.seen_at', 'asc')
                ->get();
        }

        return view('relatorios.movimentacao-turma', compact('turmas', 'resultados', 'eventos', 'turma', 'ordenacao'));
    }

    // Export: CSV para Excel (Movimentação por Turma)
    public function exportMovimentacaoTurmaCsv(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $turma = Turma::where('id', $request->turma_id)
            ->where('escola_id', $escolaId)
            ->firstOrFail();

        $eventos = \DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('a.turma_id', $request->turma_id)
            ->where('tu.escola_id', $escolaId)
            ->whereBetween('me.seen_at', [
                $request->data_inicio . ' 00:00:00',
                $request->data_fim . ' 23:59:59'
            ])
            ->select('me.seen_at', 'a.nome as aluno_nome', 'tu.nome as turma_nome', 'me.antenna', 'me.rssi', 'me.source')
            ->orderBy('me.seen_at', 'asc')
            ->get();

        $filename = sprintf('movimentacao_turma_%s_%s_%s.csv',
            preg_replace('/\s+/', '_', $turma->nome),
            $request->data_inicio,
            $request->data_fim
        );

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = ['Data/Hora', 'Aluno', 'Turma', 'Antena', 'RSSI', 'Fonte'];

        $callback = function () use ($columns, $eventos) {
            $handle = fopen('php://output', 'w');
            // BOM para UTF-8 no Excel
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $columns, ';');
            foreach ($eventos as $ev) {
                fputcsv($handle, [
                    $ev->seen_at,
                    $ev->aluno_nome,
                    $ev->turma_nome,
                    $ev->antenna,
                    $ev->rssi,
                    $ev->source,
                ], ';');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export: Página de impressão (HTML) para gerar PDF via navegador
    public function exportMovimentacaoTurmaPrint(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $request->validate([
            'turma_id' => 'required|exists:turmas,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $turma = Turma::where('id', $request->turma_id)
            ->where('escola_id', $escolaId)
            ->firstOrFail();

        $eventos = \DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('a.turma_id', $request->turma_id)
            ->where('tu.escola_id', $escolaId)
            ->whereBetween('me.seen_at', [
                $request->data_inicio . ' 00:00:00',
                $request->data_fim . ' 23:59:59'
            ])
            ->select('me.seen_at', 'a.nome as aluno_nome', 'tu.nome as turma_nome', 'me.antenna', 'me.rssi', 'me.source')
            ->orderBy('me.seen_at', 'asc')
            ->get();

        $school = Escola::find($escolaId);

        return view('relatorios.movimentacao-turma-print', [
            'turma' => $turma,
            'eventos' => $eventos,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'school' => $school,
        ]);
    }

    // Export: CSV para Excel (Movimentação por Aluno)
    public function exportMovimentacaoAlunoCsv(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $aluno = Aluno::with('turma')->findOrFail($request->aluno_id);

        // Garante que o aluno pertence à escola logada
        if (!$aluno->turma || $aluno->turma->escola_id !== $escolaId) {
            abort(403, 'Aluno não pertence à escola logada.');
        }

        $eventos = \DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('t.aluno_id', $request->aluno_id)
            ->where('tu.escola_id', $escolaId)
            ->whereBetween('me.seen_at', [
                $request->data_inicio . ' 00:00:00',
                $request->data_fim . ' 23:59:59'
            ])
            ->select('me.seen_at', 'a.nome as aluno_nome', 'tu.nome as turma_nome', 'me.antenna', 'me.rssi', 'me.source')
            ->orderBy('me.seen_at', 'asc')
            ->get();

        $filename = sprintf('movimentacao_aluno_%s_%s_%s.csv',
            preg_replace('/\s+/', '_', $aluno->nome),
            $request->data_inicio,
            $request->data_fim
        );

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $columns = ['Data/Hora', 'Aluno', 'Turma', 'Antena', 'RSSI', 'Fonte'];

        $callback = function () use ($columns, $eventos) {
            $handle = fopen('php://output', 'w');
            // BOM para UTF-8 no Excel
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $columns, ';');
            foreach ($eventos as $ev) {
                fputcsv($handle, [
                    $ev->seen_at,
                    $ev->aluno_nome,
                    $ev->turma_nome,
                    $ev->antenna,
                    $ev->rssi,
                    $ev->source,
                ], ';');
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export: Página de impressão (HTML) para gerar PDF via navegador - Movimentação por Aluno
    public function exportMovimentacaoAlunoPrint(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        $aluno = Aluno::with('turma')->findOrFail($request->aluno_id);

        // Garante que o aluno pertence à escola logada
        if (!$aluno->turma || $aluno->turma->escola_id !== $escolaId) {
            abort(403, 'Aluno não pertence à escola logada.');
        }

        $eventos = \DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('t.aluno_id', $request->aluno_id)
            ->where('tu.escola_id', $escolaId)
            ->whereBetween('me.seen_at', [
                $request->data_inicio . ' 00:00:00',
                $request->data_fim . ' 23:59:59'
            ])
            ->select('me.seen_at', 'a.nome as aluno_nome', 'tu.nome as turma_nome', 'me.antenna', 'me.rssi', 'me.source')
            ->orderBy('me.seen_at', 'asc')
            ->get();

        $school = Escola::find($escolaId);

        return view('relatorios.movimentacao-aluno-print', [
            'aluno' => $aluno,
            'eventos' => $eventos,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'school' => $school,
        ]);
    }

    // Relatório 3: Movimentação Geral
    public function movimentacaoGeral(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $resultados = null;
        $ordenacao = 'alfabetica';

        if ($request->has('data_inicio')) {
            $request->validate([
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
                'ordenacao' => 'nullable|in:alfabetica,data',
            ]);

            $ordenacao = $request->input('ordenacao', 'alfabetica');

            // Todos os alunos da escola
            $alunos = Aluno::whereHas('turma', function ($q) use ($escolaId) {
                $q->where('escola_id', $escolaId);
            })->with('turma')->get();

            $resultados = $alunos->map(function ($aluno) use ($request) {
                $movimentacoes = DB::table('movement_events as me')
                    ->join('tags as t', 't.epc', '=', 'me.epc')
                    ->where('t.aluno_id', $aluno->id)
                    ->whereBetween('me.seen_at', [
                        $request->data_inicio . ' 00:00:00',
                        $request->data_fim . ' 23:59:59'
                    ])
                    ->select('me.seen_at')
                    ->orderBy('me.seen_at', 'asc')
                    ->get();

                return [
                    'aluno' => $aluno,
                    'turma' => $aluno->turma,
                    'tem_movimentacao' => $movimentacoes->isNotEmpty(),
                    'primeira_movimentacao' => $movimentacoes->first()?->seen_at,
                    'ultima_movimentacao' => $movimentacoes->last()?->seen_at,
                    'total_movimentacoes' => $movimentacoes->count(),
                ];
            });

            // Ordenação
            if ($ordenacao === 'alfabetica') {
                $resultados = $resultados->sortBy('aluno.nome')->values();
            } else {
                $resultados = $resultados->sortBy('primeira_movimentacao')->values();
            }
        }

        return view('relatorios.movimentacao-geral', compact('resultados', 'ordenacao'));
    }

    // Dashboard: Relatórios rápidos (Movimentação Geral - resumo)
    public function relatoriosRapidos(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        // Período padrão: hoje
        $dataInicio = $request->input('data_inicio', now()->format('Y-m-d'));
        $dataFim = $request->input('data_fim', now()->format('Y-m-d'));

        // Validação se usuário informou filtros
        $request->merge(['data_inicio' => $dataInicio, 'data_fim' => $dataFim]);
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
        ]);

        // Todos os alunos da escola (com turma)
        $alunos = Aluno::whereHas('turma', function ($q) use ($escolaId) {
                $q->where('escola_id', $escolaId);
            })
            ->with('turma')
            ->orderBy('nome')
            ->get();

        $resultados = $alunos->map(function ($aluno) use ($dataInicio, $dataFim) {
            $movimentacoes = DB::table('movement_events as me')
                ->join('tags as t', 't.epc', '=', 'me.epc')
                ->where('t.aluno_id', $aluno->id)
                ->whereBetween('me.seen_at', [
                    $dataInicio . ' 00:00:00',
                    $dataFim . ' 23:59:59'
                ])
                ->select('me.seen_at')
                ->orderBy('me.seen_at', 'asc')
                ->get();

            return [
                'aluno' => $aluno,
                'turma' => $aluno->turma,
                'tem_movimentacao' => $movimentacoes->isNotEmpty(),
                'primeira_movimentacao' => $movimentacoes->first()?->seen_at,
                'ultima_movimentacao' => $movimentacoes->last()?->seen_at,
                'total_movimentacoes' => $movimentacoes->count(),
            ];
        });

        $comRegistro = $resultados->filter(fn($r) => $r['tem_movimentacao'])->values();
        $semRegistro = $resultados->filter(fn($r) => !$r['tem_movimentacao'])->values();

        return view('relatorios.rapidos', [
            'comRegistro' => $comRegistro,
            'semRegistro' => $semRegistro,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
        ]);
    }

    // Relatório 4: Faltas por Turma
    public function faltasPorTurma(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $turmas = Turma::where('escola_id', $escolaId)->orderBy('nome')->get();

        $faltas = null;
        $turma = null;

        if ($request->has('turma_id')) {
            $request->validate([
                'turma_id' => 'required|exists:turmas,id',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
            ]);

            $turma = Turma::findOrFail($request->turma_id);

            // Todos os alunos da turma
            $alunos = Aluno::where('turma_id', $request->turma_id)->orderBy('nome')->get();

            $faltas = $alunos->filter(function ($aluno) use ($request) {
                $temMovimentacao = DB::table('movement_events as me')
                    ->join('tags as t', 't.epc', '=', 'me.epc')
                    ->where('t.aluno_id', $aluno->id)
                    ->whereBetween('me.seen_at', [
                        $request->data_inicio . ' 00:00:00',
                        $request->data_fim . ' 23:59:59'
                    ])
                    ->exists();

                return !$temMovimentacao; // Retorna apenas quem NÃO teve movimentação
            })->values();
        }

        return view('relatorios.faltas-turma', compact('turmas', 'faltas', 'turma'));
    }

    // Relatório 5: Faltas Geral
    public function faltasGeral(Request $request)
    {
        $escolaId = auth()->user()->escola_id;

        $faltas = null;

        if ($request->has('data_inicio')) {
            $request->validate([
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date|after_or_equal:data_inicio',
            ]);

            // Todos os alunos da escola
            $alunos = Aluno::whereHas('turma', function ($q) use ($escolaId) {
                $q->where('escola_id', $escolaId);
            })->with('turma')->orderBy('nome')->get();

            $faltas = $alunos->filter(function ($aluno) use ($request) {
                $temMovimentacao = DB::table('movement_events as me')
                    ->join('tags as t', 't.epc', '=', 'me.epc')
                    ->where('t.aluno_id', $aluno->id)
                    ->whereBetween('me.seen_at', [
                        $request->data_inicio . ' 00:00:00',
                        $request->data_fim . ' 23:59:59'
                    ])
                    ->exists();

                return !$temMovimentacao; // Retorna apenas quem NÃO teve movimentação
            })->values();
        }

        return view('relatorios.faltas-geral', compact('faltas'));
    }

    // AJAX: Buscar alunos de uma turma
    public function getAlunosByTurma($turmaId)
    {
        $escolaId = auth()->user()->escola_id;

        $turma = Turma::where('id', $turmaId)
            ->where('escola_id', $escolaId)
            ->firstOrFail();

        $alunos = Aluno::where('turma_id', $turmaId)
            ->orderBy('nome')
            ->get(['id', 'nome']);

        return response()->json($alunos);
    }
}
