@extends('layouts.app')

@section('title', 'Movimentação Geral')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Movimentação Geral</h4>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('relatorios.movimentacao-geral') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="data_inicio" class="form-label">Data inicial</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="{{ request('data_inicio') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="data_fim" class="form-label">Data final</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" value="{{ request('data_fim') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="ordenacao" class="form-label">Ordenação</label>
                            <select id="ordenacao" name="ordenacao" class="form-select">
                                <option value="alfabetica" {{ (request('ordenacao') ?? $ordenacao ?? 'alfabetica') === 'alfabetica' ? 'selected' : '' }}>Alfabética</option>
                                <option value="data" {{ (request('ordenacao') ?? $ordenacao ?? 'alfabetica') === 'data' ? 'selected' : '' }}>Primeira movimentação</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(isset($resultados) && $resultados)
            @php
                $comRegistro = collect($resultados)->filter(fn($r) => $r['tem_movimentacao']);
                $semRegistro = collect($resultados)->filter(fn($r) => !$r['tem_movimentacao']);
            @endphp

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Alunos com registro no período</h5>
                                <span class="badge bg-primary">{{ $comRegistro->count() }}</span>
                            </div>
                            @if($comRegistro->count())
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 35%">Aluno</th>
                                                <th style="width: 25%">Turma</th>
                                                <th style="width: 20%">Primeira</th>
                                                <th style="width: 20%">Última</th>
                                                <th>Qtde</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($comRegistro as $item)
                                                <tr>
                                                    <td>{{ $item['aluno']->nome }}</td>
                                                    <td>{{ optional($item['turma'])->nome ?? '-' }}</td>
                                                    <td>{{ $item['primeira_movimentacao'] ? \Carbon\Carbon::parse($item['primeira_movimentacao'])->format('d/m/Y H:i') : '-' }}</td>
                                                    <td>{{ $item['ultima_movimentacao'] ? \Carbon\Carbon::parse($item['ultima_movimentacao'])->format('d/m/Y H:i') : '-' }}</td>
                                                    <td>{{ $item['total_movimentacoes'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted mb-0">Nenhum aluno com registro no período informado.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Alunos sem registro no período</h5>
                                <span class="badge bg-info">{{ $semRegistro->count() }}</span>
                            </div>
                            @if($semRegistro->count())
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
                                <p class="text-muted mb-0">Nenhum aluno sem registro no período informado.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    </div>
@endsection