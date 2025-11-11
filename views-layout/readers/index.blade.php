@extends('layouts.app')

@section('title', 'Antenas / Leitores RFID')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Antenas / Leitores RFID</h4>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Buscar</label>
                        <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                            placeholder="Código, nome ou IP">
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
                    <div class="col-md-2">
                        <label class="form-label">Zona</label>
                        <select class="form-select" name="zone">
                            <option value="">Todas</option>
                            <option value="ENTRADA" {{ request('zone') == 'ENTRADA' ? 'selected' : '' }}>Entrada</option>
                            <option value="SAIDA" {{ request('zone') == 'SAIDA' ? 'selected' : '' }}>Saída</option>
                            <option value="BIBLIOTECA" {{ request('zone') == 'BIBLIOTECA' ? 'selected' : '' }}>Biblioteca</option>
                            <option value="REFEITORIO" {{ request('zone') == 'REFEITORIO' ? 'selected' : '' }}>Refeitório</option>
                            <option value="OUTRO" {{ request('zone') == 'OUTRO' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="active">
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
                        <a href="{{ route('readers.index') }}" class="btn btn-outline-secondary">
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

        <!-- Tabela -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <iconify-icon icon="solar:signal-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Lista de Leitores
                </h5>
                <p class="card-subtitle mb-3 text-muted">Total de {{ $readers->total() }} leitor(es)</p>

                @if($readers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Zona</th>
                                <th>Localização</th>
                                <th>IP</th>
                                <th>Escola</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($readers as $reader)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $reader->code }}
                                    </span>
                                </td>
                                <td class="fw-semibold">{{ $reader->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $reader->zone == 'ENTRADA' ? 'success' : ($reader->zone == 'SAIDA' ? 'danger' : 'info') }}-subtle text-{{ $reader->zone == 'ENTRADA' ? 'success' : ($reader->zone == 'SAIDA' ? 'danger' : 'info') }}">
                                        {{ $reader->zone }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ $reader->building ?? '-' }}
                                        @if($reader->floor), {{ $reader->floor }}@endif
                                    </small>
                                </td>
                                <td><code>{{ $reader->ip ?? '-' }}</code></td>
                                <td>
                                    <iconify-icon icon="solar:buildings-2-line-duotone" class="text-muted"></iconify-icon>
                                    {{ $reader->school->name }}
                                </td>
                                <td class="text-center">
                                    @if($reader->active)
                                    <span class="badge bg-success-subtle text-success">Ativo</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger">Inativo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('readers.show', $reader) }}" class="btn btn-sm btn-light" title="Visualizar">
                                        <iconify-icon icon="solar:eye-line-duotone"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $readers->firstItem() }} a {{ $readers->lastItem() }} de {{ $readers->total() }}
                    </div>
                    {{ $readers->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <iconify-icon icon="solar:inbox-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted">Nenhum leitor encontrado.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection