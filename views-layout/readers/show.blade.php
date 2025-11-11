@extends('layouts.app')

@section('title', 'Detalhes do Leitor')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Detalhes do Leitor RFID</h4>
            <a href="{{ route('readers.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                Voltar
            </a>
        </div>

        <div class="card">
            <div class="card-header bg-primary-subtle">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:signal-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Informações do Leitor
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Código</label>
                            <p class="mb-0 fw-semibold">
                                <span class="badge bg-primary-subtle text-primary fs-5">{{ $reader->code }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nome</label>
                            <p class="mb-0 fw-semibold fs-5">{{ $reader->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Zona</label>
                            <p class="mb-0">
                                <span class="badge bg-info-subtle text-info fs-5">{{ $reader->zone }}</span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Escola</label>
                            <p class="mb-0">
                                <iconify-icon icon="solar:buildings-2-line-duotone" class="text-primary"></iconify-icon>
                                <a href="{{ route('schools.show', $reader->school) }}">{{ $reader->school->name }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Localização</label>
                            <p class="mb-0">
                                <strong>Prédio:</strong> {{ $reader->building ?? '-' }}<br>
                                <strong>Andar:</strong> {{ $reader->floor ?? '-' }}<br>
                                @if($reader->room)
                                <strong>Sala:</strong> {{ $reader->room }}
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Endereço IP</label>
                            <p class="mb-0"><code class="fs-5">{{ $reader->ip ?? 'Não configurado' }}</code></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Número de Série</label>
                            <p class="mb-0"><code>{{ $reader->serial ?? '-' }}</code></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Status</label>
                            <p class="mb-0">
                                @if($reader->active)
                                <span class="badge bg-success-subtle text-success fs-5">Ativo</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger fs-5">Inativo</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection