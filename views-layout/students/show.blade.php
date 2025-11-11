@extends('layouts.app')

@section('title', 'Detalhes do Aluno')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Detalhes do Aluno</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Card de Informações Gerais -->
        <div class="card mb-4">
            <div class="card-header bg-primary-subtle">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:user-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Informações do Aluno
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Matrícula</label>
                            <p class="mb-0 fw-semibold">
                                @if($student->external_code)
                                <span class="badge bg-secondary-subtle text-secondary fs-5">
                                    {{ $student->external_code }}
                                </span>
                                @else
                                <span class="text-muted">Não informado</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nome Completo</label>
                            <p class="mb-0 fw-semibold fs-5">{{ $student->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Escola</label>
                            <p class="mb-0">
                                <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 me-1 text-primary"></iconify-icon>
                                <a href="{{ route('schools.show', $student->school) }}" class="text-decoration-none">
                                    {{ $student->school->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Data de Nascimento</label>
                            <p class="mb-0 fw-semibold">
                                @if($student->birth_date)
                                {{ \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') }}
                                <small class="text-muted">({{ \Carbon\Carbon::parse($student->birth_date)->age }} anos)</small>
                                @else
                                <span class="text-muted">Não informado</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Status</label>
                            <p class="mb-0">
                                @if($student->active)
                                <span class="badge bg-success-subtle text-success fs-5">Ativo</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger fs-5">Inativo</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Cadastrado em</label>
                            <p class="mb-0">{{ $student->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Tags RFID -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:card-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Tags RFID ({{ $student->tags->count() }})
                </h5>
                <a href="{{ route('tags.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-primary">
                    <iconify-icon icon="solar:add-circle-line-duotone"></iconify-icon>
                    Nova Tag
                </a>
            </div>
            <div class="card-body">
                @if($student->tags->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>EPC</th>
                                <th>Emitida em</th>
                                <th>Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->tags as $tag)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $tag->epc }}
                                    </span>
                                </td>
                                <td>
                                    {{ $tag->issued_at ? \Carbon\Carbon::parse($tag->issued_at)->format('d/m/Y') : '-' }}
                                </td>
                                <td>
                                    @if($tag->active)
                                    <span class="badge bg-success-subtle text-success">Ativa</span>
                                    @else
                                    <span class="badge bg-danger-subtle text-danger">Inativa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('tags.show', $tag) }}" class="btn btn-sm btn-light">
                                        <iconify-icon icon="solar:eye-line-duotone"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <iconify-icon icon="solar:card-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted mb-3">Nenhuma tag RFID vinculada a este aluno.</p>
                    <a href="{{ route('tags.create', ['student_id' => $student->id]) }}" class="btn btn-primary">
                        <iconify-icon icon="solar:add-circle-line-duotone" class="me-1"></iconify-icon>
                        Vincular Primeira Tag
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Card de Turmas -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Turmas ({{ $student->enrollments->count() }})
                </h5>
            </div>
            <div class="card-body">
                @if($student->enrollments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Turma</th>
                                <th>Ano</th>
                                <th>Matrícula em</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->enrollments as $enrollment)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        {{ $enrollment->class->code }}
                                    </span>
                                </td>
                                <td>{{ $enrollment->class->name }}</td>
                                <td>{{ $enrollment->class->year }}</td>
                                <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted">Aluno não matriculado em nenhuma turma.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection