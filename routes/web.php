<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\SystemLogController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PresencesController;

// Redirect raiz para login
Route::get('/', function () {
    return redirect('/login');
});

// Rotas de autenticação
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rotas protegidas
Route::middleware(['auth', \App\Http\Middleware\EnsureUserHasEscola::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Escolas (apenas visualização e edição - escolas vêm da API iTAG)
    Route::resource('schools', SchoolController::class)->except(['create', 'store', 'destroy'])->parameters([
        'schools' => 'escola'
    ]);

    // Usuários (gerenciar usuários e associações com escolas)
    Route::resource('users', UserController::class);

    // Relatórios
    Route::get('/relatorios/movimentacao-aluno', [RelatorioController::class, 'movimentacaoPorAluno'])->name('relatorios.movimentacao-aluno');
    Route::get('/relatorios/movimentacao-turma', [RelatorioController::class, 'movimentacaoPorTurma'])->name('relatorios.movimentacao-turma');
    // Exportações da Movimentação por Turma
    Route::get('/relatorios/movimentacao-turma/export/csv', [RelatorioController::class, 'exportMovimentacaoTurmaCsv'])->name('relatorios.movimentacao-turma.export.csv');
    Route::get('/relatorios/movimentacao-turma/export/print', [RelatorioController::class, 'exportMovimentacaoTurmaPrint'])->name('relatorios.movimentacao-turma.export.print');

    // Relatório: Movimentação por Aluno
    Route::get('/relatorios/movimentacao-aluno', [RelatorioController::class, 'movimentacaoPorAluno'])->name('relatorios.movimentacao-aluno');
    // Exportações da Movimentação por Aluno
    Route::get('/relatorios/movimentacao-aluno/export/csv', [RelatorioController::class, 'exportMovimentacaoAlunoCsv'])->name('relatorios.movimentacao-aluno.export.csv');
    Route::get('/relatorios/movimentacao-aluno/export/print', [RelatorioController::class, 'exportMovimentacaoAlunoPrint'])->name('relatorios.movimentacao-aluno.export.print');
    Route::get('/relatorios/movimentacao-geral', [RelatorioController::class, 'movimentacaoGeral'])->name('relatorios.movimentacao-geral');
    // Relatórios rápidos (dashboard)
    Route::get('/relatorios/rapidos', [RelatorioController::class, 'relatoriosRapidos'])->name('relatorios.rapidos');
    Route::get('/relatorios/faltas-turma', [RelatorioController::class, 'faltasPorTurma'])->name('relatorios.faltas-turma');
    Route::get('/relatorios/faltas-geral', [RelatorioController::class, 'faltasGeral'])->name('relatorios.faltas-geral');

    // Auditoria: Logs de sistema
    Route::get('/audit/logs', [SystemLogController::class, 'index'])->name('audit.system');

    // AJAX
    Route::get('/api/turmas/{turma}/alunos', [RelatorioController::class, 'getAlunosByTurma'])->name('turmas.alunos');

    // Presenças: Histórico detalhado por aluno
    Route::get('/presences/history', [PresencesController::class, 'history'])->name('movements.history');
    Route::get('/presences/history/pdf', [PresencesController::class, 'historyPdf'])->name('movements.history.pdf');
});
