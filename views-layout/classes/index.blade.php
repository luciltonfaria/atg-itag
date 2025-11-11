@extends('layouts.app')

@section('title', 'Turmas')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Header com título e botão -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Turmas</h4>
            <a href="{{ route('classes.create') }}" class="btn btn-primary">
                <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                Nova Turma
            </a>
        </div>

        <!-- Card de Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('classes.index') }}" class="row g-3">
                    <!-- Busca -->
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text"
                            class="form-control"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Código ou nome da turma">
                    </div>

                    <!-- Escola -->
                    <div class="col-md-4">
                        <label for="school_id" class="form-label">Escola</label>
                        <select class="form-select" id="school_id" name="school_id">
                            <option value="">Todas as escolas</option>
                            @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ano -->
                    <div class="col-md-2">
                        <label for="year" class="form-label">Ano</label>
                        <select class="form-select" id="year" name="year">
                            <option value="">Todos</option>
                            @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botões -->
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <iconify-icon icon="solar:magnifer-line-duotone" class="fs-5"></iconify-icon>
                            Filtrar
                        </button>
                        <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                            <iconify-icon icon="solar:restart-line-duotone" class="fs-5"></iconify-icon>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mensagens -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Card com Tabela -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Lista de Turmas
                </h5>
                <p class="card-subtitle mb-3 text-muted">
                    Total de {{ $classes->total() }} turma(s) cadastrada(s)
                </p>

                @if($classes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Escola</th>
                                <th>Ano</th>
                                <th class="text-center">Alunos</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $class->code }}
                                    </span>
                                </td>
                                <td class="fw-semibold">{{ $class->name }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 text-muted"></iconify-icon>
                                        {{ $class->school->name }}
                                    </div>
                                </td>
                                <td>
                                    @if($class->year)
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $class->year }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $class->enrollments()->count() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('classes.show', $class) }}"
                                            class="btn btn-sm btn-light"
                                            title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <a href="{{ route('classes.edit', $class) }}"
                                            class="btn btn-sm btn-light"
                                            title="Editar">
                                            <iconify-icon icon="solar:pen-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-light text-danger"
                                            onclick="confirmDelete({{ $class->id }})"
                                            title="Excluir">
                                            <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                                        </button>
                                    </div>

                                    <form id="delete-form-{{ $class->id }}"
                                        action="{{ route('classes.destroy', $class) }}"
                                        method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $classes->firstItem() }} a {{ $classes->lastItem() }} de {{ $classes->total() }} registros
                    </div>
                    {{ $classes->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <iconify-icon icon="solar:inbox-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted">Nenhuma turma encontrada.</p>
                    <a href="{{ route('classes.create') }}" class="btn btn-primary">
                        <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                        Cadastrar Primeira Turma
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        if (confirm('Tem certeza que deseja excluir esta turma?\n\nEsta ação não pode ser desfeita.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection