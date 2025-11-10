@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>
            <i class="bi bi-{{ 
                str_contains(strtolower($medioPago->nombre), 'efectivo') ? 'cash-stack' : 
                (str_contains(strtolower($medioPago->nombre), 'cheque') ? 'receipt' : 
                (str_contains(strtolower($medioPago->nombre), 'transferencia') || str_contains(strtolower($medioPago->nombre), 'banco') ? 'bank' : 'credit-card'))
            }} me-2"></i>
            {{ $medioPago->nombre }}
        </h2>
        <div>
            <a href="{{ route('medios-pago.edit', $medioPago->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Editar
            </a>
            <a href="{{ route('medios-pago.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Estado:</strong> 
                @if($medioPago->activo)
                    <span class="badge bg-success">
                        <i class="bi bi-check-circle me-1"></i>Activo
                    </span>
                @else
                    <span class="badge bg-danger">
                        <i class="bi bi-x-circle me-1"></i>Inactivo
                    </span>
                @endif
            </p>
            {{-- Temporalmente comentado - se activará en Fase 2 --}}
            {{-- <p><strong>Transacciones registradas:</strong> {{ $medioPago->pagos->count() }}</p> --}}
        </div>
    </div>
</div>
@endsection