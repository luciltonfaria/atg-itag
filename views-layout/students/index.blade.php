@extends('layouts.app')

@section('title', 'Alunos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Alunos</h4>
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                Novo Aluno
            </a>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('students.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Nome ou código">
                    </div>
                    <div class="col-md-3">
                        <label for="school_id" class="form-label">Escola</label>
                        <select class="form-select" id="school_id" name="school_id">
                            <option value="">Todas</option>
                            @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="active" class="form-label">Status</label>
                        <select class="form-select" id="active" name="active">
                            <option value="">Todos</option>
                            <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Ativos</option>
                            <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inativos</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <iconify-icon icon="solar:magnifer-line-duotone"></iconify-icon>
                            Filtrar
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                            <iconify-icon icon="solar:restart-line-duotone"></iconify-icon>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mensagens -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Tabela -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Lista de Alunos
                </h5>
                <p class="card-subtitle mb-3 text-muted">Total de {{ $students->total() }} aluno(s)</p>

                @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Escola</th>
                                <th>Nascimento</th>
                                <th class="text-center">Tags</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td>
                                    @if($student->external_code)
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $student->external_code }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $student->name }}</td>
                                <td>
                                    <iconify-icon icon="solar:buildings-2-line-duotone" class="text-muted"></iconify-icon>
                                    {{ $student->school->name }}
                                </td>
                                <td>
                                    @if($student->birth_date)
                                    {{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}
                                    <small class="text-muted">({{ \Carbon\Carbon::parse($student->birth_date)->age }} anos)</small>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info">
                                        {{ $student->tags()->count() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($student->active)
                                    <span class="badge bg-success-subtle text-success">Ativo</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-light" title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone"></iconify-icon>
                                        </a>
                                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-light" title="Editar">
                                            <iconify-icon icon="solar:pen-line-duotone"></iconify-icon>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light text-danger"
                                            onclick="confirmDelete({{ $student->id }})" title="Excluir">
                                            <iconify-icon icon="solar:trash-bin-trash-line-duotone"></iconify-icon>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $student->id }}" action="{{ route('students.destroy', $student) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $students->firstItem() }} a {{ $students->lastItem() }} de {{ $students->total() }}
                    </div>
                    {{ $students->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <iconify-icon icon="solar:inbox-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted">Nenhum aluno encontrado.</p>
                    <a href="{{ route('students.create') }}" class="btn btn-primary">
                        <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                        Cadastrar Primeiro Aluno
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
        if (confirm('Tem certeza que deseja excluir este aluno?\n\nEsta ação não pode ser desfeita.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection