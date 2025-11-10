@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="bi bi-credit-card me-2"></i>Medios de Pago</h2>
        <a href="{{ route('medios-pago.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nuevo Medio de Pago
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
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mediosPago as $medioPago)
                        <tr>
                            <td>
                                <i class="bi bi-{{ 
                                    str_contains(strtolower($medioPago->nombre), 'efectivo') ? 'cash-stack' : 
                                    (str_contains(strtolower($medioPago->nombre), 'cheque') ? 'receipt' : 
                                    (str_contains(strtolower($medioPago->nombre), 'transferencia') || str_contains(strtolower($medioPago->nombre), 'banco') ? 'bank' : 'credit-card'))
                                }} me-2"></i>
                                {{ $medioPago->nombre }}
                            </td>
                            <td>
                                @if($medioPago->activo)
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
                                <a href="{{ route('medios-pago.show', $medioPago->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('medios-pago.edit', $medioPago->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('medios-pago.destroy', $medioPago->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('¿Eliminar medio de pago?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay medios de pago registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection