@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-semibold">Gerenciamento de Usuários</h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <iconify-icon icon="solar:user-plus-line-duotone" class="fs-5 me-1"></iconify-icon>
                Novo Usuário
            </a>
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
                    <table class="table table-hover align-middle text-nowrap mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Escola Associada</th>
                                <th class="text-center" style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="round-40 bg-primary-subtle rounded d-flex align-items-center justify-content-center flex-shrink-0">
                                            <iconify-icon icon="solar:user-line-duotone" class="fs-5 text-primary"></iconify-icon>
                                        </div>
                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->escola)
                                    <span class="badge bg-success-subtle text-success">
                                        <iconify-icon icon="solar:buildings-2-line-duotone" class="me-1"></iconify-icon>
                                        {{ $user->escola->nome }}
                                    </span>
                                    @else
                                    <span class="badge bg-warning-subtle text-warning">
                                        <iconify-icon icon="solar:danger-triangle-line-duotone" class="me-1"></iconify-icon>
                                        Sem escola
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info" title="Visualizar">
                                            <iconify-icon icon="solar:eye-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <iconify-icon icon="solar:pen-line-duotone" class="fs-5"></iconify-icon>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <iconify-icon icon="solar:trash-bin-trash-line-duotone" class="fs-5"></iconify-icon>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-10 mb-3"></iconify-icon>
                                        <p class="mb-0">Nenhum usuário cadastrado</p>
                                        <small>Clique em "Novo Usuário" para adicionar</small>
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