@extends('layouts.app')

@section('title', 'Editar Escola')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Editar Escola</h4>
            <a href="{{ route('schools.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informações da Escola</h4>
                <p class="card-subtitle mb-0">
                    Atualize os dados da escola <strong>{{ $school->name }}</strong>.
                </p>
            </div>

            <form action="{{ route('schools.update', $school) }}" method="POST" enctype="multipart/form-data" class="form-horizontal r-separator">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- Código -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="code" class="col-3 text-end col-form-label">
                                Código <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('code') is-invalid @enderror"
                                    id="code"
                                    name="code"
                                    value="{{ old('code', $school->code) }}"
                                    placeholder="Ex: ESC001"
                                    required />
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Código único para identificação da escola</small>
                            </div>
                        </div>
                    </div>

                    <!-- CNPJ -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="cnpj" class="col-3 text-end col-form-label">CNPJ</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('cnpj') is-invalid @enderror"
                                    id="cnpj"
                                    name="cnpj"
                                    value="{{ old('cnpj', $school->cnpj) }}"
                                    placeholder="00.000.000/0000-00"
                                    maxlength="18" />
                                @error('cnpj')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">CNPJ da instituição de ensino</small>
                            </div>
                        </div>
                    </div>

                    <!-- Nome -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="name" class="col-3 text-end col-form-label">
                                Nome <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $school->name) }}"
                                    placeholder="Nome completo da escola"
                                    required />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Logomarca -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="logo" class="col-3 text-end col-form-label">Logomarca</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                @if($school->logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $school->logo) }}"
                                        alt="Logo atual"
                                        class="img-thumbnail"
                                        style="max-width: 150px; max-height: 100px;" />
                                    <p class="mb-0 mt-1"><small class="text-muted">Logo atual</small></p>
                                </div>
                                @endif
                                <input type="file"
                                    class="form-control @error('logo') is-invalid @enderror"
                                    id="logo"
                                    name="logo"
                                    accept="image/*" />
                                @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Formatos aceitos: JPG, PNG, GIF, SVG (máx. 2MB)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Timezone -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="timezone" class="col-3 text-end col-form-label">Timezone</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('timezone') is-invalid @enderror"
                                    id="timezone"
                                    name="timezone">
                                    <option value="">Selecione o timezone</option>
                                    <option value="America/Sao_Paulo" {{ old('timezone', $school->timezone) == 'America/Sao_Paulo' ? 'selected' : '' }}>America/São Paulo (BRT)</option>
                                    <option value="America/Manaus" {{ old('timezone', $school->timezone) == 'America/Manaus' ? 'selected' : '' }}>America/Manaus (AMT)</option>
                                    <option value="America/Belem" {{ old('timezone', $school->timezone) == 'America/Belem' ? 'selected' : '' }}>America/Belém (BRT)</option>
                                    <option value="America/Fortaleza" {{ old('timezone', $school->timezone) == 'America/Fortaleza' ? 'selected' : '' }}>America/Fortaleza (BRT)</option>
                                    <option value="America/Recife" {{ old('timezone', $school->timezone) == 'America/Recife' ? 'selected' : '' }}>America/Recife (BRT)</option>
                                    <option value="America/Noronha" {{ old('timezone', $school->timezone) == 'America/Noronha' ? 'selected' : '' }}>America/Noronha (FNT)</option>
                                </select>
                                @error('timezone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Fuso horário da localização da escola</small>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="status" class="col-3 text-end col-form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('status') is-invalid @enderror"
                                    id="status"
                                    name="status"
                                    required>
                                    <option value="active" {{ old('status', $school->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                                    <option value="inactive" {{ old('status', $school->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Endereço -->
                <div class="card-body text-bg-light">
                    <h4 class="card-title mt-2 pb-3">
                        <iconify-icon icon="solar:map-point-line-duotone" class="fs-5 me-2"></iconify-icon>
                        Endereço
                    </h4>

                    <!-- CEP -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="cep" class="col-3 text-end col-form-label">CEP</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <div class="input-group">
                                    <input type="text"
                                        class="form-control @error('cep') is-invalid @enderror"
                                        id="cep"
                                        name="cep"
                                        value="{{ old('cep', $school->cep) }}"
                                        placeholder="00000-000"
                                        maxlength="9" />
                                    <span class="input-group-text" id="cep-loading" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" role="status"></span>
                                    </span>
                                </div>
                                @error('cep')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Digite o CEP e os dados serão preenchidos automaticamente</small>
                            </div>
                        </div>
                    </div>

                    <!-- Logradouro -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="logradouro" class="col-3 text-end col-form-label">Logradouro</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('logradouro') is-invalid @enderror"
                                    id="logradouro"
                                    name="logradouro"
                                    value="{{ old('logradouro', $school->logradouro) }}"
                                    placeholder="Rua, Avenida, etc." />
                                @error('logradouro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Número e Complemento -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="numero" class="col-3 text-end col-form-label">Número</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text"
                                            class="form-control @error('numero') is-invalid @enderror"
                                            id="numero"
                                            name="numero"
                                            value="{{ old('numero', $school->numero) }}"
                                            placeholder="Nº" />
                                        @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text"
                                            class="form-control @error('complemento') is-invalid @enderror"
                                            id="complemento"
                                            name="complemento"
                                            value="{{ old('complemento', $school->complemento) }}"
                                            placeholder="Complemento" />
                                        @error('complemento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bairro -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="bairro" class="col-3 text-end col-form-label">Bairro</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('bairro') is-invalid @enderror"
                                    id="bairro"
                                    name="bairro"
                                    value="{{ old('bairro', $school->bairro) }}"
                                    placeholder="Nome do bairro" />
                                @error('bairro')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cidade e Estado -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="cidade" class="col-3 text-end col-form-label">Cidade/Estado</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="text"
                                            class="form-control @error('cidade') is-invalid @enderror"
                                            id="cidade"
                                            name="cidade"
                                            value="{{ old('cidade', $school->cidade) }}"
                                            placeholder="Cidade" />
                                        @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select @error('estado') is-invalid @enderror"
                                            id="estado"
                                            name="estado">
                                            <option value="">UF</option>
                                            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                                            <option value="{{ $uf }}" {{ old('estado', $school->estado) == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                                            @endforeach
                                        </select>
                                        @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção de Integração iTAG -->
                <div class="card-body text-bg-light">
                    <h4 class="card-title mt-2 pb-3">
                        <iconify-icon icon="solar:link-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
                        Integração iTAG
                    </h4>

                    <!-- iTAG Base URL -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="itag_base_url" class="col-3 text-end col-form-label">Base URL</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="url"
                                    class="form-control @error('itag_base_url') is-invalid @enderror"
                                    id="itag_base_url"
                                    name="itag_base_url"
                                    value="{{ old('itag_base_url', $school->itag_base_url) }}"
                                    placeholder="https://api.itag.com.br" />
                                @error('itag_base_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">URL base da API iTAG</small>
                            </div>
                        </div>
                    </div>

                    <!-- iTAG Branch -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="itag_branch" class="col-3 text-end col-form-label">Branch</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text"
                                    class="form-control @error('itag_branch') is-invalid @enderror"
                                    id="itag_branch"
                                    name="itag_branch"
                                    value="{{ old('itag_branch', $school->itag_branch) }}"
                                    placeholder="Nome da filial no iTAG" />
                                @error('itag_branch')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <a href="{{ route('schools.index') }}" class="btn bg-danger-subtle text-danger ms-2">
                            <iconify-icon icon="solar:close-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('cep');
        const cepLoading = document.getElementById('cep-loading');

        // Máscara de CEP
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length > 5) {
                value = value.substring(0, 5) + '-' + value.substring(5, 8);
            }

            e.target.value = value;
        });

        // Buscar CEP ao sair do campo
        cepInput.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');

            if (cep.length !== 8) {
                return;
            }

            // Mostrar loading
            cepLoading.style.display = 'flex';

            // Buscar na API ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado!');
                        return;
                    }

                    // Preencher os campos
                    document.getElementById('logradouro').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';

                    // Focar no campo número
                    document.getElementById('numero').focus();
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    alert('Erro ao buscar CEP. Tente novamente.');
                })
                .finally(() => {
                    // Esconder loading
                    cepLoading.style.display = 'none';
                });
        });
    });
</script>
@endpush
@endsection