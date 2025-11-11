@extends('layouts.app')

@section('title', 'Nova Escola')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Nova Escola</h4>
            <a href="{{ route('schools.index') }}" class="btn btn-light">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('schools.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nome da Escola <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Código -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Código <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                id="code" name="code" value="{{ old('code') }}" required>
                            <small class="text-muted">Código único para identificação</small>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Endereço -->
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Endereço</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                id="address" name="address" rows="2">{{ old('address') }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo -->
                        <div class="col-md-6 mb-3">
                            <label for="logo" class="form-label">Logomarca</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Formatos: JPG, PNG, GIF, WEBP (max: 2MB)</small>
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview da Logo -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preview</label>
                            <div id="logo-preview" class="border rounded p-3 text-center" style="min-height: 100px;">
                                <iconify-icon icon="solar:gallery-add-line-duotone" class="fs-10 text-muted"></iconify-icon>
                                <p class="text-muted mb-0 small">Selecione uma imagem</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active" checked>
                                <label class="form-check-label" for="active">
                                    Escola Ativa
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('schools.index') }}" class="btn btn-light">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <iconify-icon icon="solar:diskette-line-duotone" class="fs-5 me-1"></iconify-icon>
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('logo-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" class="img-fluid" style="max-height: 150px;">';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush