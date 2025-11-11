@extends('layouts.app')

@section('title', 'Detalhes da Turma')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Detalhes da Turma</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('classes.edit', $class) }}" class="btn btn-primary">
                    <iconify-icon icon="solar:pen-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Editar
                </a>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                    <iconify-icon icon="solar:arrow-left-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Voltar
                </a>
            </div>
        </div>

        <!-- Card de Informações Gerais -->
        <div class="card mb-4">
            <div class="card-header bg-primary-subtle">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Informações da Turma
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Código</label>
                            <p class="mb-0 fw-semibold">
                                <span class="badge bg-primary-subtle text-primary fs-4">
                                    {{ $class->code }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nome da Turma</label>
                            <p class="mb-0 fw-semibold fs-5">{{ $class->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Escola</label>
                            <p class="mb-0">
                                <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-5 me-1 text-primary"></iconify-icon>
                                <a href="{{ route('schools.show', $class->school) }}" class="text-decoration-none">
                                    {{ $class->school->name }}
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted small">Ano Letivo</label>
                            <p class="mb-0 fw-semibold">
                                @if($class->year)
                                <span class="badge bg-secondary-subtle text-secondary fs-5">
                                    {{ $class->year }}
                                </span>
                                @else
                                <span class="text-muted">Não informado</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Total de Alunos</label>
                            <p class="mb-0">
                                <span class="badge bg-info-subtle text-info fs-5">
                                    {{ $class->enrollments->count() }} aluno(s)
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Cadastrado em</label>
                            <p class="mb-0">{{ $class->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Alunos Matriculados -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <iconify-icon icon="solar:user-line-duotone" class="fs-5 me-2"></iconify-icon>
                    Alunos Matriculados ({{ $class->enrollments->count() }})
                </h5>
                @if($class->enrollments->count() > 0)
                <button class="btn btn-sm btn-primary">
                    <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Adicionar Aluno
                </button>
                @endif
            </div>
            <div class="card-body">
                @if($class->enrollments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Matrícula</th>
                                <th>Nome</th>
                                <th>Data de Matrícula</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->enrollments as $enrollment)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        {{ $enrollment->student->registration_number }}
                                    </span>
                                </td>
                                <td class="fw-semibold">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary-subtle rounded-circle p-2">
                                            <iconify-icon icon="solar:user-line-duotone" class="fs-5 text-primary"></iconify-icon>
                                        </div>
                                        {{ $enrollment->student->name }}
                                    </div>
                                </td>
                                <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success-subtle text-success">
                                        Ativo
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-light" title="Ver aluno">
                                        <iconify-icon icon="solar:eye-line-duotone" class="fs-5"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-1 text-muted mb-3"></iconify-icon>
                    <p class="text-muted mb-3">Nenhum aluno matriculado nesta turma ainda.</p>
                    <button class="btn btn-primary">
                        <iconify-icon icon="solar:add-circle-line-duotone" class="fs-5 me-1"></iconify-icon>
                        Matricular Primeiro Aluno
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection