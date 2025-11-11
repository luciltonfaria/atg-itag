@extends('layouts.guest')

@section('title', 'Cadastro')

@section('content')
<div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
    <div class="position-relative z-index-5">
        <div class="row gx-0">
            <!-- Coluna Esquerda - Formulário de Cadastro -->
            <div class="col-lg-6 col-xl-5 col-xxl-4">
                <div class="min-vh-100 bg-body row justify-content-center align-items-center p-5">
                    <div class="col-12 auth-card">
                        <a href="{{ route('dashboard') }}" class="text-nowrap logo-img d-block w-100">
                            <img src="http://localhost/site-laravel/public/assets/images/logos/logo-comprida.webp" class="dark-logo" alt="Logo-Dark" style="width: 80%;" />
                        </a>

                        <h2 class="mb-2 mt-4 fs-7 fw-bolder">Criar Conta</h2>
                        <p class="mb-4">Preencha seus dados para começar</p>

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Erro no cadastro!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Seu nome completo"
                                    required
                                    autofocus />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="seuemail@exemplo.com"
                                    required />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Mínimo 8 caracteres"
                                    required />
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                <input type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Digite a senha novamente"
                                    required />
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                                <iconify-icon icon="solar:user-plus-line-duotone" class="fs-5 me-2"></iconify-icon>
                                Criar Conta
                            </button>

                            <!-- Login Link -->
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="fs-4 mb-0 fw-medium">Já tem uma conta?</p>
                                <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">
                                    Fazer login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Imagem de Fundo Customizada -->
            <div class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden d-none d-lg-block"
                style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/images/backgrounds/login-bg.png') }}') center/cover no-repeat;">

                <div class="d-lg-flex align-items-center justify-content-center z-index-5 position-relative h-100 p-5">
                    <div class="row justify-content-center w-100">
                        <div class="col-lg-8 text-center">
                            <div class="mb-4">
                                <img src="{{ asset('assets/images/logos/logo-icon.svg') }}"
                                    alt="Logo"
                                    style="max-width: 120px; filter: brightness(0) invert(1);" />
                            </div>
                            <h2 class="text-white fs-10 mb-4 lh-sm fw-bold">
                                Junte-se a Nós
                            </h2>
                            <p class="opacity-75 fs-5 text-white d-block mb-4">
                                Crie sua conta e comece a gerenciar o controle de presença
                                <br />
                                da sua instituição de forma eficiente e segura.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .auth-card {
        max-width: 450px;
    }

    .radial-gradient {
        background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%);
    }

    .z-index-5 {
        z-index: 5;
    }

    .auth-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush
@endsection