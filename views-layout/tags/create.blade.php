@extends('layouts.app')

@section('title', 'Nova Tag RFID')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Nova Tag RFID</h4>
            <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Informações da Tag RFID</h4>
                <p class="card-subtitle mb-0">Preencha os dados abaixo para cadastrar uma nova tag RFID.</p>
            </div>

            <form action="{{ route('tags.store') }}" method="POST" class="form-horizontal r-separator">
                @csrf

                <div class="card-body">
                    <!-- EPC -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="epc" class="col-3 text-end col-form-label">
                                Código EPC <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="text" class="form-control @error('epc') is-invalid @enderror"
                                    id="epc" name="epc" value="{{ old('epc') }}"
                                    placeholder="Ex: E2806894000050247F32A1B7" maxlength="64" required />
                                @error('epc')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Código único do crachá RFID</small>
                            </div>
                        </div>
                    </div>

                    <!-- Escola -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="school_id" class="col-3 text-end col-form-label">
                                Escola <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('school_id') is-invalid @enderror"
                                    id="school_id" name="school_id" required>
                                    <option value="">Selecione a escola</option>
                                    @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id', request('school_id')) == $school->id ? 'selected' : '' }}>
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

                    <!-- Aluno -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="student_id" class="col-3 text-end col-form-label">
                                Aluno <span class="text-danger">*</span>
                            </label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <select class="form-select @error('student_id') is-invalid @enderror"
                                    id="student_id" name="student_id" required>
                                    <option value="">Selecione o aluno</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', request('student_id')) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} - {{ $student->school->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data de Emissão -->
                    <div class="form-group mb-0">
                        <div class="row align-items-center">
                            <label for="issued_at" class="col-3 text-end col-form-label">Data de Emissão</label>
                            <div class="col-9 border-start pb-2 pt-2">
                                <input type="date" class="form-control @error('issued_at') is-invalid @enderror"
                                    id="issued_at" name="issued_at" value="{{ old('issued_at', date('Y-m-d')) }}" />
                                @error('issued_at')
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
                                        {{ old('active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Tag ativa</label>
                                </div>
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
                        <a href="{{ route('tags.index') }}" class="btn bg-danger-subtle text-danger ms-2">
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