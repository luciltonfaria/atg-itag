@extends('layouts.app')

@section('title', 'Escolas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Gerenciamento de Escolas</h4>
            <div>
                <a href="{{ route('schools.create') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Nova Escola
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-nowrap">
                        <thead class="text-bg-primary">
                            <tr>
                                <th style="width: 80px;">Logo</th>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Timezone</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schools as $school)
                            <tr>
                                <td class="text-center">
                                    @if($school->logo)
                                    <img src="{{ asset('storage/' . $school->logo) }}"
                                        alt="Logo {{ $school->name }}"
                                        class="rounded"
                                        style="width: 50px; height: 50px; object-fit: contain;" />
                                    @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <iconify-icon icon="solar:building-line-duotone" class="fs-5 text-muted"></iconify-icon>
                                    </div>
                                    @endif
                                </td>
                                <td><strong>{{ $school->code }}</strong></td>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->timezone ?? '-' }}</td>
                                <td>
                                    @if($school->status === 'active')
                                    <span class="badge bg-success-subtle text-success">Ativo</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger">Inativo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('schools.show', $school) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <a href="{{ route('schools.edit', $school) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <iconify-icon icon="solar:pen-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <form action="{{ route('schools.destroy', $school) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta escola?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <iconify-icon icon="solar:document-line-duotone" class="fs-8 mb-2"></iconify-icon>
                                        <p class="mb-0">Nenhuma escola cadastrada</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($schools->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $schools->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection