@extends('layouts.app')

@section('title', 'Detalhes da Zona')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">
        <i class="ti ti-map-pin me-2"></i>
        Detalhes da Zona
    </h5>
    <a href="{{ route('zones.index') }}" class="btn btn-light">
        <i class="ti ti-arrow-left me-1"></i> Voltar
    </a>
</div>

<div class="row">
    <!-- Informações da Zona -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="ti ti-info-circle me-2"></i>
                    Informações Gerais
                </h6>

                <div class="mb-3">
                    <label class="text-muted small">Código</label>
                    <div>
                        <span class="badge bg-secondary fs-5">{{ $zone->code }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Nome da Zona</label>
                    <div class="fw-bold">{{ $zone->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Escola</label>
                    <div>{{ $zone->school->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Nível de Risco</label>
                    <div>
                        @php
                        $badges = [
                        0 => ['class' => 'success', 'text' => 'Livre'],
                        1 => ['class' => 'info', 'text' => 'Baixo'],
                        2 => ['class' => 'warning', 'text' => 'Médio'],
                        3 => ['class' => 'danger', 'text' => 'Alto'],
                        4 => ['class' => 'dark', 'text' => 'Crítico'],
                        ];
                        $badge = $badges[$zone->risk_level] ?? ['class' => 'secondary', 'text' => 'N/A'];
                        @endphp
                        <span class="badge bg-{{ $badge['class'] }}">
                            Nível {{ $zone->risk_level }} - {{ $badge['text'] }}
                        </span>
                    </div>
                </div>

                @if($zone->policy_notes)
                <div class="mb-0">
                    <label class="text-muted small">Observações</label>
                    <div class="bg-light p-2 rounded">{{ $zone->policy_notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Antenas/Leitores -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="ti ti-antenna me-2"></i>
                    Antenas/Leitores ({{ $zone->readers->count() }})
                </h6>

                @if($zone->readers->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($zone->readers as $reader)
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $reader->name }}</div>
                                <small class="text-muted">{{ $reader->code }}</small>
                                @if($reader->pivot->is_primary)
                                <span class="badge bg-primary ms-2">Primária</span>
                                @endif
                            </div>
                            <a href="{{ route('readers.show', $reader) }}" class="btn btn-sm btn-light">
                                <i class="ti ti-eye"></i>
                            </a>
                        </div>
                        @if($reader->zone)
                        <div class="mt-1">
                            <small class="text-muted">
                                <i class="ti ti-map-pin"></i>
                                {{ $reader->zone }}
                            </small>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info mb-0">
                    Nenhuma antena associada a esta zona.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Políticas de Acesso -->
<div class="card">
    <div class="card-body">
        <h6 class="card-title mb-3">
            <i class="ti ti-shield-check me-2"></i>
            Políticas de Restrição ({{ $zone->policies->count() }})
        </h6>

        @if($zone->policies->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tipo</th>
                        <th>Dia da Semana</th>
                        <th>Horário</th>
                        <th>Perfis Permitidos</th>
                        <th>Observação</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($zone->policies as $policy)
                    <tr>
                        <td>
                            @if($policy->rule_type === 'allow')
                            <span class="badge bg-success">
                                <i class="ti ti-check"></i> Permitir
                            </span>
                            @else
                            <span class="badge bg-danger">
                                <i class="ti ti-x"></i> Bloquear
                            </span>
                            @endif
                        </td>
                        <td>
                            @php
                            $days = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                            @endphp
                            {{ $days[$policy->weekday] ?? 'N/A' }}
                        </td>
                        <td>
                            <code>{{ $policy->start_time }} - {{ $policy->end_time }}</code>
                        </td>
                        <td>
                            @if($policy->allowed_roles)
                            @foreach($policy->allowed_roles as $role)
                            <span class="badge bg-light text-dark">{{ $role }}</span>
                            @endforeach
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $policy->note ?? '-' }}</small>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('policies.show', $policy) }}" class="btn btn-sm btn-light">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info mb-0">
            Nenhuma política de restrição configurada para esta zona.
        </div>
        @endif
    </div>
</div>
@endsection