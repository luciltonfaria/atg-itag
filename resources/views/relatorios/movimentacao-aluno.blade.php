@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Relatório de Movimentações por Aluno</h4>
                    <p class="card-subtitle mb-3">Selecione turma, aluno e período para listar movimentações.</p>

                    <form method="GET" action="{{ route('relatorios.movimentacao-aluno') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label for="turma_id" class="form-label">Turma</label>
                                <select name="turma_id" id="turma_id" class="form-select">
                                    <option value="">Selecione...</option>
                                    @foreach($turmas as $t)
                                        <option value="{{ $t->id }}" {{ (request('turma_id') == $t->id) ? 'selected' : '' }}>
                                            {{ $t->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="aluno_id" class="form-label">Aluno</label>
                                <select name="aluno_id" id="aluno_id" class="form-select" required>
                                    <option value="">Selecione a turma primeiro...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="data_inicio" class="form-label">Data início</label>
                                <input type="date" name="data_inicio" id="data_inicio" value="{{ request('data_inicio') }}" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="data_fim" class="form-label">Data fim</label>
                                <input type="date" name="data_fim" id="data_fim" value="{{ request('data_fim') }}" class="form-control" required>
                            </div>
                            <div class="col-12 col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    @error('aluno_id')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                    @error('data_inicio')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                    @error('data_fim')
                        <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror

                    @if(isset($aluno) && $aluno)
                        <div class="mt-4">
                            <h5>Aluno selecionado: {{ $aluno->nome }} (Turma: {{ $aluno->turma->nome ?? '-' }})</h5>
                            <p class="text-muted mb-2">Período: {{ request('data_inicio') }} até {{ request('data_fim') }}</p>
                        </div>
                    @endif

                    @if(isset($movimentacoes) && $movimentacoes && $movimentacoes->count())
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a class="btn btn-primary"
                               href="{{ route('relatorios.movimentacao-aluno.export.csv', request()->only(['aluno_id','data_inicio','data_fim'])) }}">
                                Exportar Excel (CSV)
                            </a>
                            <a class="btn btn-info"
                               target="_blank"
                               href="{{ route('relatorios.movimentacao-aluno.export.print', request()->only(['aluno_id','data_inicio','data_fim'])) }}">
                                Exportar PDF
                            </a>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Data/Hora</th>
                                        <th>Antena</th>
                                        <th>RSSI</th>
                                        <th>Fonte</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($movimentacoes as $m)
                                        <tr>
                                            <td>{{ $m->seen_at }}</td>
                                            <td>{{ $m->antenna }}</td>
                                            <td>{{ $m->rssi }}</td>
                                            <td>{{ $m->source }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(request()->has('aluno_id'))
                        <div class="alert alert-info mt-4">Nenhuma movimentação encontrada para os filtros aplicados.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const turmaSelect = document.getElementById('turma_id');
    const alunoSelect = document.getElementById('aluno_id');

    function carregarAlunos(turmaId) {
        if (!turmaId) {
            alunoSelect.innerHTML = '<option value="">Selecione a turma primeiro...</option>';
            return;
        }
        fetch(`{{ route('turmas.alunos', ['turma' => 'TURMA_ID']) }}`.replace('TURMA_ID', turmaId))
            .then(resp => resp.json())
            .then(alunos => {
                const selectedAluno = '{{ request('aluno_id') }}';
                alunoSelect.innerHTML = '<option value="">Selecione...</option>' + alunos.map(a => {
                    const sel = (selectedAluno && selectedAluno == a.id) ? 'selected' : '';
                    return `<option value="${a.id}" ${sel}>${a.nome}</option>`;
                }).join('');
            })
            .catch(() => {
                alunoSelect.innerHTML = '<option value="">Erro ao carregar alunos</option>';
            });
    }

    turmaSelect.addEventListener('change', function () {
        carregarAlunos(this.value);
    });

    // Se a página já veio com turma selecionada, carregar os alunos
    if (turmaSelect.value) {
        carregarAlunos(turmaSelect.value);
    }
});
</script>
@endpush
@endsection