@extends('layouts.base')

@section('body')
    <div class="d-flex flex-column flex-lg-row min-vh-100">
        <aside class="bg-white border-end shadow-sm p-4" style="min-width: 260px;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <a href="{{ route('admin.dashboard') }}" class="fw-semibold text-decoration-none text-dark">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i>AutoHub Admin
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Sair</button>
                </form>
            </div>
            <nav class="nav nav-pills flex-column gap-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-dark' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-graph-up me-2"></i>Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.brands.index') }}">
                    <i class="bi bi-building me-2"></i>Marcas
                </a>
                <a class="nav-link {{ request()->routeIs('admin.models.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.models.index') }}">
                    <i class="bi bi-diagram-3 me-2"></i>Modelos
                </a>
                <a class="nav-link {{ request()->routeIs('admin.colors.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.colors.index') }}">
                    <i class="bi bi-palette me-2"></i>Cores
                </a>
                <a class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : 'text-dark' }}" href="{{ route('admin.vehicles.index') }}">
                    <i class="bi bi-car-front me-2"></i>Veículos
                </a>
            </nav>
        </aside>

        <main class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 fw-semibold">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-muted mb-0">@yield('page-description', 'Gerencie o estoque de veículos')</p>
                </div>
                @yield('page-actions')
            </div>
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ops!</strong> Verifique os campos destacados abaixo.
                </div>
            @endif
            @yield('content')
        </main>
    </div>
@endsection
