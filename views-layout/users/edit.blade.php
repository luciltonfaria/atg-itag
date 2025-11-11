@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Editar Usuário</h4>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informações do Usuário</h4>
                <p class="card-subtitle mb-0">
                    Atualize os dados do usuário <strong>{{ $user->name }}</strong>.
                </p>
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST" class="form-horizontal r-separator">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- Nome -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="name" class="col-3 text-end col-form-label">
                                Nome Completo <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    placeholder="Nome completo do usuário"
                                    required
                                    autofocus />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="email" class="col-3 text-end col-form-label">
                                E-mail <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="usuario@exemplo.com"
                                    required />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Este e-mail será usado para login no sistema</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Alteração de Senha -->
                <div class="card-body text-bg-light">
                    <h4 class="card-title mt-2 pb-3">
                        <iconify-icon icon="solar:lock-keyhole-line-duotone" class="fs-5 me-2"></iconify-icon>
                        Alterar Senha
                    </h4>
                    <p class="text-muted mb-3">Deixe os campos em branco para manter a senha atual</p>

                    <!-- Nova Senha -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="password" class="col-3 text-end col-form-label">
                                Nova Senha
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Mínimo 8 caracteres" />
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Mínimo de 8 caracteres (deixe vazio para não alterar)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmar Nova Senha -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="password_confirmation" class="col-3 text-end col-form-label">
                                Confirmar Senha
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Digite a senha novamente" />
                                <small class="form-text text-muted">Digite a mesma senha para confirmação</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Escolas -->
                <div class="card-body">
                    <h4 class="card-title mt-2 pb-3">
                        <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 me-2"></iconify-icon>
                        Escolas Vinculadas
                    </h4>

                    <!-- Escolas -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="schools" class="col-3 text-end col-form-label">Escolas como Admin</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('schools') is-invalid @enderror"
                                    id="schools"
                                    name="schools[]"
                                    multiple
                                    size="6">
                                    @forelse($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ in_array($school->id, old('schools', $user->schools->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $school->name }} ({{ $school->code }})
                                    </option>
                                    @empty
                                    <option disabled>Nenhuma escola cadastrada</option>
                                    @endforelse
                                </select>
                                @error('schools')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Segure Ctrl (ou Cmd no Mac) para selecionar múltiplas escolas. O usuário será administrador das escolas selecionadas.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="card-body">
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-primary">
                            <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                            Atualizar
                        </button>
                        <a href="{{ route('users.index') }}" class="btn bg-danger-subtle text-danger ms-2">
                            <iconify-icon icon="solar:close-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection