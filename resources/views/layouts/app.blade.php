<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @include('layouts.header')

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

<!-- resources/views/layouts/sidebar.blade.php -->
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

<!-- resources/views/layouts/header.blade.php -->
<header class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 shadow">
    <div class="navbar-brand col-md-3 col-lg-2 me-0 px-3">
        {{ config('app.name') }}
    </div>
    <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link px-3 bg-transparent border-0">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </button>
            </form>
        </div>
    </div>
</header>
