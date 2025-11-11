@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
    <div class="position-relative z-index-5">
        <div class="row gx-0">
            <!-- Coluna Esquerda - Formulário de Login -->
            <div class="col-lg-6 col-xl-5 col-xxl-4">
                <div class="min-vh-100 bg-body row justify-content-center align-items-center p-5">
                    <div class="col-12 auth-card">
                        <a href="{{ route('dashboard') }}" class="text-nowrap logo-img d-block w-100">
                            <img src="http://localhost/site-laravel/public/assets/images/logos/logo-comprida.webp" class="dark-logo" alt="Logo-Dark" style="width: 60%;" />
                        </a>

                        <h2 class="mb-2 mt-4 fs-7 fw-bolder">Bem-vindo</h2>
                        <p class="mb-4">Sistema de Controle de Presença RFID</p>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Erro ao fazer login!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="seuemail@exemplo.com"
                                    required
                                    autofocus />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Digite sua senha"
                                    required />
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input primary"
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label text-dark" for="remember">
                                        Lembrar-me
                                    </label>
                                </div>
                                <a class="text-primary fw-medium" href="{{ route('password.request') }}">
                                    Esqueceu a senha?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                                <iconify-icon icon="solar:login-3-line-duotone" class="fs-5 me-2"></iconify-icon>
                                Entrar
                            </button>

                            <!-- Register Link -->
                            <div class="d-flex align-items-center justify-content-center">
                                <p class="fs-4 mb-0 fw-medium">Novo por aqui?</p>
                                <a class="text-primary fw-medium ms-2" href="{{ route('register') }}">
                                    Criar uma conta
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

    /* Animação suave ao carregar */
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

    /* Efeito hover no botão */
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