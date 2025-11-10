@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-person-circle me-2"></i>{{ $usuario->nombre }}</h2>
        <div>
            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-person me-2"></i>Información Personal
                </div>
                <div class="card-body">
                    <p><strong>DPI:</strong> {{ $usuario->dpi }}</p>
                    <p><strong>Email:</strong> 
                        <i class="bi bi-envelope me-1"></i>{{ $usuario->email }}
                    </p>
                    <p><strong>Estado:</strong> 
                        @if($usuario->activo)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Activo
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>Inactivo
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-briefcase me-2"></i>Asignación
                </div>
                <div class="card-body">
                    <p><strong>Rol:</strong> 
                        @if($usuario->rol)
                            @php
                                $badgeClass = match($usuario->rol->nombre) {
                                    'Gerente' => 'bg-danger',
                                    'Cajero' => 'bg-warning text-dark',
                                    'Digitador' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $usuario->rol->nombre }}</span>
                        @else
                            <span class="text-muted">Sin rol</span>
                        @endif
                    </p>
                    <p><strong>Sucursal:</strong> 
                        @if($usuario->sucursal)
                            <span class="badge bg-secondary">
                                <i class="bi bi-shop me-1"></i>{{ $usuario->sucursal->nombre }}
                            </span>
                        @else
                            <span class="text-muted">Sin asignar</span>
                        @endif
                    </p>
                    <p><strong>Fecha de registro:</strong> 
                        {{ $usuario->creado_en ? $usuario->creado_en->format('d/m/Y H:i') : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection