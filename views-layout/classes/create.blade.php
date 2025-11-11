@extends('layouts.app')

@section('title', 'Nova Turma')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Nova Turma</h4>
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informações da Turma</h4>
                <p class="card-subtitle mb-0">
                    Preencha os dados abaixo para cadastrar uma nova turma no sistema.
                </p>
            </div>

            <form action="{{ route('classes.store') }}" method="POST" class="form-horizontal r-separator">
                @csrf

                <div class="card-body">
                    <!-- Escola -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="school_id" class="col-3 text-end col-form-label">
                                Escola <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('school_id') is-invalid @enderror"
                                    id="school_id"
                                    name="school_id"
                                    required>
                                    <option value="">Selecione a escola</option>
                                    @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Escola à qual a turma pertence</small>
                            </div>
                        </div>
                    </div>

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
                                    value="{{ old('code') }}"
                                    placeholder="Ex: 1A, 2B, 3ANO-MAT"
                                    maxlength="64"
                                    required />
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Código único da turma dentro da escola</small>
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
                                    value="{{ old('name') }}"
                                    placeholder="Nome completo da turma"
                                    required />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Ex: 1º Ano A, Turma da Manhã, etc.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Ano -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="year" class="col-3 text-end col-form-label">Ano Letivo</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="number"
                                    class="form-control @error('year') is-invalid @enderror"
                                    id="year"
                                    name="year"
                                    value="{{ old('year', date('Y')) }}"
                                    min="2000"
                                    max="2100"
                                    placeholder="{{ date('Y') }}" />
                                @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Ano letivo da turma (ex: {{ date('Y') }})</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="card-body">
                    <div class="form-group mb-0 text-end">
                        <button type="submit" class="btn btn-primary">
                            <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                            Salvar
                        </button>
                        <a href="{{ route('classes.index') }}" class="btn bg-danger-subtle text-danger ms-2">
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