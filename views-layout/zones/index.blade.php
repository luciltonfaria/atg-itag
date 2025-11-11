@extends('layouts.app')

@section('title', 'Zonas e Áreas')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="card-title fw-semibold mb-1">Zonas e Áreas</h5>
                <p class="card-subtitle mb-0">Gerencie as zonas de acesso da instituição</p>
            </div>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('zones.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="school_id" class="form-select">
                        <option value="">Todas as Escolas</option>
                        @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="risk_level" class="form-select">
                        <option value="">Todos os Níveis de Risco</option>
                        <option value="0" {{ request('risk_level') === '0' ? 'selected' : '' }}>Nível 0 - Livre</option>
                        <option value="1" {{ request('risk_level') == '1' ? 'selected' : '' }}>Nível 1 - Baixo</option>
                        <option value="2" {{ request('risk_level') == '2' ? 'selected' : '' }}>Nível 2 - Médio</option>
                        <option value="3" {{ request('risk_level') == '3' ? 'selected' : '' }}>Nível 3 - Alto</option>
                        <option value="4" {{ request('risk_level') == '4' ? 'selected' : '' }}>Nível 4 - Crítico</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i> Filtrar
                    </button>
                </div>
            </div>

            @if(request()->hasAny(['school_id', 'risk_level', 'search']))
            <div class="mt-2">
                <a href="{{ route('zones.index') }}" class="btn btn-sm btn-light">
                    <i class="ti ti-x me-1"></i> Limpar Filtros
                </a>
            </div>
            @endif
        </form>

        <!-- Tabela -->
        @if($zones->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Escola</th>
                        <th>Nível de Risco</th>
                        <th>Antenas</th>
                        <th>Políticas</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($zones as $zone)
                    <tr>
                        <td>
                            <span class="badge bg-secondary">{{ $zone->code }}</span>
                        </td>
                        <td>
                            <strong>{{ $zone->name }}</strong>
                        </td>
                        <td>{{ $zone->school->name }}</td>
                        <td>
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
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="ti ti-antenna me-1"></i> {{ $zone->readers->count() }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark">
                                <i class="ti ti-shield-check me-1"></i> {{ $zone->policies->count() }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('zones.show', $zone) }}" class="btn btn-sm btn-light" title="Visualizar">
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
            {{ $zones->withQueryString()->links() }}
        </div>
        @else
        <div class="alert alert-info mb-0">
            <i class="ti ti-info-circle me-2"></i>
            Nenhuma zona encontrada.
        </div>
        @endif
    </div>
</div>
@endsection