@extends('layouts.app')

@section('title', 'Escolas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Gerenciamento de Escolas</h4>
            <div class="alert alert-info mb-0 py-2 px-3">
                <iconify-icon icon="solar:info-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
                <small>Escolas são criadas automaticamente pela API iTAG</small>
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
                    <table class="table table-hover align-middle text-nowrap mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="width: 100px;">Logo</th>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Endereço</th>
                                <th class="text-center" style="width: 100px;">Status</th>
                                <th class="text-center" style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schools as $school)
                            <tr>
                                <td class="text-center">
                                    @if($school->logo)
                                    <img src="{{ asset('storage/' . $school->logo) }}"
                                        alt="Logo {{ $school->nome }}"
                                        class="rounded"
                                        style="width: 60px; height: 60px; object-fit: contain;"
                                        onerror="this.onerror=null; this.src='{{ asset('assets/images/logos/school-placeholder.svg') }}';" />
                                    @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-4 text-muted"></iconify-icon>
                                    </div>
                                    @endif
                                </td>
                                <td><strong>{{ $school->code }}</strong></td>
                                <td>{{ $school->nome }}</td>
                                <td>{{ $school->address ?? '-' }}</td>
                                <td class="text-center">
                                    @if($school->active)
                                    <span class="badge bg-success-subtle text-success">Ativa</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger">Inativa</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('schools.show', ['escola' => $school]) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <a href="{{ route('schools.edit', ['escola' => $school]) }}" class="btn btn-sm btn-warning" title="Editar Logo/Customizações">
                                            <iconify-icon icon="solar:pen-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-10 mb-3"></iconify-icon>
                                        <p class="mb-0">Nenhuma escola cadastrada</p>
                                        <small>As escolas serão criadas automaticamente quando a API iTAG detectar tags</small>
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