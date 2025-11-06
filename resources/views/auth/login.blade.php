@extends('layouts.base')

@section('title', 'Login - AutoHub')

@section('body')
    <div class="d-flex justify-content-center align-items-center flex-column flex-grow-1 py-5">
        <div class="card shadow-sm" style="max-width: 420px; width: 100%;">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="rounded-circle brand-gradient text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <i class="bi bi-shield-lock fs-4"></i>
                    </div>
                    <h1 class="h4 fw-semibold mb-1">Acesso Administrativo</h1>
                    <p class="text-muted mb-0">Entre para gerenciar marcas, modelos e veículos.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login.perform') }}" class="vstack gap-3">
                    @csrf
                    <div>
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Manter conectado
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                    </button>
                </form>
                <p class="text-center text-muted mt-4 mb-0">
                    Utilize as credenciais definidas no seeder (admin@autohub.com / senha-segura).
                </p>
            </div>
        </div>
        <a href="{{ route('home') }}" class="text-muted mt-4 text-decoration-none">
            <i class="bi bi-arrow-left"></i> Voltar ao site público
        </a>
    </div>
@endsection
