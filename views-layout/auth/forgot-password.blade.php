@extends('layouts.guest')

@section('title', 'Recuperar Senha')

@section('content')
<div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
    <div class="position-relative z-index-5">
        <div class="row gx-0">
            <!-- Coluna Esquerda - Formulário -->
            <div class="col-lg-6 col-xl-5 col-xxl-4">
                <div class="min-vh-100 bg-body row justify-content-center align-items-center p-5">
                    <div class="col-12 auth-card">
                        <a href="{{ route('dashboard') }}" class="text-nowrap logo-img d-block w-100">
                            <img src="http://localhost/site-laravel/public/assets/images/logos/logo-comprida.webp" class="dark-logo" alt="Logo-Dark" style="width: 80%;" />
                        </a>

                        <h2 class="mb-2 mt-4 fs-7 fw-bolder">Esqueceu a Senha?</h2>
                        <p class="mb-4">Digite seu e-mail e enviaremos um link para redefinir sua senha.</p>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-4">
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

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                                <iconify-icon icon="solar:letter-line-duotone" class="fs-5 me-2"></iconify-icon>
                                Enviar Link de Recuperação
                            </button>

                            <!-- Back to Login -->
                            <div class="d-flex align-items-center justify-content-center">
                                <a class="text-primary fw-medium" href="{{ route('login') }}">
                                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                                    Voltar ao Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita - Imagem de Fundo -->
            <div class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden d-none d-lg-block"
                style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/images/backgrounds/login-bg.png') }}') center/cover no-repeat;">

                <div class="d-lg-flex align-items-center justify-content-center z-index-5 position-relative h-100 p-5">
                    <div class="row justify-content-center w-100">
                        <div class="col-lg-8 text-center">
                            <iconify-icon icon="solar:lock-password-bold-duotone" class="text-white" style="font-size: 120px;"></iconify-icon>
                            <h2 class="text-white fs-9 mb-3 lh-sm fw-bold mt-4">
                                Recuperação de Senha
                            </h2>
                            <p class="opacity-75 fs-5 text-white d-block">
                                Não se preocupe! Enviaremos instruções para você redefinir sua senha.
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