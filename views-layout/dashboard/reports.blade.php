@extends('layouts.app')

@section('title', 'Relatórios Rápidos')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title fw-semibold mb-4">Relatórios Rápidos</h3>
                <div class="alert alert-info">
                    <iconify-icon icon="solar:graph-new-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Funcionalidade de relatórios rápidos em desenvolvimento
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