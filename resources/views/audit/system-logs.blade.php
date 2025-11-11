@extends('layouts.app')

@section('title', 'Logs de sistema')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Logs de sistema</h4>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
                <iconify-icon icon="solar:arrow-left-line-duotone" class="me-1"></iconify-icon>
                Voltar ao Dashboard
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Data e horário</th>
                                <th class="text-nowrap">Usuário</th>
                                <th class="text-nowrap">Página</th>
                                <th class="text-nowrap">Filtros</th>
                                <th class="text-nowrap">Ação</th>
                                <th class="text-nowrap">Exportação</th>
                                <th class="text-nowrap">Impressão</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="text-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="text-nowrap">{{ $log->user?->name ?? '—' }}</td>
                                <td class="text-truncate" style="max-width: 220px;" title="{{ $log->page }}">{{ $log->page }}</td>
                                <td class="text-truncate" style="max-width: 280px;">
                                    @php($filters = $log->filters ? json_decode($log->filters, true) : null)
                                    @if(is_array($filters) && count($filters))
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($filters as $k => $v)
                                                <span class="badge bg-primary-subtle text-primary" title="{{ $k }}={{ is_array($v) ? implode(',', $v) : $v }}">{{ $k }}: {{ is_array($v) ? implode(',', $v) : $v }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $log->action }}</td>
                                <td class="text-nowrap">
                                    @if($log->is_export)
                                    <span class="badge bg-primary-subtle text-primary">Sim</span>
                                    @else
                                    <span class="badge bg-secondary-subtle text-secondary">Não</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if($log->is_print)
                                    <span class="badge bg-primary-subtle text-primary">Sim</span>
                                    @else
                                    <span class="badge bg-secondary-subtle text-secondary">Não</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <iconify-icon icon="solar:clipboard-list-line-duotone" class="fs-8 mb-2"></iconify-icon>
                                        <p class="mb-0">Nenhum log registrado ainda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
 </div>
@endsection