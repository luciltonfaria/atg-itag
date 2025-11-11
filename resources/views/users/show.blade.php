@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Detalhes do Usuário</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-light">
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
                        <div class="round-100 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 100px; height: 100px;">
                            <iconify-icon icon="solar:user-line-duotone" class="fs-10 text-primary"></iconify-icon>
                        </div>

                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <p class="text-muted mb-3">{{ $user->email }}</p>

                        @if($user->escola)
                        <div class="alert alert-success py-2">
                            <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 me-1"></iconify-icon>
                            <strong>{{ $user->escola->nome }}</strong>
                        </div>
                        @else
                        <div class="alert alert-warning py-2">
                            <iconify-icon icon="solar:danger-triangle-line-duotone" class="fs-5 me-1"></iconify-icon>
                            <small>Sem escola associada</small>
                        </div>
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
                                <label class="form-label text-muted small">Nome Completo</label>
                                <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Email</label>
                                <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label text-muted small">Escola Associada</label>
                                <p class="mb-0">
                                    @if($user->escola)
                                    <span class="badge bg-success-subtle text-success fs-4 px-3 py-2">
                                        <iconify-icon icon="solar:buildings-2-line-duotone" class="me-1"></iconify-icon>
                                        {{ $user->escola->nome }}
                                    </span>
                                    @else
                                    <span class="badge bg-warning-subtle text-warning fs-4 px-3 py-2">
                                        <iconify-icon icon="solar:danger-triangle-line-duotone" class="me-1"></iconify-icon>
                                        Nenhuma escola associada
                                    </span>
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Data de Cadastro</label>
                                <p class="mb-0">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Última Atualização</label>
                                <p class="mb-0">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissões e Acesso -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Permissões e Acesso</h5>

                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    <iconify-icon icon="solar:shield-check-line-duotone" class="fs-5 me-2"></iconify-icon>
                                    @if($user->escola)
                                    <strong>Acesso Concedido:</strong> Este usuário pode visualizar todos os dados da escola <strong>{{ $user->escola->nome }}</strong>,
                                    incluindo turmas, alunos, presenças e relatórios.
                                    @else
                                    <strong>Acesso Limitado:</strong> Este usuário não está associado a nenhuma escola e terá acesso restrito ao sistema.
                                    <br><small>Para conceder acesso completo, edite o usuário e associe-o a uma escola.</small>
                                    @endif
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