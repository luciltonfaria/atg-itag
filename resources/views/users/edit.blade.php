@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Editar Usuário</h4>
            <a href="{{ route('users.index') }}" class="btn btn-light">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Senha (opcional na edição) -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            <small class="text-muted">Mínimo 8 caracteres</small>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control"
                                id="password_confirmation" name="password_confirmation">
                        </div>

                        <!-- Escola Associada -->
                        <div class="col-12 mb-3">
                            <label for="escola_id" class="form-label">
                                Escola Associada
                                <iconify-icon icon="solar:info-circle-line-duotone" class="fs-5 text-info"
                                    title="O usuário terá acesso apenas aos dados desta escola"></iconify-icon>
                            </label>
                            <select class="form-select @error('escola_id') is-invalid @enderror"
                                id="escola_id" name="escola_id">
                                <option value="">Selecione uma escola (opcional)</option>
                                @foreach($escolas as $escola)
                                <option value="{{ $escola->id }}"
                                    {{ old('escola_id', $user->escola_id) == $escola->id ? 'selected' : '' }}>
                                    {{ $escola->nome }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Se não associar a uma escola, o usuário terá acesso limitado</small>
                            @error('escola_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if($user->escola)
                    <div class="alert alert-success">
                        <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
                        <strong>Escola Atual:</strong> {{ $user->escola->nome }}
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <iconify-icon icon="solar:danger-triangle-line-duotone" class="fs-5 me-2"></iconify-icon>
                        <strong>Atenção:</strong> Este usuário não está associado a nenhuma escola.
                    </div>
                    @endif

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <iconify-icon icon="solar:diskette-line-duotone" class="fs-5 me-1"></iconify-icon>
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection