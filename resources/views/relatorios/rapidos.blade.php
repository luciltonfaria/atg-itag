@extends('layouts.app')

@section('title', 'Relatórios rápidos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Relatórios rápidos</h4>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('relatorios.rapidos') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="data_inicio" class="form-label">Data inicial</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="{{ request('data_inicio', $data_inicio ?? now()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="data_fim" class="form-label">Data final</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" value="{{ request('data_fim', $data_fim ?? now()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $countCom = isset($comRegistro) ? $comRegistro->count() : 0;
            $countSem = isset($semRegistro) ? $semRegistro->count() : 0;
        @endphp

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Alunos com registro</h5>
                            <span class="badge bg-primary">{{ $countCom }}</span>
                        </div>
                        @if($countCom)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%">Aluno</th>
                                            <th style="width: 30%">Turma</th>
                                            <th style="width: 30%">Primeira</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($comRegistro as $item)
                                            <tr>
                                                <td>{{ $item['aluno']->nome }}</td>
                                                <td>{{ optional($item['turma'])->nome ?? '-' }}</td>
                                                <td>{{ $item['primeira_movimentacao'] ? \Carbon\Carbon::parse($item['primeira_movimentacao'])->format('d/m/Y H:i') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Nenhum aluno com registro no período.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Alunos sem registro</h5>
                            <span class="badge bg-info">{{ $countSem }}</span>
                        </div>
                        @if($countSem)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th style="width: 60%">Aluno</th>
                                            <th>Turma</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($semRegistro as $item)
                                            <tr>
                                                <td>{{ $item['aluno']->nome }}</td>
                                                <td>{{ optional($item['turma'])->nome ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Nenhum aluno sem registro no período.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection