<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            @can('view clients')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                    <i class="fas fa-users"></i> Clientes
                </a>
            </li>
            @endcan
            @can('view invoices')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('faturas.*') ? 'active' : '' }}" href="{{ route('faturas.index') }}">
                    <i class="fas fa-file-invoice"></i> Faturas
                </a>
            </li>
            @endcan
            @can('view consumption')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('consumos.*') ? 'active' : '' }}" href="{{ route('consumos.index') }}">
                    <i class="fas fa-chart-line"></i> Consumo
                </a>
            </li>
            @endcan
            @can('manage settings')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('configuracoes.*') ? 'active' : '' }}" href="{{ route('configuracoes.index') }}">
                    <i class="fas fa-cog"></i> Configurações
                </a>
            </li>
            @endcan
        </ul>
    </div>
</nav>
