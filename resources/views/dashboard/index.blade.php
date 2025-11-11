@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <!-- Welcome Card -->
        <div class="card text-bg-primary dashboard-welcome">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="d-flex flex-column h-100">
                            <div class="hstack gap-3">
                                <span class="d-flex align-items-center justify-content-center round-48 bg-white rounded flex-shrink-0" style="width: 33.6px; height: 33.6px;">
                                    <iconify-icon icon="solar:course-up-outline" class="fs-7 text-muted"></iconify-icon>
                                </span>
                                <div class="ms-1">
                                    <h3 class="mb-0 text-white fw-bold text-uppercase">SEJA BEM-VINDO(A) AO PAINEL</h3>
                                    <h5 class="mt-0 mb-0 text-white fw-semibold">
                                        {{ optional(auth()->user()->escola)->nome ?? 'Sua Escola' }}
                                    </h5>
                                </div>
                            </div>
                            <div class="mt-4 mt-sm-auto">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="d-flex flex-column align-items-start gap-1">
                                            <span class="opacity-75">Turmas</span>
                                            <h4 class="mb-0 text-white text-nowrap fs-13 fw-bolder">{{ $total_classes ?? 0 }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                                        <div class="d-flex flex-column align-items-start gap-1">
                                            <span class="opacity-75">Alunos</span>
                                            <h4 class="mb-0 text-white text-nowrap fs-13 fw-bolder">{{ $total_students ?? 0 }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-md-end">
                        @php($schoolLogo = optional(auth()->user()->escola)->logo)
                        @if($schoolLogo)
                            <img src="{{ asset('storage/' . $schoolLogo) }}" alt="Logo {{ optional(auth()->user()->escola)->nome }}"
                                 class="rounded bg-white p-2 shadow-sm"
                                 style="width: 126px; height: 126px; object-fit: contain;"
                                 onerror="this.onerror=null; this.src='{{ asset('assets/images/logos/school-placeholder.svg') }}';" />
                        @else
                            <img src="{{ asset('assets/images/logos/school-placeholder.svg') }}" alt="Logo"
                                 class="rounded bg-white p-2 shadow-sm"
                                 style="width: 126px; height: 126px; object-fit: contain;" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Presenças Card -->
    <div class="col-md-6">
        <div class="card bg-brand-primary-subtle overflow-hidden shadow-none">
            <div class="card-body p-4">
                <span class="text-brand-muted fw-semibold">ALUNOS COM REGISTRO HOJE</span>
                <div class="hstack gap-6">
                    <h5 class="mb-0 fs-7 text-brand-contrast">{{ $presences_today ?? 0 }}</h5>
                    <span class="fs-11 text-brand-muted fw-semibold">{{ $attendance_rate ?? 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Ausências Card -->
    <div class="col-md-6">
        <div class="card bg-brand-secondary-subtle overflow-hidden shadow-none">
            <div class="card-body p-4">
                <span class="text-brand-muted fw-semibold">ALUNOS SEM REGISTRO HOJE</span>
                <div class="hstack gap-6">
                    <h5 class="mb-0 fs-7 text-brand-contrast">{{ $absences_today ?? 0 }}</h5>
                    <span class="fs-11 text-brand-muted fw-semibold">{{ 100 - ($attendance_rate ?? 0) }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title fw-semibold mb-0">Indicadores de Movimentação</h5>
                    <div class="btn-group" role="group" aria-label="Intervalos">
                        <a href="{{ route('dashboard', ['range' => 1]) }}" class="btn btn-sm btn-outline-primary {{ ($currentRange ?? 14) === 1 ? 'active' : '' }}">HOJE</a>
                        <a href="{{ route('dashboard', ['range' => 7]) }}" class="btn btn-sm btn-outline-primary {{ ($currentRange ?? 14) === 7 ? 'active' : '' }}">7 DIAS</a>
                        <a href="{{ route('dashboard', ['range' => 14]) }}" class="btn btn-sm btn-outline-primary {{ ($currentRange ?? 14) === 14 ? 'active' : '' }}">14 DIAS</a>
                        <a href="{{ route('dashboard', ['range' => 30]) }}" class="btn btn-sm btn-outline-primary {{ ($currentRange ?? 14) === 30 ? 'active' : '' }}">30 DIAS</a>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ ($currentRange ?? 14) === 1 ? 'Movimentos por hora (Hoje)' : 'Movimentos por dia (' . (($currentRange ?? 14) . 'd') . ')' }}</h6>
                                </div>
                                <div id="chart-movements-by-day" style="min-height: 240px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Registros por período do dia</h6>
                                </div>
                                <div id="chart-by-period" style="min-height: 240px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Top 5 turmas por registros</h6>
                                </div>
                                <div id="chart-top-classes" style="min-height: 240px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Alunos com vs sem registro ({{ ($currentRange ?? 14) === 1 ? 'Hoje' : (($currentRange ?? 14) . 'd') }})</h6>
                                </div>
                                <div id="chart-registros-vs-sem" style="min-height: 240px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script>
    (function(){
        const cssVar = (name, fallback) => {
            const val = getComputedStyle(document.documentElement).getPropertyValue(name).trim();
            return val || fallback;
        };
        const primary = cssVar('--bs-primary', '#0c1f5f');
        const blue    = cssVar('--bs-blue', '#5d87ff');
        const labelsMovementsByDay = @json($labelsMovementsByDay ?? []);
        const dataMovementsByDay   = @json($dataMovementsByDay ?? []);
        const labelsByPeriod       = @json($labelsByPeriod ?? []);
        const dataByPeriod         = @json($dataByPeriod ?? []);
        const labelsTopClasses     = @json($labelsTopClasses ?? []);
        const dataTopClasses       = @json($dataTopClasses ?? []);
        const studentsWithMovement = @json($studentsWithMovement ?? 0);
        const studentsWithoutMovement = @json($studentsWithoutMovement ?? 0);

        // Movimentos por dia / hora (dinâmico)
        new ApexCharts(document.querySelector('#chart-movements-by-day'), {
            chart: { type: 'area', height: 240, toolbar: { show: false }, fontFamily: 'inherit', foreColor: '#adb0bb' },
            series: [{ name: 'Movimentos', data: dataMovementsByDay }],
            xaxis: {
                categories: labelsMovementsByDay,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { rotate: -45 }
            },
            dataLabels: { enabled: false },
            stroke: { width: 2, curve: 'smooth' },
            fill: { type: 'gradient', gradient: { opacityFrom: 0.2, opacityTo: 0.05 } },
            grid: { borderColor: 'rgba(0,0,0,0.05)' },
            colors: ['var(--bs-primary)'],
            tooltip: {
                theme: 'dark',
                x: {
                    formatter: function(val){
                        // Se for formato HH:MM (range=1), mantém; caso contrário, exibe o dia.
                        return val;
                    }
                }
            }
        }).render();

        // Registros por período
        new ApexCharts(document.querySelector('#chart-by-period'), {
            chart: { type: 'bar', height: 240, toolbar: { show: false }, fontFamily: 'inherit', foreColor: '#adb0bb' },
            series: [{ name: 'Registros', data: dataByPeriod }],
            xaxis: { categories: labelsByPeriod, axisBorder: { show: false }, axisTicks: { show: false } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } },
            dataLabels: { enabled: false },
            grid: { borderColor: 'rgba(0,0,0,0.05)' },
            colors: ['var(--bs-primary)'],
            tooltip: { theme: 'dark' }
        }).render();

        // Top turmas
        new ApexCharts(document.querySelector('#chart-top-classes'), {
            chart: { type: 'bar', height: 240, toolbar: { show: false }, fontFamily: 'inherit', foreColor: '#adb0bb' },
            series: [{ name: 'Registros', data: dataTopClasses }],
            xaxis: { categories: labelsTopClasses, axisBorder: { show: false }, axisTicks: { show: false } },
            plotOptions: { bar: { horizontal: true, borderRadius: 6, barHeight: '60%' } },
            dataLabels: { enabled: false },
            grid: { borderColor: 'rgba(0,0,0,0.05)' },
            colors: ['var(--bs-secondary)'],
            tooltip: { theme: 'dark' }
        }).render();

        // Com vs sem registro
        new ApexCharts(document.querySelector('#chart-registros-vs-sem'), {
            chart: { type: 'donut', height: 240, toolbar: { show: false }, fontFamily: 'inherit', foreColor: '#adb0bb' },
            series: [studentsWithMovement, studentsWithoutMovement],
            labels: ['Com registro', 'Sem registro'],
            dataLabels: { enabled: false },
            legend: { position: 'bottom' },
            colors: [primary, blue],
            fill: { opacity: 1 },
            states: {
                normal: { filter: { type: 'none' } },
                hover: { filter: { type: 'none' } },
                active: { filter: { type: 'none' } }
            },
            tooltip: { theme: 'dark' }
        }).render();
    })();
</script>
@endpush