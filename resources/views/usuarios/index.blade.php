@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-person-badge me-2"></i>Usuarios</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nuevo Usuario
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nombre }}</td>
                            <td>
                                <i class="bi bi-envelope me-1"></i>
                                {{ $usuario->email }}
                            </td>
                            <td>
                                @if($usuario->rol)
                                    @php
                                        $badgeClass = match($usuario->rol->nombre) {
                                            'Gerente' => 'bg-danger',
                                            'Cajero' => 'bg-warning text-dark',
                                            'Digitador' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $usuario->rol->nombre }}
                                    </span>
                                @else
                                    <span class="text-muted">Sin rol</span>
                                @endif
                            </td>
                            <td>
                                @if($usuario->sucursal)
                                    <span class="badge bg-secondary">{{ $usuario->sucursal->nombre }}</span>
                                @else
                                    <span class="text-muted">Sin asignar</span>
                                @endif
                            </td>
                            <td>
                                @if($usuario->activo)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Activo
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Inactivo
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar usuario?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay usuarios registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection