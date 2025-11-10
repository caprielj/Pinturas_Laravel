@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-pencil-square me-2"></i>Editar Usuario</h2>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3"><i class="bi bi-person me-2"></i>Información Personal</h5>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo *</label>
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $usuario->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="dpi" class="form-label">DPI *</label>
                        <input type="text" name="dpi" id="dpi" 
                               class="form-control @error('dpi') is-invalid @enderror" 
                               value="{{ old('dpi', $usuario->dpi) }}" required>
                        @error('dpi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $usuario->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h5 class="mb-3 mt-4"><i class="bi bi-lock me-2"></i>Cambiar Contraseña</h5>

                <div class="alert alert-warning">
                    <i class="bi bi-info-circle me-2"></i>
                    Deja estos campos en blanco si no deseas cambiar la contraseña
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" 
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="form-control">
                    </div>
                </div>

                <h5 class="mb-3 mt-4"><i class="bi bi-briefcase me-2"></i>Asignación</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="rol_id" class="form-label">Rol *</label>
                        <select name="rol_id" id="rol_id" 
                                class="form-select @error('rol_id') is-invalid @enderror" required>
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
                    <div class="col-md-6">
                        <label for="sucursal_id" class="form-label">Sucursal</label>
                        <select name="sucursal_id" id="sucursal_id" 
                                class="form-select @error('sucursal_id') is-invalid @enderror">
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

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="activo" 
                               name="activo" value="1" {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">
                            <i class="bi bi-check-circle me-1"></i>Usuario Activo
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Actualizar
                </button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection