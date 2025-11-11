<!-- Menu para mini-1: Dashboard -->
<nav class="sidebar-nav" id="menu-right-mini-1" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:map-point-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Mapa do campus</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <!-- item movido para o grupo Relatórios -->
                </li>
            </ul>
        </li>

        <!-- Escolas e turmas -->
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:book-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Turmas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:users-group-rounded-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:tag-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Crachás RFID / Tags</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Antenas e zonas -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:transmition-circle-line-duotone"></iconify-icon>
                <span class="hide-menu">Antenas e zonas</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:wifi-router-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Antenas / Leitores</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:map-arrow-square-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Zonas e áreas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:shield-warning-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Políticas e restrições</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <span class="sidebar-divider"></span>
        </li>

        <!-- Presenças e movimentações -->
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:calendar-date-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Presenças diárias</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:pulse-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação em tempo real</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:history-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Histórico detalhado</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <span class="sidebar-divider"></span>
        </li>

        <!-- Administração / Gestão -->
        <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
            <span class="hide-menu">Gestão</span>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                <span class="hide-menu">Administração</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <iconify-icon icon="solar:user-id-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Usuários e permissões</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Auditoria e segurança -->
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:satellite-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Atividade RFID</span>
                    </a>
                </li>
                
            </ul>
        </li>

        <!-- Relatórios -->
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:document-text-line-duotone"></iconify-icon>
                <span class="hide-menu">Relatórios</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.movimentacao-aluno') }}">
                        <iconify-icon icon="solar:user-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação por Aluno</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.movimentacao-turma') }}">
                        <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação por Turma</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.movimentacao-geral') }}">
                        <iconify-icon icon="solar:chart-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação Geral</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.faltas-turma') }}">
                        <iconify-icon icon="solar:close-circle-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos s/ Registro por Turma</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.faltas-geral') }}">
                        <iconify-icon icon="solar:danger-circle-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos s/ Registro Geral</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.rapidos') }}">
                        <iconify-icon icon="solar:graph-new-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Relatórios rápidos</span>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <span class="sidebar-divider"></span>
        </li>

    </ul>
    
</nav>

<!-- Menu para mini-2: Escolas e turmas -->
<nav class="sidebar-nav" id="menu-right-mini-2" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:book-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Turmas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:users-group-rounded-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:tag-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Crachás RFID / Tags</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Menu para mini-3: Antenas e zonas -->
<nav class="sidebar-nav" id="menu-right-mini-3" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:transmition-circle-line-duotone"></iconify-icon>
                <span class="hide-menu">Antenas e zonas</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:wifi-router-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Antenas / Leitores</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:map-arrow-square-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Zonas e áreas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:shield-warning-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Políticas e restrições</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Menu para mini-4: Presenças e movimentações -->
<nav class="sidebar-nav" id="menu-right-mini-4" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:calendar-date-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Presenças diárias</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:pulse-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação em tempo real</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:history-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Histórico detalhado</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Menu para mini-5: Administração -->
<nav class="sidebar-nav" id="menu-right-mini-5" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
        <li class="nav-small-cap">
            <iconify-icon icon="solar:menu-dots-line-duotone" class="nav-small-cap-icon fs-4"></iconify-icon>
            <span class="hide-menu">Gestão</span>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                <span class="hide-menu">Administração</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <iconify-icon icon="solar:user-id-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Usuários e permissões</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Menu para mini-6: Auditoria e segurança -->
<nav class="sidebar-nav" id="menu-right-mini-6" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
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
                    <a class="sidebar-link" href="#">
                        <iconify-icon icon="solar:satellite-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Atividade RFID</span>
                    </a>
                </li>
                
            </ul>
        </li>
    </ul>
</nav>

<!-- Menu para mini-7: Relatórios -->
<nav class="sidebar-nav" id="menu-right-mini-7" data-simplebar>
    <ul class="sidebar-menu" id="sidebarnav">
        <li class="sidebar-item">
            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                <iconify-icon icon="solar:document-text-line-duotone"></iconify-icon>
                <span class="hide-menu">Relatórios</span>
            </a>
            <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.movimentacao-aluno') }}">
                        <iconify-icon icon="solar:user-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação por Aluno</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.movimentacao-turma') }}">
                        <iconify-icon icon="solar:users-group-two-rounded-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação por Turma</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.movimentacao-geral') }}">
                        <iconify-icon icon="solar:chart-2-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Movimentação Geral</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.faltas-turma') }}">
                        <iconify-icon icon="solar:close-circle-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos s/ Registro por Turma</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.faltas-geral') }}">
                        <iconify-icon icon="solar:danger-circle-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Alunos s/ Registro Geral</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('relatorios.rapidos') }}">
                        <iconify-icon icon="solar:graph-new-line-duotone" class="icon-small"></iconify-icon>
                        <span class="hide-menu">Relatórios rápidos</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>