@extends('layouts.app')

@section('title', 'Políticas de Restrição')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="card-title fw-semibold mb-1">Políticas de Restrição</h5>
                <p class="card-subtitle mb-0">Regras de acesso por zona e horário</p>
            </div>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('policies.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="zone_id" class="form-select">
                        <option value="">Todas as Zonas</option>
                        @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ request('zone_id') == $zone->id ? 'selected' : '' }}>
                            {{ $zone->school->name }} - {{ $zone->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="rule_type" class="form-select">
                        <option value="">Todos os Tipos</option>
                        <option value="allow" {{ request('rule_type') === 'allow' ? 'selected' : '' }}>Permitir</option>
                        <option value="deny" {{ request('rule_type') === 'deny' ? 'selected' : '' }}>Bloquear</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="weekday" class="form-select">
                        <option value="">Todos os Dias</option>
                        <option value="0" {{ request('weekday') === '0' ? 'selected' : '' }}>Domingo</option>
                        <option value="1" {{ request('weekday') == '1' ? 'selected' : '' }}>Segunda-feira</option>
                        <option value="2" {{ request('weekday') == '2' ? 'selected' : '' }}>Terça-feira</option>
                        <option value="3" {{ request('weekday') == '3' ? 'selected' : '' }}>Quarta-feira</option>
                        <option value="4" {{ request('weekday') == '4' ? 'selected' : '' }}>Quinta-feira</option>
                        <option value="5" {{ request('weekday') == '5' ? 'selected' : '' }}>Sexta-feira</option>
                        <option value="6" {{ request('weekday') == '6' ? 'selected' : '' }}>Sábado</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> Filtrar
                    </button>
                </div>
            </div>

            @if(request()->hasAny(['zone_id', 'rule_type', 'weekday']))
            <div class="mt-2">
                <a href="{{ route('policies.index') }}" class="btn btn-sm btn-light">
                    <i class="ti ti-x me-1"></i> Limpar Filtros
                </a>
            </div>
            @endif
        </form>

        <!-- Tabela -->
        @if($policies->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Zona</th>
                        <th>Escola</th>
                        <th>Tipo</th>
                        <th>Dia da Semana</th>
                        <th>Horário</th>
                        <th>Perfis Permitidos</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($policies as $policy)
                    <tr>
                        <td>
                            <strong>{{ $policy->zone->name }}</strong><br>
                            <small class="text-muted">{{ $policy->zone->code }}</small>
                        </td>
                        <td>{{ $policy->zone->school->name }}</td>
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
                        <td class="text-end">
                            <a href="{{ route('policies.show', $policy) }}" class="btn btn-sm btn-light" title="Visualizar">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $policies->withQueryString()->links() }}
        </div>
        @else
        <div class="alert alert-info mb-0">
            <i class="ti ti-info-circle me-2"></i>
            Nenhuma política encontrada.
        </div>
        @endif
    </div>
</div>
@endsection