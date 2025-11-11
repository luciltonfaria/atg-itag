<header class="topbar">
    <div class="with-vertical">
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item d-flex d-xl-none">
                    <a class="nav-link nav-icon-hover-bg rounded-circle sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-flex align-items-center nav-icon-hover-bg rounded-circle">
                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="solar:magnifer-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                </li>
            </ul>

            <a class="navbar-toggler p-0 border-0 nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <iconify-icon icon="solar:menu-dots-bold-duotone" class="fs-6"></iconify-icon>
            </a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <ul class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                        <!-- Dark/Light Mode Toggle -->
                        <li class="nav-item">
                            <a class="nav-link moon dark-layout nav-icon-hover-bg rounded-circle" href="javascript:void(0)">
                                <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                            </a>
                            <a class="nav-link sun light-layout nav-icon-hover-bg rounded-circle" href="javascript:void(0)" style="display: none">
                                <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                            </a>
                        </li>

                        <!-- Notifications -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover-bg rounded-circle" href="javascript:void(0)" id="drop2" aria-expanded="false">
                                <iconify-icon icon="solar:bell-bing-line-duotone" class="fs-6"></iconify-icon>
                                <div class="notification"></div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">Notificações</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 novas</span>
                                </div>
                                <div class="message-body" data-simplebar>
                                    <a href="javascript:void(0)" class="py-6 px-7 d-flex align-items-center dropdown-item gap-3">
                                        <span class="flex-shrink-0 bg-danger-subtle rounded-circle round text-danger d-flex align-items-center justify-content-center fs-6 ">
                                            <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                        </span>
                                        <div class="w-75">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="mb-1 fw-semibold">Nova movimentação detectada</h6>
                                                <span class="d-block fs-2">há 2 min</span>
                                            </div>
                                            <span class="d-block text-truncate text-muted fs-2">Aluno detectado na portaria</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <a href="javascript:void(0)" class="btn btn-primary w-100">Ver todas notificações</a>
                                </div>
                            </div>
                        </li>

                        <!-- User Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center gap-2 lh-base">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="user" />
                                    <iconify-icon icon="solar:alt-arrow-down-bold" class="fs-2"></iconify-icon>
                                </div>
                            </a>
                            <div class="dropdown-menu profile-dropdown dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                                <div class="position-relative px-4 pt-3 pb-2">
                                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom gap-6">
                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="56" height="56" alt="user" />
                                        <div>
                                            <h5 class="mb-0 fs-12">{{ auth()->user()->name ?? 'Usuário' }}</h5>
                                            <p class="mb-0 text-dark">{{ auth()->user()->email ?? 'email@exemplo.com' }}</p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="#" class="p-2 dropdown-item h6 rounded-1">
                                            <iconify-icon icon="solar:user-circle-line-duotone" class="fs-6 me-2"></iconify-icon>
                                            Meu Perfil
                                        </a>
                                        <a href="#" class="p-2 dropdown-item h6 rounded-1">
                                            <iconify-icon icon="solar:settings-line-duotone" class="fs-6 me-2"></iconify-icon>
                                            Configurações da Conta
                                        </a>
                                    </div>
                                    <div class="py-4 px-1 mt-2 border-top">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary w-100">Sair</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Search Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <input type="search" class="form-control" placeholder="Buscar..." id="search" />
                <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                    <iconify-icon icon="solar:close-circle-line-duotone" class="fs-5 ms-3"></iconify-icon>
                </a>
            </div>
            <div class="modal-body message-body" data-simplebar="">
                <h5 class="mb-0 fs-5 p-1">Resultados da busca</h5>
                <ul class="list mb-0 py-2">
                    <li class="p-1 mb-1 bg-hover-light-black rounded px-3 py-2">
                        <span class="text-dark fw-semibold d-block">Nenhum resultado encontrado</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>