<aside class="side-mini-panel with-vertical">
    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="iconbar">
        <div>
            <div class="mini-nav">
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                    </a>
                </div>
                <ul class="mini-nav-ul" data-simplebar>

                    <!-- ===================================== -->
                    <!-- Dashboard -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-1">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Dashboard">
                            <iconify-icon icon="solar:widget-2-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <!-- ===================================== -->
                    <!-- Escolas e turmas -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-2">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Escolas e turmas">
                            <iconify-icon icon="solar:buildings-2-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <!-- ===================================== -->
                    <!-- Antenas e zonas -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-3">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Antenas e zonas">
                            <iconify-icon icon="mdi:antenna" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <li>
                        <span class="sidebar-divider lg"></span>
                    </li>

                    <!-- ===================================== -->
                    <!-- Presenças e movimentações -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-4">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Presenças">
                            <iconify-icon icon="solar:clock-circle-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <li>
                        <span class="sidebar-divider lg"></span>
                    </li>

                    <!-- ===================================== -->
                    <!-- Administração -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-5">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Administração">
                            <iconify-icon icon="solar:users-group-rounded-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <!-- ===================================== -->
                    <!-- Auditoria e segurança -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-6">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Auditoria e segurança">
                            <iconify-icon icon="solar:shield-check-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <!-- ===================================== -->
                    <!-- Relatórios -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-7">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Relatórios">
                            <iconify-icon icon="solar:document-text-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                    <li>
                        <span class="sidebar-divider lg"></span>
                    </li>

                    <!-- ===================================== -->
                    <!-- Configurações -->
                    <!-- ===================================== -->
                    <li class="mini-nav-item" id="mini-8">
                        <a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="right" data-bs-title="Configurações">
                            <iconify-icon icon="solar:settings-minimalistic-line-duotone" class="fs-7"></iconify-icon>
                        </a>
                    </li>

                </ul>

            </div>
            <div class="sidebarmenu">
                <div class="brand-logo d-flex align-items-center nav-logo">
                    <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/logo-comprida.webp') }}" alt="Logo" style="width: 90%;" />
                    </a>
                </div>

                <!-- Sidebar Navigation -->
                @include('layouts.partials.sidebar-nav')
            </div>
        </div>
    </div>
</aside>