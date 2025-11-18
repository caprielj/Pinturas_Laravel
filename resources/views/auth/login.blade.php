@extends('layouts.guest')

@section('title', 'Login - Paints')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        {{-- Card de Login --}}
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                {{-- Logo y Título --}}
                <div class="text-center mb-4">
                    <i class="bi bi-paint-bucket text-primary" style="font-size: 3rem;"></i>
                    <h2 class="mt-3 mb-1">Paints</h2>
                    <p class="text-muted">Sistema de Gestión</p>
                </div>

                {{-- Alertas de error --}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                {{-- Mensaje de éxito (por ejemplo, después de logout) --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Formulario de Login --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-1"></i>
                            Correo Electrónico
                        </label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="usuario@ejemplo.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-1"></i>
                            Contraseña
                        </label>
                        <input
                            type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                        >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Recordarme --}}
                    <div class="mb-3 form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="remember"
                            name="remember"
                        >
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>

                    {{-- Botón de Login --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Iniciar Sesión
                        </button>
                    </div>
                </form>

                {{-- Link para volver a inicio --}}
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>

        {{-- Info adicional --}}
        <div class="text-center mt-3 text-white">
            <small>
                <i class="bi bi-shield-check me-1"></i>
                Acceso solo para personal autorizado
            </small>
        </div>
    </div>
</div>
@endsection
