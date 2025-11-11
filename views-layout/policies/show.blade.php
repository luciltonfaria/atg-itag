@extends('layouts.app')

@section('title', 'Detalhes da Política')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">
        <i class="ti ti-shield-check me-2"></i>
        Detalhes da Política de Restrição
    </h5>
    <div>
        <a href="{{ route('zones.show', $policy->zone) }}" class="btn btn-light me-2">
            <i class="ti ti-map-pin me-1"></i> Ver Zona
        </a>
        <a href="{{ route('policies.index') }}" class="btn btn-light">
            <i class="ti ti-arrow-left me-1"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <!-- Informações da Política -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="ti ti-info-circle me-2"></i>
                    Informações da Política
                </h6>

                <div class="mb-3">
                    <label class="text-muted small">ID</label>
                    <div>
                        <span class="badge bg-secondary">#{{ $policy->id }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Tipo de Regra</label>
                    <div>
                        @if($policy->rule_type === 'allow')
                        <span class="badge bg-success fs-6">
                            <i class="ti ti-check"></i> PERMITIR ACESSO
                        </span>
                        @else
                        <span class="badge bg-danger fs-6">
                            <i class="ti ti-x"></i> BLOQUEAR ACESSO
                        </span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Dia da Semana</label>
                    <div class="fw-bold">
                        @php
                        $days = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
                        @endphp
                        {{ $days[$policy->weekday] ?? 'N/A' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Horário de Vigência</label>
                    <div>
                        <span class="badge bg-primary fs-6">
                            <i class="ti ti-clock"></i>
                            {{ $policy->start_time }} até {{ $policy->end_time }}
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Perfis Permitidos</label>
                    <div>
                        @if($policy->allowed_roles && count($policy->allowed_roles) > 0)
                        @foreach($policy->allowed_roles as $role)
                        <span class="badge bg-light text-dark me-1 mb-1">
                            <i class="ti ti-user"></i> {{ $role }}
                        </span>
                        @endforeach
                        @else
                        <span class="text-muted">Nenhum perfil especificado</span>
                        @endif
                    </div>
                </div>

                @if($policy->note)
                <div class="mb-0">
                    <label class="text-muted small">Observações</label>
                    <div class="bg-light p-3 rounded">{{ $policy->note }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Informações da Zona -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="ti ti-map-pin me-2"></i>
                    Zona Associada
                </h6>

                <div class="mb-3">
                    <label class="text-muted small">Código da Zona</label>
                    <div>
                        <span class="badge bg-secondary fs-5">{{ $policy->zone->code }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Nome da Zona</label>
                    <div class="fw-bold">{{ $policy->zone->name }}</div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Escola</label>
                    <div>{{ $policy->zone->school->name }}</div>
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
                        $badge = $badges[$policy->zone->risk_level] ?? ['class' => 'secondary', 'text' => 'N/A'];
                        @endphp
                        <span class="badge bg-{{ $badge['class'] }}">
                            Nível {{ $policy->zone->risk_level }} - {{ $badge['text'] }}
                        </span>
                    </div>
                </div>

                <div class="mb-0">
                    <a href="{{ route('zones.show', $policy->zone) }}" class="btn btn-primary w-100">
                        <i class="ti ti-eye me-1"></i>
                        Ver Detalhes Completos da Zona
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timestamps -->
<div class="card">
    <div class="card-body">
        <h6 class="card-title mb-3">
            <i class="ti ti-calendar me-2"></i>
            Informações de Sistema
        </h6>

        <div class="row">
            <div class="col-md-6">
                <label class="text-muted small">Criada em</label>
                <div>{{ $policy->created_at->format('d/m/Y H:i:s') }}</div>
            </div>

            <div class="col-md-6">
                <label class="text-muted small">Última atualização</label>
                <div>{{ $policy->updated_at->format('d/m/Y H:i:s') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection