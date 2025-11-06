<nav class="navbar navbar-expand-lg navbar-dark brand-gradient shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('home') }}">
            <i class="bi bi-speedometer2 me-2"></i>AutoHub
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Veículos</a>
                </li>
            </ul>
            <div class="d-flex">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm me-2">Área Administrativa</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-light btn-sm" type="submit">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
