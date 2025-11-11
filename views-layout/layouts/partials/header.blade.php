<header class="topbar">
    <div class="with-vertical">
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item d-flex d-xl-none">
                    <a class="nav-link nav-icon-hover-bg rounded-circle sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-6"></iconify-icon>
                    </a>
                </li>
            </ul>

            <a class="navbar-toggler p-0 border-0 nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <iconify-icon icon="solar:menu-dots-bold-duotone" class="fs-6"></iconify-icon>
            </a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <!-- Period Selector -->
                    <div class="d-none d-lg-flex me-3">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Seletor de período">
                            <input type="radio" class="btn-check period-selector" name="periodSelector" id="periodToday"
                                data-period="today" autocomplete="off" {{ ($period ?? 'today') === 'today' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="periodToday">Hoje</label>

                            <input type="radio" class="btn-check period-selector" name="periodSelector" id="period7days"
                                data-period="7days" autocomplete="off" {{ ($period ?? 'today') === '7days' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="period7days">7 Dias</label>

                            <input type="radio" class="btn-check period-selector" name="periodSelector" id="period14days"
                                data-period="14days" autocomplete="off" {{ ($period ?? 'today') === '14days' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="period14days">14 Dias</label>

                            <input type="radio" class="btn-check period-selector" name="periodSelector" id="period30days"
                                data-period="30days" autocomplete="off" {{ ($period ?? 'today') === '30days' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="period30days">30 Dias</label>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.period-selector').forEach(function(radio) {
                                radio.addEventListener('change', function() {
                                    if (this.checked) {
                                        const period = this.getAttribute('data-period');
                                        const url = new URL(window.location.href);
                                        url.searchParams.set('period', period);
                                        window.location.href = url.toString();
                                    }
                                });
                            });
                        });
                    </script>

                    <ul class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link moon dark-layout nav-icon-hover-bg rounded-circle" href="javascript:void(0)">
                                <iconify-icon icon="solar:moon-line-duotone" class="moon fs-6"></iconify-icon>
                            </a>
                            <a class="nav-link sun light-layout nav-icon-hover-bg rounded-circle" href="javascript:void(0)" style="display: none">
                                <iconify-icon icon="solar:sun-2-line-duotone" class="sun fs-6"></iconify-icon>
                            </a>
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
                                            <h5 class="mb-0 fs-12">{{ auth()->user()->name ?? 'Administrador' }}</h5>
                                            <p class="mb-0 text-dark">{{ auth()->user()->email ?? 'admin@exemplo.com' }}</p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="{{ route('profile') }}" class="p-2 dropdown-item h6 rounded-1">
                                            Meu Perfil
                                        </a>
                                        <a href="{{ route('settings.index') }}" class="p-2 dropdown-item h6 rounded-1">
                                            Configurações
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