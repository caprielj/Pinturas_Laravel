@extends('layouts.app')

@section('title', 'Nuevo Usuario - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Nuevo Usuario</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-person-plus me-2"></i>
            Nuevo Usuario
        </h2>
        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al listado
        </a>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Información del Usuario
                </div>
                <div class="card-body">
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf

                        {{-- Información Personal --}}
                        <h5 class="mb-3 text-muted">
                            <i class="bi bi-person me-2"></i>
                            Información Personal
                        </h5>

                        <div class="mb-3">
                            {{-- Nombre --}}
                            <label for="nombre" class="form-label">
                                Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required
                                   placeholder="Ej: Juan Pérez López">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            {{-- DPI --}}
                            <div class="col-md-6">
                                <label for="dpi" class="form-label">
                                    DPI <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('dpi') is-invalid @enderror" 
                                       id="dpi" 
                                       name="dpi" 
                                       value="{{ old('dpi') }}" 
                                       required
                                       placeholder="Ej: 1234567890101">
                                <small class="text-muted">13 dígitos, debe ser único</small>
                                @error('dpi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       placeholder="usuario@paints.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-lock me-2"></i>
                            Credenciales de Acceso
                        </h5>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       placeholder="Mínimo 6 caracteres">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    Confirmar Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       placeholder="Repite la contraseña">
                            </div>
                        </div>

                        {{-- Asignación --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-briefcase me-2"></i>
                            Asignación de Rol y Sucursal
                        </h5>

                        <div class="row mb-3">
                            {{-- Rol --}}
                            <div class="col-md-6">
                                <label for="rol_id" class="form-label">
                                    Rol <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('rol_id') is-invalid @enderror" 
                                        id="rol_id" 
                                        name="rol_id" 
                                        required>
                                    <option value="">Seleccione un rol</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rol_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sucursal --}}
                            <div class="col-md-6">
                                <label for="sucursal_id" class="form-label">Sucursal</label>
                                <select class="form-select @error('sucursal_id') is-invalid @enderror" 
                                        id="sucursal_id" 
                                        name="sucursal_id">
                                    <option value="">Sin asignar</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" {{ old('sucursal_id') == $sucursal->id ? 'selected' : '' }}>
                                            {{ $sucursal->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Opcional - Sucursal donde trabajará el usuario</small>
                                @error('sucursal_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Estado --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-toggle-on me-2"></i>
                            Estado
                        </h5>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo"
                                       value="1"
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Usuario Activo
                                </label>
                                <small class="text-muted d-block">
                                    Solo los usuarios activos pueden acceder al sistema
                                </small>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con ayuda --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Campos Obligatorios
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Nombre completo</li>
                        <li>DPI (13 dígitos, único)</li>
                        <li>Email (único)</li>
                        <li>Contraseña (mínimo 6 caracteres)</li>
                        <li>Rol</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-people me-2"></i>
                    Roles del Sistema
                </div>
                <div class="card-body">
                    <h6 class="card-title">Digitador</h6>
                    <p class="small mb-2">
                        Encargado de alimentar el sistema con datos (productos, clientes, proveedores, etc.)
                    </p>

                    <h6 class="card-title">Cajero</h6>
                    <p class="small mb-2">
                        Solo puede cobrar y autorizar ventas. No tiene acceso a otras funciones.
                    </p>

                    <h6 class="card-title">Gerente</h6>
                    <p class="small mb-0">
                        Puede observar reportes, estadísticas y análisis del sistema.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection