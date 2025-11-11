@extends('layouts.app')

@section('title', 'Detalhes da Tag RFID')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Detalhes da Tag RFID</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('tags.edit', $tag) }}" class="btn btn-primary">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Voltar
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary-subtle">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:card-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Informações da Tag RFID
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Código EPC</label>
                            <p class="mb-0 fw-semibold">
                                <span class="badge bg-primary-subtle text-primary fs-5">{{ $tag->epc }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Aluno</label>
                            <p class="mb-0 fw-semibold">
                                <iconify-icon icon="solar:user-line-duotone" class="text-primary"></iconify-icon>
                                <a href="{{ route('students.show', $tag->student) }}">{{ $tag->student->name }}</a>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Escola</label>
                            <p class="mb-0">
                                <iconify-icon icon="solar:buildings-2-line-duotone" class="text-primary"></iconify-icon>
                                <a href="{{ route('schools.show', $tag->school) }}">{{ $tag->school->name }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Data de Emissão</label>
                            <p class="mb-0">{{ $tag->issued_at ? \Carbon\Carbon::parse($tag->issued_at)->format('d/m/Y') : '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Data de Revogação</label>
                            <p class="mb-0">{{ $tag->revoked_at ? \Carbon\Carbon::parse($tag->revoked_at)->format('d/m/Y') : '-' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Status</label>
                            <p class="mb-0">
                                @if($tag->active)
                                <span class="badge bg-success-subtle text-success fs-5">Ativa</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger fs-5">Inativa</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Cadastrada em</label>
                            <p class="mb-0">{{ $tag->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection