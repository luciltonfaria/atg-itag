@extends('layouts.app')

@section('title', 'Mapa do Campus')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title fw-semibold mb-4">Mapa do Campus</h3>
                <div class="alert alert-info">
                    <iconify-icon icon="solar:map-point-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Funcionalidade de mapa interativo em desenvolvimento
                </div>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="me-1"></iconify-icon>
                    Voltar ao Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection