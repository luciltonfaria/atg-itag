@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0">Gerenciamento de Usuários</h4>
            <div>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:user-plus-rounded-line-duotone" class="fs-5 me-1"></iconify-icon>
                    Novo Usuário
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:check-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:danger-circle-line-duotone" class="fs-5 me-2"></iconify-icon>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-nowrap">
                        <thead class="text-bg-primary">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Escolas Vinculadas</th>
                                <th>Cadastro</th>
                                <th class="text-center" style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td><strong>#{{ $user->id }}</strong></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                    $schoolsCount = $user->schools()->count();
                                    @endphp
                                    @if($schoolsCount > 0)
                                    <span class="badge bg-info-subtle text-info">{{ $schoolsCount }} escola(s)</span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <iconify-icon icon="solar:pen-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-8 mb-2"></iconify-icon>
                                        <p class="mb-0">Nenhum usuário cadastrado</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection