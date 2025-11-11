@extends('layouts.app')

@section('title', 'Editar Aluno')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Editar Aluno</h4>
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informações do Aluno</h4>
                <p class="card-subtitle mb-0">
                    Atualize os dados do aluno <strong>{{ $student->name }}</strong>.
                </p>
            </div>

            <form action="{{ route('students.update', $student) }}" method="POST" class="form-horizontal r-separator">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- Escola -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="school_id" class="col-3 text-end col-form-label">
                                Escola <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('school_id') is-invalid @enderror" id="school_id" name="school_id" required>
                                    <option value="">Selecione a escola</option>
                                    @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id', $student->school_id) == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Código Externo -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="external_code" class="col-3 text-end col-form-label">Matrícula</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text" class="form-control @error('external_code') is-invalid @enderror"
                                    id="external_code" name="external_code" value="{{ old('external_code', $student->external_code) }}"
                                    placeholder="Ex: 2024001" maxlength="64" />
                                @error('external_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Número de matrícula ou código do aluno</small>
                            </div>
                        </div>
                    </div>

                    <!-- Nome -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="first_name" class="col-3 text-end col-form-label">
                                Nome <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                                    placeholder="Nome do aluno" required />
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Sobrenome -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="last_name" class="col-3 text-end col-form-label">
                                Sobrenome <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                                    placeholder="Sobrenome do aluno" required />
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="birth_date" class="col-3 text-end col-form-label">Data de Nascimento</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date" value="{{ old('birth_date', $student->birth_date) }}"
                                    max="{{ date('Y-m-d') }}" />
                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="active" class="col-3 text-end col-form-label">Status</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="active" name="active"
                                        {{ old('active', $student->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Aluno ativo</label>
                                </div>
                                <small class="form-text text-muted">Desmarque para inativar o aluno</small>
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
                        <a href="{{ route('students.index') }}" class="btn bg-danger-subtle text-danger ms-2">
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