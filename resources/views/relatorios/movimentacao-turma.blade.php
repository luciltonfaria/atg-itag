@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Relatório de Movimentações por Turma</h4>
                    <p class="card-subtitle mb-3">Filtre por período e turma para listar as movimentações com o nome do aluno.</p>

                    <form method="GET" action="{{ route('relatorios.movimentacao-turma') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="turma_id" class="form-label">Turma</label>
                                <select name="turma_id" id="turma_id" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    @foreach($turmas as $t)
                                        <option value="{{ $t->id }}" {{ (request('turma_id') == $t->id) ? 'selected' : '' }}>
                                            {{ $t->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="data_inicio" class="form-label">Data início</label>
                                <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="data_fim" class="form-label">Data fim</label>
                                <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}" class="form-control" required>
                            </div>
                            <div class="col-md-2 d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    @error('turma_id')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                    @error('data_inicio')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                    @error('data_fim')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror

                    @if(isset($turma))
                        <div class="mt-4">
                            <h5>Turma selecionada: {{ $turma->nome }}</h5>
                            <p class="text-muted mb-2">Período: {{ request('data_inicio') }} até {{ request('data_fim') }}</p>
                        </div>
                    @endif

                    @if(isset($eventos) && $eventos && $eventos->count())
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a class="btn btn-primary"
                               href="{{ route('relatorios.movimentacao-turma.export.csv', request()->only(['turma_id','data_inicio','data_fim'])) }}">
                                Exportar Excel (CSV)
                            </a>
                            <a class="btn btn-info"
                               target="_blank"
                               href="{{ route('relatorios.movimentacao-turma.export.print', request()->only(['turma_id','data_inicio','data_fim'])) }}">
                                Exportar PDF
                            </a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Data/Hora</th>
                                        <th>Aluno</th>
                                        <th>Turma</th>
                                        <th>Antena</th>
                                        <th>RSSI</th>
                                        <th>Fonte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventos as $ev)
                                        <tr>
                                            <td>{{ $ev->seen_at }}</td>
                                            <td>{{ $ev->aluno_nome }}</td>
                                            <td>{{ $ev->turma_nome }}</td>
                                            <td>{{ $ev->antenna }}</td>
                                            <td>{{ $ev->rssi }}</td>
                                            <td>{{ $ev->source }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(request()->has('turma_id'))
                        <div class="alert alert-info mt-4">Nenhuma movimentação encontrada para os filtros aplicados.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection