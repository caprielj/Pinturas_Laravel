{{-- 
    Vista: clientes/index.blade.php
    
    Descripción: Muestra el listado de todos los clientes registrados
    
    Variables recibidas desde el controlador:
    - $clientes: Collection con todos los clientes
    
    Iconos Bootstrap Icons usados:
    - bi-people: Ícono de personas (grupo)
    - bi-plus-circle: Ícono de agregar
    - bi-envelope: Ícono de email
    - bi-telephone: Ícono de teléfono
    - bi-check-circle: Ícono de verificado
    - bi-clock: Ícono de reloj (pendiente)
    - bi-bell: Ícono de notificaciones
    - bi-eye: Ícono de ver
    - bi-pencil: Ícono de editar
    - bi-trash: Ícono de eliminar
--}}

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Encabezado con título y botón de nuevo cliente --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-people me-2"></i>Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nuevo Cliente
        </a>
    </div>

    {{-- Mensajes flash de éxito o error --}}
    {{-- session('success') verifica si existe una variable de sesión llamada 'success' --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Card contenedor de la tabla --}}
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Verificado</th>
                        <th>Promociones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                        @forelse: Similar a foreach pero con opción @empty si no hay datos
                        $clientes as $cliente: Itera sobre cada cliente
                    --}}
                    @forelse($clientes as $cliente)
                        <tr>
                            {{-- Columna Nombre --}}
                            <td>{{ $cliente->nombre }}</td>
                            
                            {{-- Columna Email con ícono --}}
                            <td>
                                <i class="bi bi-envelope me-1"></i>
                                {{ $cliente->email }}
                            </td>
                            
                            {{-- 
                                Columna Teléfono
                                ?? 'N/A' = operador null coalescing
                                Si telefono es null, muestra 'N/A'
                            --}}
                            <td>
                                <i class="bi bi-telephone me-1"></i>
                                {{ $cliente->telefono ?? 'N/A' }}
                            </td>
                            
                            {{-- 
                                Columna Verificado
                                @if: Condicional en Blade
                                Badge verde si está verificado, amarillo si no
                            --}}
                            <td>
                                @if($cliente->verificado)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Verificado
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="bi bi-clock me-1"></i>Pendiente
                                    </span>
                                @endif
                            </td>
                            
                            {{-- Columna Acepta Promociones --}}
                            <td>
                                @if($cliente->opt_in_promos)
                                    <span class="badge bg-info">
                                        <i class="bi bi-bell me-1"></i>Sí
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            
                            {{-- 
                                Columna Acciones
                                Contiene 3 botones: Ver, Editar, Eliminar
                            --}}
                            <td>
                                {{-- Botón Ver Detalles --}}
                                <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                {{-- Botón Editar --}}
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                {{-- 
                                    Formulario para Eliminar
                                    method="POST" porque los formularios HTML solo soportan GET y POST
                                    @method('DELETE') crea un campo oculto _method=DELETE para Laravel
                                    onclick="return confirm(...)" muestra diálogo de confirmación
                                --}}
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar cliente?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Se muestra si $clientes está vacío --}}
                        <tr>
                            <td colspan="6" class="text-center">No hay clientes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection