@extends('layouts.app')

@section('title', 'Customizar Escola')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1 fw-semibold">Customizar Escola</h4>
                <small class="text-muted">Adicione logomarca e personalize informações da escola</small>
            </div>
            <a href="{{ route('schools.index') }}" class="btn btn-light">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('schools.update', ['escola' => $school]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome da Escola <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                id="nome" name="nome" value="{{ old('nome', $school->nome) }}" required>
                            @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Código (readonly - vem da API) -->
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Código <span class="badge bg-secondary-subtle text-secondary">Da API iTAG</span></label>
                            <input type="text" class="form-control"
                                id="code" value="{{ $school->code ?? 'Sem código' }}" readonly disabled>
                            <small class="text-muted">Código único gerado pela API iTAG (não editável)</small>
                        </div>

                        <!-- Endereço -->
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Endereço</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                id="address" name="address" rows="2">{{ old('address', $school->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo Atual -->
                        @if($school->logo)
                        <div class="col-12 mb-3">
                            <label class="form-label">Logomarca Atual</label>
                            <div class="border rounded p-3 d-inline-block">
                                <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo {{ $school->nome }}" style="max-height: 100px;"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/logos/school-placeholder.svg') }}';">
                            </div>
                        </div>
                        @endif

                        <!-- Nova Logo -->
                        <div class="col-md-6 mb-3">
                            <label for="logo" class="form-label">{{ $school->logo ? 'Alterar Logomarca' : 'Logomarca' }}</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Formatos: JPG, PNG, GIF, WEBP (max: 2MB)</small>
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview da Nova Logo -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preview</label>
                            <div id="logo-preview" class="border rounded p-3 text-center" style="min-height: 100px;">
                                <iconify-icon icon="solar:gallery-add-line-duotone" class="fs-10 text-muted"></iconify-icon>
                                <p class="text-muted mb-0 small">Selecione uma nova imagem</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active"
                                    {{ old('active', $school->active) ? 'checked' : '' }}>
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
                            Atualizar
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