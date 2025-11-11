@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Detalhes do Usuário</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Informações do Usuário -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <iconify-icon icon="solar:user-rounded-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Informações do Usuário
                </h4>
            </div>

            <div class="card-body r-separator">
                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">ID</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <span class="badge bg-primary-subtle text-primary fs-3">#{{ $user->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Nome</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">{{ $user->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">E-mail</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0">
                                <iconify-icon icon="solar:letter-line-duotone" class="text-info fs-5 me-2"></iconify-icon>
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Cadastrado em</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0 text-muted">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Última atualização</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            <p class="mb-0 text-muted">
                                {{ $user->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Escolas Vinculadas -->
            <div class="card-body text-bg-light r-separator">
                <h4 class="card-title mt-2 pb-3">
                    <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Escolas Vinculadas
                </h4>

                <div class="form-group mb-0">
                    <div class="row align-items-center">
                        <label class="col-3 text-end col-form-label fw-semibold">Escolas como Admin</label>
                        <div class="col-9 border-start pb-2 pt-2">
                            @if($user->schools->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($user->schools as $school)
                                <li class="mb-2">
                                    <iconify-icon icon="solar:buildings-3-line-duotone" class="text-primary fs-5 me-2"></iconify-icon>
                                    <strong>{{ $school->name }}</strong>
                                    <span class="badge bg-{{ $school->pivot->role == 'ADMIN' ? 'success' : 'info' }}-subtle text-{{ $school->pivot->role == 'ADMIN' ? 'success' : 'info' }} ms-2">
                                        {{ $school->pivot->role }}
                                    </span>
                                    <br>
                                    <small class="text-muted ms-4">Código: {{ $school->code }}</small>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="mb-0 text-muted">Nenhuma escola vinculada</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-info-subtle border-0">
                    <div class="card-body text-center">
                        <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-8 text-info mb-3"></iconify-icon>
                        <h3 class="mb-1 text-info">{{ $user->schools->count() }}</h3>
                        <p class="mb-0 text-dark">Escola(s) Vinculada(s)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection