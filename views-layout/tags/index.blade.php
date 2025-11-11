@extends('layouts.app')

@section('title', 'Tags RFID')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Tags RFID / Crachás</h4>
            <a href="{{ route('tags.create') }}" class="btn btn-primary">
                <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                Nova Tag
            </a>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Buscar</label>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="EPC ou nome do aluno">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Escola</label>
                        <select class="form-select" name="school_id">
                            <option value="">Todas</option>
                            @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="active">
                            <option value="">Todas</option>
                            <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Ativas</option>
                            <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inativas</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <iconify-icon icon="solar:magnifer-line-duotone"></iconify-icon>
                            Filtrar
                        </button>
                        <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary">
                            <iconify-icon icon="solar:restart-line-duotone"></iconify-icon>
                        </a>
                    </div>
                </form>
            </div>
        </div>

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
        @endif>

        <!-- Tabela -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <iconify-icon icon="solar:card-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Lista de Tags RFID
                </h5>
                <p class="card-subtitle mb-3 text-muted">Total de {{ $tags->total() }} tag(s)</p>

                @if($tags->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>EPC</th>
                                <th>Aluno</th>
                                <th>Escola</th>
                                <th>Emitida em</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $tag->epc }}
                                    </span>
                                </td>
                                <td class="fw-semibold">
                                    <iconify-icon icon="solar:user-line-duotone" class="text-muted"></iconify-icon>
                                    {{ $tag->student->name }}
                                </td>
                                <td>
                                    <iconify-icon icon="solar:buildings-2-line-duotone" class="text-muted"></iconify-icon>
                                    {{ $tag->school->name }}
                                </td>
                                <td>
                                    {{ $tag->issued_at ? \Carbon\Carbon::parse($tag->issued_at)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if($tag->active)
                                    <span class="badge bg-success-subtle text-success">Ativa</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger">Inativa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('tags.show', $tag) }}" class="btn btn-sm btn-light" title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone"></iconify-icon>
                                        </a>
                                        <a href="{{ route('tags.edit', $tag) }}" class="btn btn-sm btn-light" title="Editar">
                                            <iconify-icon icon="solar:pen-line-duotone"></iconify-icon>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light text-danger"
                                            onclick="confirmDelete({{ $tag->id }})" title="Excluir">
                                            <iconify-icon icon="solar:trash-bin-trash-line-duotone"></iconify-icon>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $tag->id }}" action="{{ route('tags.destroy', $tag) }}" method="POST" class="d-none">
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
                        Mostrando {{ $tags->firstItem() }} a {{ $tags->lastItem() }} de {{ $tags->total() }}
                    </div>
                    {{ $tags->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <iconify-icon icon="solar:inbox-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted">Nenhuma tag encontrada.</p>
                    <a href="{{ route('tags.create') }}" class="btn btn-primary">
                        <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                        Cadastrar Primeira Tag
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
        if (confirm('Tem certeza que deseja excluir esta tag RFID?\n\nEsta ação não pode ser desfeita.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection