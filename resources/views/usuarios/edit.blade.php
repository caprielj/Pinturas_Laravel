@extends('layouts.app')

@section('title', 'Editar Usuario - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar Usuario</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-pencil-square me-2"></i>
            Editar Usuario: {{ $usuario->nombre }}
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
                    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                   value="{{ old('nombre', $usuario->nombre) }}" 
                                   required>
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
                                       value="{{ old('dpi', $usuario->dpi) }}" 
                                       required>
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
                                       value="{{ old('email', $usuario->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Contraseña --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-lock me-2"></i>
                            Cambiar Contraseña
                        </h5>

                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Nota:</strong> Deja estos campos en blanco si no deseas cambiar la contraseña.
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Dejar en blanco para mantener la actual">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Confirma la nueva contraseña">
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
                                        <option value="{{ $rol->id }}" 
                                                {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
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
                                        <option value="{{ $sucursal->id }}" 
                                                {{ old('sucursal_id', $usuario->sucursal_id) == $sucursal->id ? 'selected' : '' }}>
                                            {{ $sucursal->nombre }}
                                        </option>
                                    @endforeach
                                </select>
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
                                       {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Usuario Activo
                                </label>
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
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con información --}}
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información del Registro
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>ID:</strong> {{ $usuario->id }}
                    </p>
                    <p class="mb-2">
                        <strong>Fecha de Registro:</strong><br>
                        {{ $usuario->creado_en ? $usuario->creado_en->format('d/m/Y H:i') : 'N/A' }}
                    </p>
                    <p class="mb-2">
                        <strong>Rol Actual:</strong><br>
                        @if($usuario->rol)
                            <span class="badge bg-primary">{{ $usuario->rol->nombre }}</span>
                        @else
                            <span class="text-muted">Sin rol</span>
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong>Sucursal Actual:</strong><br>
                        @if($usuario->sucursal)
                            <span class="badge bg-secondary">{{ $usuario->sucursal->nombre }}</span>
                        @else
                            <span class="text-muted">Sin asignar</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Advertencia
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        Si desactivas este usuario, no podrá acceder al sistema. 
                        Si cambias su rol o sucursal, los permisos se actualizarán inmediatamente.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection