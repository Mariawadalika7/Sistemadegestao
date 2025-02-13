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
