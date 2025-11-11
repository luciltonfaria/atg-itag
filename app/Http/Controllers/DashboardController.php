<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $escolaId = $user->escola_id;

        // Estatísticas básicas
        $total_classes = DB::table('turmas')->where('escola_id', $escolaId)->count();
        $total_students = DB::table('alunos')
            ->join('turmas', 'turmas.id', '=', 'alunos.turma_id')
            ->where('turmas.escola_id', $escolaId)
            ->count();

        // Presenças e ausências de hoje
        $presences_today = DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('tu.escola_id', $escolaId)
            ->whereDate('me.seen_at', today())
            ->distinct('a.id')
            ->count('a.id');

        $absences_today = max(0, $total_students - $presences_today);
        $attendance_rate = $total_students > 0 ? round(($presences_today / $total_students) * 100) : 0;

        // Período selecionado via query (?range=1|7|14|30). Padrão: 14 dias
        $range = (int) $request->query('range', 14);
        $allowed = [1, 7, 14, 30];
        if (!in_array($range, $allowed, true)) {
            $range = 14;
        }
        $startDate = Carbon::today()->subDays($range - 1); // inclui hoje
        $endDate = Carbon::today();

        // Movimentos: por hora (se range=1) ou por dia (caso contrário)
        $labelsMovementsByDay = [];
        $dataMovementsByDay = [];
        if ($range === 1) {
            // Hoje por hora (0-23)
            $today = Carbon::today()->toDateString();
            $movementsHours = DB::table('movement_events as me')
                ->join('tags as t', 't.epc', '=', 'me.epc')
                ->join('alunos as a', 'a.id', '=', 't.aluno_id')
                ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
                ->where('tu.escola_id', $escolaId)
                ->whereDate('me.seen_at', $today)
                ->selectRaw('HOUR(me.seen_at) as hora, COUNT(*) as total')
                ->groupBy('hora')
                ->orderBy('hora')
                ->get();

            for ($h = 0; $h <= 23; $h++) {
                $labelsMovementsByDay[] = str_pad((string) $h, 2, '0', STR_PAD_LEFT) . ':00';
                $row = $movementsHours->firstWhere('hora', $h);
                $dataMovementsByDay[] = $row ? (int) $row->total : 0;
            }
        } else {
            // Por dia dentro do intervalo selecionado
            $movementsRows = DB::table('movement_events as me')
                ->join('tags as t', 't.epc', '=', 'me.epc')
                ->join('alunos as a', 'a.id', '=', 't.aluno_id')
                ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
                ->where('tu.escola_id', $escolaId)
                ->whereBetween(DB::raw('DATE(me.seen_at)'), [$startDate->toDateString(), $endDate->toDateString()])
                ->selectRaw('DATE(me.seen_at) as dia, COUNT(*) as total')
                ->groupBy('dia')
                ->orderBy('dia')
                ->get();

            for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
                $labelsMovementsByDay[] = $d->format('d/m');
                $row = $movementsRows->firstWhere('dia', $d->toDateString());
                $dataMovementsByDay[] = $row ? (int) $row->total : 0;
            }
        }

        // Registros por período do dia (manhã/tarde/noite)
        $periodos = DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('tu.escola_id', $escolaId)
            ->whereBetween(DB::raw('DATE(me.seen_at)'), [$startDate->toDateString(), $endDate->toDateString()])
            ->selectRaw("CASE 
                WHEN HOUR(me.seen_at) BETWEEN 6 AND 11 THEN 'Manhã'
                WHEN HOUR(me.seen_at) BETWEEN 12 AND 17 THEN 'Tarde'
                ELSE 'Noite' END as periodo, COUNT(*) as total")
            ->groupBy('periodo')
            ->get();
        $labelsByPeriod = ['Manhã', 'Tarde', 'Noite'];
        $dataByPeriod = array_map(function($p) use ($periodos){
            $row = $periodos->firstWhere('periodo', $p);
            return $row ? (int) $row->total : 0;
        }, $labelsByPeriod);

        // Top 5 turmas por registros no período
        $topClassesRows = DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('tu.escola_id', $escolaId)
            ->whereBetween(DB::raw('DATE(me.seen_at)'), [$startDate->toDateString(), $endDate->toDateString()])
            ->select('tu.nome as turma_nome', DB::raw('COUNT(*) as total'))
            ->groupBy('tu.nome')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $labelsTopClasses = $topClassesRows->pluck('turma_nome')->toArray();
        $dataTopClasses = $topClassesRows->pluck('total')->map(fn($v) => (int) $v)->toArray();

        // Alunos com vs sem registro no período
        $studentsWithMovement = DB::table('movement_events as me')
            ->join('tags as t', 't.epc', '=', 'me.epc')
            ->join('alunos as a', 'a.id', '=', 't.aluno_id')
            ->join('turmas as tu', 'tu.id', '=', 'a.turma_id')
            ->where('tu.escola_id', $escolaId)
            ->whereBetween(DB::raw('DATE(me.seen_at)'), [$startDate->toDateString(), $endDate->toDateString()])
            ->distinct('a.id')
            ->count('a.id');
        $studentsWithoutMovement = max(0, $total_students - $studentsWithMovement);

        $currentRange = $range;
        return view('dashboard.index', compact(
            'total_classes',
            'total_students',
            'presences_today',
            'absences_today',
            'attendance_rate',
            'labelsMovementsByDay',
            'dataMovementsByDay',
            'labelsByPeriod',
            'dataByPeriod',
            'labelsTopClasses',
            'dataTopClasses',
            'studentsWithMovement',
            'studentsWithoutMovement',
            'currentRange'
        ));
    }
}
