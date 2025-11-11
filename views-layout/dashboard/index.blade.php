@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
        <div class="container-fluid">
<div class="row">
    <div class="col-lg-5">
            <!-- -------------------------------------------- -->
            <!-- Card visual sem texto de boas-vindas -->
            <!-- -------------------------------------------- -->
              <div class="card text-bg-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex flex-column h-100">
                                <div class="hstack gap-3">
                                    <span
                                        class="d-flex align-items-center justify-content-center round-48 bg-white rounded flex-shrink-0">
                                        <iconify-icon icon="solar:course-up-outline" class="fs-7 text-muted"></iconify-icon>
                                    </span>
                                    <!-- Texto removido conforme solicitação -->
                                </div>
                                <div class="mt-4 mt-sm-auto">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="opacity-75">Turmas</span>
                              <h4 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">{{ number_format($total_classes) }}</h4>
                                        </div>
                                        <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                              <span class="opacity-75">Alunos</span>
                              <h4 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">{{ number_format($total_students) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-md-end">
                            <img src="{{ asset('assets/images/logos/logo-marista-ap1.png') }}" alt="Bem-vindo" class="img-fluid mb-n7 mt-2"
                        width="180" />
                        </div>
                    </div>


                </div>
            </div>

              <div class="row">
            <!-- -------------------------------------------- -->
                <!-- Presences Card -->
            <!-- -------------------------------------------- -->
                <div class="col-md-6">
                  <div class="card bg-secondary-subtle overflow-hidden shadow-none">
                    <div class="card-body p-4">
                      @php
                        $attendanceRate = max($attendance_rate, 0);
                      @endphp
                      <span class="text-dark-light">Presenças</span>
                      <div class="hstack gap-6">
                        <h5 class="mb-0 fs-7">{{ number_format($presences_today) }}</h5>
                        <span class="fs-11 text-dark-light fw-semibold">{{ $attendanceRate }}%</span>
                                </div>
                            </div>
                    <div id="customers"></div>
                            </div>
                        </div>
                <!-- -------------------------------------------- -->
                <!-- Absences Card -->
                <!-- -------------------------------------------- -->
                <div class="col-md-6">
                  <div class="card bg-danger-subtle overflow-hidden shadow-none">
                    <div class="card-body p-4">
                      @php
                        $absenceRate = max(0, 100 - $attendance_rate);
                        $absencesDisplay = max($absences_today, 0);
                      @endphp
                      <span class="text-dark-light">Ausências</span>
                                <div class="hstack gap-6 mb-4">
                        <h5 class="mb-0 fs-7">{{ number_format($absencesDisplay) }}</h5>
                        <span class="fs-11 text-dark-light fw-semibold">{{ $absenceRate }}%</span>
                                </div>
                      <div class="mx-n1">
                        <div id="projects"></div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <!-- -------------------------------------------- -->
              <!-- Revenue Forecast -->
        <!-- -------------------------------------------- -->
              <div class="card">
            <div class="card-body pb-4">
                  <div class="d-md-flex align-items-start justify-content-between mb-4 flex-column flex-md-row gap-4">
                    <div class="hstack align-items-center gap-3">
                        <span
                            class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:layers-linear" class="fs-7 text-primary"></iconify-icon>
                        </span>
                        <div>
                        <h5 class="card-title mb-1">Movimentação Semanal</h5>
                        <p class="card-subtitle mb-0">Dom a Sáb</p>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-md-end gap-2">
                      <div class="d-flex flex-column flex-sm-row gap-3">
                        <div class="d-flex align-items-center gap-2">
                          <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                          <span class="text-nowrap text-muted">Total Presença</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                          <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                          <span class="text-nowrap text-muted">Faltas Previstas</span>
                        </div>
                      </div>
                      <span class="text-muted small fw-semibold">Comparativo semanal de presenças x faltas previstas</span>
                    </div>
                </div>
                <div style="height: 295px;" class="me-n7">
                    <div id="revenue-forecast"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <!-- -------------------------------------------- -->
              <!-- Taxa de Ocupação -->
        <!-- -------------------------------------------- -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="d-flex align-items-center justify-content-center round-48 bg-info-subtle rounded flex-shrink-0">
                        <iconify-icon icon="solar:users-group-rounded-bold-duotone" class="fs-7 text-info"></iconify-icon>
                    </span>
                    <div>
                        <h5 class="card-title fw-semibold mb-0">Taxa de Ocupação</h5>
                        <p class="card-subtitle mb-0 text-muted">Alunos na escola agora</p>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="vstack gap-9 mt-2">
                            <div class="hstack align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center round-48 rounded bg-success-subtle flex-shrink-0">
                                    <iconify-icon icon="solar:login-3-bold-duotone" class="fs-7 text-success"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-nowrap">{{ number_format($students_inside) }} alunos</h6>
                                    <span class="text-muted">Dentro da escola</span>
                                </div>
                            </div>
                            
                            <div class="hstack align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center round-48 rounded bg-primary-subtle">
                                    <iconify-icon icon="solar:users-group-rounded-bold" class="fs-7 text-primary"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ number_format($total_students) }} alunos</h6>
                                    <span class="text-muted">Capacidade total</span>
                                </div>
                            </div>
                            
                            <div class="hstack align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center round-48 rounded {{ $occupancy_change >= 0 ? 'bg-info-subtle' : 'bg-warning-subtle' }}">
                                    <iconify-icon icon="{{ $occupancy_change >= 0 ? 'solar:arrow-up-bold' : 'solar:arrow-down-bold' }}" 
                                                  class="fs-7 {{ $occupancy_change >= 0 ? 'text-info' : 'text-warning' }}"></iconify-icon>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $occupancy_change >= 0 ? '+' : '' }}{{ number_format($occupancy_change) }} alunos</h6>
                                    <span class="text-muted">vs 1 hora atrás</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="text-center mt-sm-n3">
                            <div id="occupancy-chart"></div>
                            <h2 class="fs-8 fw-bold text-info mb-2">{{ $occupancy_rate }}%</h2>
                            <p class="mb-3 text-muted">Taxa de ocupação atual</p>
                            
                            <div class="progress mb-2" style="height: 12px;">
                                <div class="progress-bar {{ $occupancy_rate >= 80 ? 'bg-success' : ($occupancy_rate >= 50 ? 'bg-info' : 'bg-warning') }}" 
                                     role="progressbar" 
                                     style="width: {{ $occupancy_rate }}%"
                                     aria-valuenow="{{ $occupancy_rate }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between small text-muted">
                                <span>0%</span>
                                <span>50%</span>
                                <span>100%</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <!-- -------------------------------------------- -->
        <!-- Distribuição por Área (Expandido) -->
        <!-- -------------------------------------------- -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="d-flex align-items-center justify-content-center round-40 bg-success-subtle rounded flex-shrink-0">
                        <iconify-icon icon="solar:map-point-wave-bold-duotone" class="fs-6 text-success"></iconify-icon>
                    </span>
                    <div>
                        <h6 class="card-title fw-semibold mb-0">Distribuição por Área</h6>
                        <p class="card-subtitle mb-0 text-muted small">Localização dos alunos em tempo real</p>
                    </div>
                </div>

                @if(count($zone_labels) > 0)
                    <div class="row align-items-center">
                        <!-- Legenda à Esquerda -->
                        <div class="col-md-5">
                            <div class="d-flex flex-column gap-3">
                                @foreach($zone_labels as $index => $label)
                                    @php
                                        $total = $zone_values[$index] ?? 0;
                                        $percentage = $students_inside > 0 ? round(($total / $students_inside) * 100) : 0;
                                        $colors = [
                                            'Entrada' => 'primary',
                                            'Saída' => 'info',
                                            'Biblioteca' => 'success',
                                            'Refeitório' => 'warning',
                                            'Outras Áreas' => 'danger',
                                        ];
                                        $color = $colors[$label] ?? 'secondary';
                                    @endphp
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="d-block flex-shrink-0 round-8 bg-{{ $color }} rounded-circle" style="width: 10px; height: 10px;"></span>
                                                <span class="mb-0 fw-semibold small">{{ $label }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6 class="mb-0 fw-bold text-{{ $color }}">{{ $total }}</h6>
                                                <span class="badge bg-{{ $color }}-subtle text-{{ $color }} fs-11">{{ $percentage }}%</span>
                                            </div>
                                        </div>
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar bg-{{ $color }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $percentage }}%"
                                                 aria-valuenow="{{ $percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Gráfico à Direita -->
                        <div class="col-md-7">
                            <div class="text-center">
                                <div id="zone-distribution-chart" style="height: 288px;"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <iconify-icon icon="solar:map-point-outline" class="fs-10 text-muted mb-3"></iconify-icon>
                        <p class="text-muted mb-0">Nenhum aluno detectado nas zonas</p>
                        <small class="text-muted">Os dados aparecerão quando houver movimentação</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12">
        <!-- -------------------------------------------- -->
        <!-- Monitor de Antenas -->
        <!-- -------------------------------------------- -->
        <div class="card mb-lg-0">
                <div class="card-body">
                <div class="d-flex flex-wrap gap-3 mb-4 justify-content-between align-items-center">
                    <div class="hstack align-items-center gap-3">
                        <span class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:transmission-circle-linear" class="fs-7 text-primary"></iconify-icon>
                    </span>
                        <div>
                            <h5 class="card-title fw-semibold mb-1">Monitor de Antenas</h5>
                            <p class="card-subtitle mb-0">Status em tempo real</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-block flex-shrink-0 round-8 bg-success rounded-circle"></span>
                            <span class="text-nowrap text-muted">Online</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                            <span class="text-nowrap text-muted">Offline</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="d-block flex-shrink-0 round-8 bg-warning rounded-circle"></span>
                            <span class="text-nowrap text-muted">Alerta</span>
                        </div>
                    </div>
                </div>

                  <div class="table-responsive">
                    <table class="table text-nowrap align-middle table-hover mb-0">
                          <thead>
                            <tr>
                              <th scope="col" class="fw-semibold ps-0">Antena</th>
                              <th scope="col" class="fw-semibold">Localização</th>
                              <th scope="col" class="fw-semibold">Última Leitura</th>
                              <th scope="col" class="fw-semibold">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($readers as $reader)
                            @php
                              $status = $reader->latestStatus?->status ?? 'unknown';
                              $statusClass = match($status) {
                                'ONLINE' => 'success',
                                'OFFLINE' => 'danger',
                                'DEGRADED' => 'warning',
                                default => 'secondary'
                              };
                              $statusText = match($status) {
                                'ONLINE' => 'Online',
                                'OFFLINE' => 'Offline',
                                'DEGRADED' => 'Alerta',
                                default => 'Desconhecido'
                              };
                              $shouldBlink = $status === 'OFFLINE';
                            @endphp
                            <tr class="{{ $shouldBlink ? 'blink-row' : '' }}">
                              <td class="ps-0">
                                <div class="d-flex align-items-center gap-3">
                                  <span class="d-flex align-items-center justify-content-center round-40 bg-{{ $statusClass }}-subtle rounded flex-shrink-0">
                                    <iconify-icon icon="solar:transmission-circle-linear" class="fs-6 text-{{ $statusClass }}"></iconify-icon>
                                  </span>
                                  <div>
                                    <h6 class="mb-0">{{ $reader->name }}</h6>
                                    <span class="text-muted small">{{ $reader->code }}</span>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <span class="text-muted">
                                  {{ $reader->zone ?? 'N/A' }}
                                  @if($reader->building)
                                    <br><small>{{ $reader->building }}
                                    @if($reader->floor)
                                      - Andar {{ $reader->floor }}
                                    @endif
                                    </small>
                                  @endif
                                </span>
                              </td>
                              <td>
                                @if($reader->latestStatus?->last_read_at)
                                  <span class="text-muted">{{ $reader->latestStatus->last_read_at->format('d/m/Y H:i') }}</span>
                                @else
                                  <span class="text-muted">Sem leitura</span>
                                @endif
                              </td>
                              <td>
                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }}">{{ $statusText }}</span>
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="4" class="text-center py-4">
                                <span class="text-muted">Nenhuma antena cadastrada</span>
                              </td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>

            </div>
        </div>
    </div>

          </div>

    </div>

@endsection

@push('styles')
<style>
@keyframes blink-animation {
  0%, 49% {
    opacity: 1;
  }
  50%, 100% {
    opacity: 0.3;
  }
}

.blink-row {
  animation: blink-animation 1.5s infinite;
}
</style>
@endpush

@push('scripts')
<script>
  window.dashboardRevenueData = {
    categories: @json($weekDaysLabels ?? []),
    presences: @json($presenceWeekData ?? []),
    absences: @json($absenceWeekData ?? []),
  };

  // Dados da Taxa de Ocupação
  window.occupancyData = {
    rate: {{ $occupancy_rate ?? 0 }},
    studentsInside: {{ $students_inside ?? 0 }},
    totalStudents: {{ $total_students ?? 0 }}
  };

  // Dados da Distribuição por Zona
  window.zoneDistributionData = {
    labels: @json($zone_labels ?? []),
    values: @json($zone_values ?? [])
  };
</script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboards/dashboard1.js') }}"></script>
<script>
  // Gráfico de Taxa de Ocupação (Gauge)
  document.addEventListener('DOMContentLoaded', function() {
    const occupancyElement = document.querySelector("#occupancy-chart");
    
    if (occupancyElement && window.occupancyData) {
      const occupancyOptions = {
        series: [window.occupancyData.rate],
        chart: {
          height: 180,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            hollow: {
              size: '60%',
            },
            track: {
              background: '#e7e7e7',
            },
            dataLabels: {
              show: false,
            }
          },
        },
        colors: [
          window.occupancyData.rate >= 80 ? '#13DEB9' : 
          window.occupancyData.rate >= 50 ? '#539BFF' : '#FFAE1F'
        ],
        stroke: {
          lineCap: 'round'
        },
      };

      const occupancyChart = new ApexCharts(occupancyElement, occupancyOptions);
      occupancyChart.render();
    }

    // Gráfico de Distribuição por Zona (Donut Chart)
    const zoneChartElement = document.querySelector("#zone-distribution-chart");
    
    if (zoneChartElement && window.zoneDistributionData && window.zoneDistributionData.values.length > 0) {
      const zoneOptions = {
        series: window.zoneDistributionData.values,
        chart: {
          type: 'donut',
          height: 288,
          fontFamily: 'inherit',
        },
        labels: window.zoneDistributionData.labels,
        colors: ['#5D87FF', '#49BEFF', '#13DEB9', '#FFAE1F', '#FA896B'],
        plotOptions: {
          pie: {
            startAngle: 0,
            endAngle: 360,
            donut: {
              size: '70%',
              labels: {
                show: true,
                name: {
                  show: true,
                  fontSize: '12px',
                  fontWeight: 600,
                  offsetY: -5,
                },
                value: {
                  show: true,
                  fontSize: '20px',
                  fontWeight: 700,
                  color: '#5A6A85',
                  offsetY: 5,
                  formatter: function (val) {
                    return val + ' alunos';
                  }
                },
                total: {
                  show: true,
                  label: 'Total',
                  fontSize: '12px',
                  fontWeight: 600,
                  color: '#5A6A85',
                  formatter: function (w) {
                    const total = w.globals.seriesTotals.reduce((a, b) => {
                      return a + b;
                    }, 0);
                    return total + ' alunos';
                  }
                }
              }
            }
          }
        },
        dataLabels: {
          enabled: false,
        },
        legend: {
          show: false,
        },
        stroke: {
          width: 2,
          colors: ['#fff']
        },
        tooltip: {
          fillSeriesColor: false,
          y: {
            formatter: function(value, { seriesIndex }) {
              const total = window.zoneDistributionData.values.reduce((a, b) => a + b, 0);
              const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
              return value + ' alunos (' + percentage + '%)';
            }
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              height: 250
            }
          }
        }]
      };

      const zoneChart = new ApexCharts(zoneChartElement, zoneOptions);
      zoneChart.render();
    }
  });
</script>
@endpush