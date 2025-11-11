@extends('layouts.app')

@section('title', 'Detalhes da Escola')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Detalhes da Escola</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('schools.edit', ['escola' => $school]) }}" class="btn btn-warning">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('schools.index') }}" class="btn btn-light">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Voltar
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Card Principal -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($school->logo)
                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo {{ $school->nome }}"
                            class="img-fluid rounded mb-3" style="max-height: 200px;"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/logos/school-placeholder.svg') }}';">
                        @else
                        <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-10 text-muted"></iconify-icon>
                        </div>
                        @endif

                        <h3 class="mb-1">{{ $school->nome }}</h3>
                        <p class="text-muted mb-3">{{ $school->code }}</p>

                        @if($school->active)
                        <span class="badge bg-success-subtle text-success fs-4 px-3 py-2">
                            <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
                            Escola Ativa
                        </span>
                        @else
                        <span class="badge bg-danger-subtle text-danger fs-4 px-3 py-2">
                            <iconify-icon icon="solar:close-circle-bold" class="me-1"></iconify-icon>
                            Escola Inativa
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informações Detalhadas -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Informações</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Nome da Escola</label>
                                <p class="mb-0 fw-semibold">{{ $school->nome }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Código</label>
                                <p class="mb-0 fw-semibold">{{ $school->code }}</p>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label text-muted small">Endereço</label>
                                <p class="mb-0">{{ $school->address ?? 'Não informado' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Data de Cadastro</label>
                                <p class="mb-0">{{ $school->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Última Atualização</label>
                                <p class="mb-0">{{ $school->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estatísticas (exemplo) -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Estatísticas</h5>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                                        <iconify-icon icon="solar:book-2-line-duotone" class="fs-6 text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $school->turmas()->count() }}</h4>
                                        <p class="mb-0 text-muted">Turmas</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center round-48 bg-success-subtle rounded flex-shrink-0">
                                        <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-6 text-success"></iconify-icon>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">0</h4>
                                        <p class="mb-0 text-muted">Alunos</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center round-48 bg-info-subtle rounded flex-shrink-0">
                                        <iconify-icon icon="solar:tag-line-duotone" class="fs-6 text-info"></iconify-icon>
                                    </div>
                                    <div>
                                        <h4 class="mb-0">0</h4>
                                        <p class="mb-0 text-muted">Tags</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection