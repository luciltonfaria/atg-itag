@extends('layouts.app')

@section('title', 'Monitoramento Diário de Presenças')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="card bg-primary-subtle mb-0 overflow-hidden shadow-none">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h4 class="fw-semibold mb-8 mb-sm-0 text-primary">
                        <iconify-icon icon="solar:calendar-check-bold-duotone" class="fs-7 me-2"></iconify-icon>
                        Monitoramento Diário de Presenças
                    </h4>
                    <p class="mb-0">
                        Acompanhe a presença dos alunos por turma em tempo real
                    </p>
                </div>
                <div class="col-sm-4">
                    <div class="d-flex justify-content-sm-end">
                        <input type="date" 
                               class="form-control" 
                               id="dateFilter" 
                               value="{{ $selectedDate->format('Y-m-d') }}"
                               max="{{ today()->format('Y-m-d') }}"
                               style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mt-4">
        @php
            $totalStudents = array_sum(array_column($classesData, 'total'));
            $totalPresent = array_sum(array_column($classesData, 'present'));
            $totalAbsent = array_sum(array_column($classesData, 'absent'));
            $overallRate = $totalStudents > 0 ? round(($totalPresent / $totalStudents) * 100) : 0;
        @endphp
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-flex align-items-center justify-content-center round-40 bg-primary-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:users-group-rounded-bold" class="fs-5 text-primary"></iconify-icon>
                        </span>
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $totalStudents }}</h6>
                            <p class="mb-0 text-muted small">Total de Alunos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-flex align-items-center justify-content-center round-40 bg-success-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:check-circle-bold" class="fs-5 text-success"></iconify-icon>
                        </span>
                        <div>
                            <h6 class="mb-0 fw-semibold text-success">{{ $totalPresent }}</h6>
                            <p class="mb-0 text-muted small">Presentes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-flex align-items-center justify-content-center round-40 bg-danger-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:close-circle-bold" class="fs-5 text-danger"></iconify-icon>
                        </span>
                        <div>
                            <h6 class="mb-0 fw-semibold text-danger">{{ $totalAbsent }}</h6>
                            <p class="mb-0 text-muted small">Ausentes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-flex align-items-center justify-content-center round-40 bg-info-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:chart-bold" class="fs-5 text-info"></iconify-icon>
                        </span>
                        <div>
                            <h6 class="mb-0 fw-semibold text-info">{{ $overallRate }}%</h6>
                            <p class="mb-0 text-muted small">Taxa Geral</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Classes List -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
                <iconify-icon icon="solar:book-bold-duotone" class="fs-6 me-2"></iconify-icon>
                Turmas ({{ count($classesData) }})
            </h5>

            @if(empty($classesData))
                <div class="text-center py-5">
                    <iconify-icon icon="solar:book-outline" class="fs-10 text-muted mb-3"></iconify-icon>
                    <p class="text-muted mb-0">Nenhuma turma encontrada</p>
                </div>
            @else
                <div class="accordion" id="classesAccordion">
                    @foreach($classesData as $index => $class)
                        <div class="accordion-item border rounded mb-3">
                            <h2 class="accordion-header">
                                <div class="d-flex align-items-center p-3">
                                    <!-- Class Info -->
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="d-flex align-items-center justify-content-center round-40 bg-primary-subtle rounded flex-shrink-0">
                                                <iconify-icon icon="solar:book-bold" class="fs-6 text-primary"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $class['name'] }}</h6>
                                                <small class="text-muted">
                                                    {{ $class['grade'] }} - {{ $class['shift'] }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="d-none d-md-flex align-items-center gap-4 me-3">
                                        <div class="text-center">
                                            <h6 class="mb-0 fw-semibold">{{ $class['total'] }}</h6>
                                            <span class="text-muted small">Total</span>
                                        </div>
                                        <div class="text-center">
                                            <h6 class="mb-0 fw-semibold text-success">{{ $class['present'] }}</h6>
                                            <span class="text-muted small">Presentes</span>
                                        </div>
                                        <div class="text-center">
                                            <h6 class="mb-0 fw-semibold text-danger">{{ $class['absent'] }}</h6>
                                            <span class="text-muted small">Ausentes</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="badge bg-{{ $class['rate'] >= 80 ? 'success' : ($class['rate'] >= 50 ? 'warning' : 'danger') }}-subtle text-{{ $class['rate'] >= 80 ? 'success' : ($class['rate'] >= 50 ? 'warning' : 'danger') }} fs-6">
                                                {{ $class['rate'] }}%
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Expand Button -->
                                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-2 btn-load-students"
                                            data-class-id="{{ $class['id'] }}"
                                            data-class-name="{{ $class['name'] }}"
                                            type="button">
                                        <iconify-icon icon="solar:magnifer-zoom-in-bold" class="fs-5"></iconify-icon>
                                        <span class="d-none d-sm-inline">Ver Alunos</span>
                                    </button>
                                </div>
                            </h2>

                            <!-- Students List (Initially Hidden) -->
                            <div class="accordion-collapse collapse students-container" 
                                 data-class-id="{{ $class['id'] }}">
                                <div class="accordion-body">
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Carregando...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Timeline -->
    <div class="modal fade" id="timelineModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <iconify-icon icon="solar:history-bold-duotone" class="fs-6 me-2"></iconify-icon>
                        Timeline de Movimentação
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="timelineContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectedDate = '{{ $selectedDate->format("Y-m-d") }}';

    // Date Filter
    document.getElementById('dateFilter').addEventListener('change', function() {
        window.location.href = '{{ route("presences.daily") }}?date=' + this.value;
    });

    // Load Students quando clicar na lupa
    document.querySelectorAll('.btn-load-students').forEach(button => {
        button.addEventListener('click', function() {
            const classId = this.dataset.classId;
            const className = this.dataset.className;
            const container = document.querySelector(`.students-container[data-class-id="${classId}"]`);
            
            // Se já está aberto, fecha
            if (container.classList.contains('show')) {
                container.classList.remove('show');
                return;
            }

            // Carrega os alunos
            loadStudents(classId, className, container);
        });
    });

    function loadStudents(classId, className, container) {
        fetch(`/api/presences/class/${classId}/students?date=${selectedDate}`)
            .then(response => response.json())
            .then(students => {
                renderStudents(students, container, className);
                container.classList.add('show');
            })
            .catch(error => {
                console.error('Erro ao carregar alunos:', error);
                container.querySelector('.accordion-body').innerHTML = `
                    <div class="alert alert-danger">
                        <iconify-icon icon="solar:danger-circle-bold" class="fs-5 me-2"></iconify-icon>
                        Erro ao carregar alunos. Tente novamente.
                    </div>
                `;
            });
    }

    function renderStudents(students, container, className) {
        if (students.length === 0) {
            container.querySelector('.accordion-body').innerHTML = `
                <div class="text-center py-4 text-muted">
                    <iconify-icon icon="solar:user-cross-outline" class="fs-10 mb-3"></iconify-icon>
                    <p>Nenhum aluno matriculado nesta turma</p>
                </div>
            `;
            return;
        }

        let html = `
            <div class="mb-3">
                <h6 class="text-muted">Alunos da turma ${className} (${students.length})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Aluno</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Primeira Entrada</th>
                            <th class="text-center">Última Saída</th>
                            <th class="text-center">Eventos</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        students.forEach(student => {
            const statusBadge = student.status === 'present' 
                ? '<span class="badge bg-success-subtle text-success"><iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>Presente</span>'
                : '<span class="badge bg-danger-subtle text-danger"><iconify-icon icon="solar:close-circle-bold" class="me-1"></iconify-icon>Ausente</span>';

            html += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="round-30 bg-${student.status === 'present' ? 'success' : 'danger'}-subtle rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center">
                                <iconify-icon icon="solar:user-bold" class="fs-5 text-${student.status === 'present' ? 'success' : 'danger'}"></iconify-icon>
                            </div>
                            <span class="fw-semibold">${student.name}</span>
                        </div>
                    </td>
                    <td class="text-center">${statusBadge}</td>
                    <td class="text-center">${student.first_entry ? '<span class="badge bg-info-subtle text-info">' + student.first_entry + '</span>' : '<span class="text-muted">-</span>'}</td>
                    <td class="text-center">${student.last_exit ? '<span class="badge bg-warning-subtle text-warning">' + student.last_exit + '</span>' : '<span class="text-muted">-</span>'}</td>
                    <td class="text-center">
                        <span class="badge bg-primary-subtle text-primary">${student.events_count}</span>
                    </td>
                    <td class="text-center">
                        ${student.events_count > 0 ? `
                            <button class="btn btn-sm btn-outline-primary btn-view-timeline" 
                                    data-student-id="${student.id}"
                                    data-student-name="${student.name}">
                                <iconify-icon icon="solar:history-bold" class="fs-5"></iconify-icon>
                                Timeline
                            </button>
                        ` : '<span class="text-muted small">Sem eventos</span>'}
                    </td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;

        container.querySelector('.accordion-body').innerHTML = html;

        // Adicionar event listeners aos botões de timeline
        container.querySelectorAll('.btn-view-timeline').forEach(btn => {
            btn.addEventListener('click', function() {
                const studentId = this.dataset.studentId;
                const studentName = this.dataset.studentName;
                showTimeline(studentId, studentName);
            });
        });
    }

    function showTimeline(studentId, studentName) {
        const modal = new bootstrap.Modal(document.getElementById('timelineModal'));
        const content = document.getElementById('timelineContent');
        
        // Mostrar loading
        content.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>
        `;
        
        modal.show();

        // Carregar timeline
        fetch(`/api/presences/student/${studentId}/timeline?date=${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                renderTimeline(data, content, studentName);
            })
            .catch(error => {
                console.error('Erro ao carregar timeline:', error);
                content.innerHTML = `
                    <div class="alert alert-danger">
                        <iconify-icon icon="solar:danger-circle-bold" class="fs-5 me-2"></iconify-icon>
                        Erro ao carregar timeline. Tente novamente.
                    </div>
                `;
            });
    }

    function renderTimeline(data, content, studentName) {
        if (data.timeline.length === 0) {
            content.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <iconify-icon icon="solar:history-outline" class="fs-10 mb-3"></iconify-icon>
                    <h5>Nenhum evento registrado</h5>
                    <p>${studentName} não teve movimentação neste dia</p>
                </div>
            `;
            return;
        }

        let html = `
            <div class="mb-4">
                <h5 class="mb-1">
                    <iconify-icon icon="solar:user-circle-bold" class="text-primary me-2"></iconify-icon>
                    ${studentName}
                </h5>
                <p class="text-muted mb-0">
                    Total de ${data.total_events} evento(s) registrado(s)
                </p>
            </div>

            <div class="timeline-vertical">
        `;

        data.timeline.forEach((event, index) => {
            const isEntry = event.type === 'CHECK_IN';
            const icon = isEntry ? 'solar:login-3-bold' : (event.type === 'CHECK_OUT' ? 'solar:logout-3-bold' : 'solar:map-point-bold');
            const color = isEntry ? 'success' : (event.type === 'CHECK_OUT' ? 'danger' : 'info');
            const label = isEntry ? 'Entrada' : (event.type === 'CHECK_OUT' ? 'Saída' : 'Movimentação');
            const isLast = index === data.timeline.length - 1;

            html += `
                <div class="timeline-item mb-4">
                    <div class="d-flex gap-3">
                        <div class="d-flex flex-column align-items-center">
                            <div class="round-40 bg-${color}-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0">
                                <iconify-icon icon="${icon}" class="fs-6 text-${color}"></iconify-icon>
                            </div>
                            ${!isLast ? '<div class="timeline-line bg-light" style="width: 2px; flex-grow: 1; min-height: 40px;"></div>' : ''}
                        </div>
                        <div class="flex-grow-1 pb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-${color}-subtle text-${color} mb-1">${label}</span>
                                    <h6 class="mb-0 fw-semibold">${event.reader}</h6>
                                    <small class="text-muted">${event.location}</small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    <iconify-icon icon="solar:clock-circle-bold" class="me-1"></iconify-icon>
                                    ${event.time}
                                </span>
                            </div>
                            <div class="small text-muted">
                                <iconify-icon icon="solar:map-point-outline" class="me-1"></iconify-icon>
                                Zona: ${event.zone}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        html += '</div>';

        content.innerHTML = html;
    }
});
</script>

<style>
.accordion-collapse {
    transition: all 0.3s ease;
}

.timeline-vertical {
    position: relative;
}

.timeline-item {
    position: relative;
}

.table-hover tbody tr:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
    cursor: pointer;
}
</style>
@endpush

