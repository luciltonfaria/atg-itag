@extends('layouts.app')

@section('title', 'Alunos s/ Registro por Turma')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Alunos s/ Registro por Turma</h4>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('relatorios.faltas-turma') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="turma_id" class="form-label">Turma</label>
                            <select id="turma_id" name="turma_id" class="form-select" required>
                                <option value="">Selecione</option>
                                @foreach($turmas as $t)
                                    <option value="{{ $t->id }}" {{ request('turma_id') == $t->id ? 'selected' : '' }}>
                                        {{ $t->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="data_inicio" class="form-label">Data inicial</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="data_fim" class="form-label">Data final</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" value="{{ request('data_fim') }}" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($turma) && $turma)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Resultados - Turma: {{ $turma->nome }}</h5>
                    @if(isset($faltas) && $faltas && $faltas->count())
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 60%">Aluno</th>
                                        <th>Turma</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($faltas as $aluno)
                                        <tr>
                                            <td>{{ $aluno->nome }}</td>
                                            <td>{{ $turma->nome }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Nenhum aluno sem registro no período informado para esta turma.</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
    </div>
@endsection