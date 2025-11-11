@extends('layouts.app')

@section('title', $title ?? 'Página')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <iconify-icon icon="solar:settings-linear" class="fs-10 text-primary mb-3 d-block"></iconify-icon>
                <h3 class="mb-2">{{ $title ?? 'Página em Desenvolvimento' }}</h3>
                <p class="text-muted mb-4">Esta funcionalidade está sendo desenvolvida e estará disponível em breve.</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="me-1"></iconify-icon>
                    Voltar ao Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection