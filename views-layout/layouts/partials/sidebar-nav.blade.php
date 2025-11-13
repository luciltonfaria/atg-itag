<nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">

        <!-- ===================================== -->
        <!-- Dashboard -->
        <!-- ===================================== -->
        <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
            <span class="hide-menu">Principal</span>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:widget-2-line-duotone"></iconify-icon>
                <span class="hide-menu">Dashboard</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}">
                        <iconify-icon icon="solar:chart-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Visão geral</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard.map') }}">
                        <iconify-icon icon="solar:map-point-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Mapa do campus</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard.reports') }}">
                        <iconify-icon icon="solar:graph-new-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Relatórios rápidos</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ===================================== -->
        <!-- Escolas e turmas -->
        <!-- ===================================== -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:buildings-2-line-duotone"></iconify-icon>
                <span class="hide-menu">Escolas e turmas</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('schools.index') }}">
                        <iconify-icon icon="solar:buildings-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Escolas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('classes.index') }}">
                        <iconify-icon icon="solar:book-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Turmas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('students.index') }}">
                        <iconify-icon icon="solar:users-group-rounded-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    
            </ul>
        </li>

        <!-- ===================================== -->
        <!-- Antenas e zonas -->
        <!-- ===================================== -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="mdi:antenna"></iconify-icon>
                <span class="hide-menu">Antenas e zonas</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('readers.index') }}">
                        <iconify-icon icon="solar:wifi-router-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Antenas / Leitores</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('zones.index') }}">
                        <iconify-icon icon="solar:map-arrow-square-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Zonas e áreas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('policies.index') }}">
                        <iconify-icon icon="solar:shield-warning-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Políticas e restrições</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <span class="sidebar-divider"></span>
        </li>

        <!-- ===================================== -->
        <!-- Presenças e movimentações -->
        <!-- ===================================== -->
        <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
            <span class="hide-menu">Monitoramento</span>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:clock-circle-line-duotone"></iconify-icon>
                <span class="hide-menu">Presenças</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('movements.live') }}">
                        <iconify-icon icon="solar:pulse-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação em tempo real</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('movements.history') }}">
                        <iconify-icon icon="solar:history-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Histórico detalhado</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <span class="sidebar-divider"></span>
        </li>

        <!-- ===================================== -->
        <!-- Administração -->
        <!-- ===================================== -->
        <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
            <span class="hide-menu">Gestão</span>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:users-group-rounded-line-duotone"></iconify-icon>
                <span class="hide-menu">Administração</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <iconify-icon icon="solar:user-id-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Usuários e permissões</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.itag') }}">
                        <iconify-icon icon="solar:key-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Perfis iTAG / Integração</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('admin.integrations') }}">
                        <iconify-icon icon="solar:link-circle-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Integrações externas</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ===================================== -->
        <!-- Auditoria e segurança -->
        <!-- ===================================== -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:shield-check-line-duotone"></iconify-icon>
                <span class="hide-menu">Auditoria e segurança</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('audit.system') }}">
                        <iconify-icon icon="solar:clipboard-list-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Logs de sistema</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('audit.rfid') }}">
                        <iconify-icon icon="solar:satellite-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Atividade RFID</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    
                </li>
            </ul>
        </li>

        <!-- ===================================== -->
        <!-- Relatórios -->
        <!-- ===================================== -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:document-text-line-duotone"></iconify-icon>
                <span class="hide-menu">Relatórios</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('reports.class') }}">
                        <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Presença por turma</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('reports.time') }}">
                        <iconify-icon icon="solar:clock-square-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Tempo médio no campus</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('reports.readers') }}">
                        <iconify-icon icon="solar:routing-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Desempenho das antenas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('reports.incidents') }}">
                        <iconify-icon icon="solar:danger-circle-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Ocorrências e violações</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('reports.export') }}">
                        <iconify-icon icon="solar:download-square-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Exportações personalizadas</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <span class="sidebar-divider"></span>
        </li>

        <!-- ===================================== -->
        <!-- Configurações -->
        <!-- ===================================== -->
        <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
            <span class="hide-menu">Sistema</span>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:settings-minimalistic-line-duotone"></iconify-icon>
                <span class="hide-menu">Configurações</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('settings.theme') }}">
                        <iconify-icon icon="solar:palette-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Tema e identidade visual</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('settings.notifications') }}">
                        <iconify-icon icon="solar:bell-bing-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Notificações e alertas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('settings.timing') }}">
                        <iconify-icon icon="solar:stopwatch-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Janelas de atraso</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>