@extends('layouts.app')

@section('title', 'Detalhes da Escola')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Detalhes da Escola</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('schools.edit', $school) }}" class="btn btn-warning">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Informações Principais -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Informações da Escola
                </h4>
            </div>

            <div class="card-body r-separator">
                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Código</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <span class="badge bg-primary-subtle text-primary fs-3">{{ $school->code }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">CNPJ</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $school->cnpj ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Nome</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $school->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Logomarca</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            @if($school->logo)
                            <img src="{{ asset('storage/' . $school->logo) }}"
                                alt="Logo {{ $school->name }}"
                                class="img-thumbnail"
                                style="max-width: 200px; max-height: 120px;" />
                            @else
                            <p class="mb-0 text-muted">Sem logo cadastrada</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Timezone</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $school->timezone ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Status</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            @if($school->status === 'active')
                            <span class="badge bg-success-subtle text-success fs-3">
                                <iconify-icon icon="solar:check-circle-line-duotone" class="fs-4"></iconify-icon>
                                Ativo
                            </span>
                            @else
                            <span class="badge bg-danger-subtle text-danger fs-3">
                                <iconify-icon icon="solar:close-circle-line-duotone" class="fs-4"></iconify-icon>
                                Inativo
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção Endereço -->
            <div class="card-body text-bg-light r-separator">
                <h4 class="card-title mt-2 pb-3">
                    <iconify-icon icon="solar:map-point-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Endereço
                </h4>

                @if($school->cep || $school->logradouro || $school->cidade)
                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">CEP</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $school->cep ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Logradouro</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">
                                {{ $school->logradouro ?? '-' }}
                                @if($school->numero), {{ $school->numero }}@endif
                                @if($school->complemento) - {{ $school->complemento }}@endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Bairro</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $school->bairro ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Cidade/Estado</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">
                                {{ $school->cidade ?? '-' }}
                                @if($school->estado) / {{ $school->estado }}@endif
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <p class="text-muted mb-0">Endereço não cadastrado</p>
                @endif
            </div>

            <!-- Seção Administradores -->
            <div class="card-body r-separator">
                <h4 class="card-title mt-2 pb-3">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Administradores da Escola
                </h4>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Usuários Admins</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            @if($school->administrators->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($school->administrators as $admin)
                                <li class="mb-2">
                                    <iconify-icon icon="solar:user-check-rounded-line-duotone" class="text-success fs-5 me-2"></iconify-icon>
                                    <strong>{{ $admin->name }}</strong>
                                    <br>
                                    <small class="text-muted ms-4">{{ $admin->email }}</small>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="mb-0 text-muted">Nenhum administrador cadastrado</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção iTAG -->
            <div class="card-body text-bg-light r-separator">
                <h4 class="card-title mt-2 pb-3">
                    <iconify-icon icon="solar:link-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Integração iTAG
                </h4>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Base URL</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            @if($school->itag_base_url)
                            <a href="{{ $school->itag_base_url }}" target="_blank" class="text-decoration-none">
                                {{ $school->itag_base_url }}
                                <iconify-icon icon="solar:link-line-duotone" class="fs-4 ms-1"></iconify-icon>
                            </a>
                            @else
                            <p class="mb-0 text-muted">-</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Branch</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $school->itag_branch ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações de Data -->
            <div class="card-body">
                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Criado em</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0 text-muted">
                                {{ $school->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Atualizado em</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0 text-muted">
                                {{ $school->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary-subtle border-0">
                    <div class="card-body text-center">
                        <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="fs-8 text-primary mb-3"></iconify-icon>
                        <h3 class="mb-1 text-primary">{{ $school->classes->count() }}</h3>
                        <p class="mb-0 text-dark">Turmas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success-subtle border-0">
                    <div class="card-body text-center">
                        <iconify-icon icon="solar:user-rounded-line-duotone" class="fs-8 text-success mb-3"></iconify-icon>
                        <h3 class="mb-1 text-success">{{ $school->students->count() }}</h3>
                        <p class="mb-0 text-dark">Alunos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning-subtle border-0">
                    <div class="card-body text-center">
                        <iconify-icon icon="solar:card-line-duotone" class="fs-8 text-warning mb-3"></iconify-icon>
                        <h3 class="mb-1 text-warning">{{ $school->readers->count() }}</h3>
                        <p class="mb-0 text-dark">Leitores</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection