@extends('layouts.app')

@section('title', 'Medios de Pago - Paints')

@section('content')
<div class="container-fluid">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-credit-card me-2"></i>
            Gestión de Medios de Pago
        </h2>
        {{-- Botón para crear nuevo medio de pago --}}
        <a href="{{ route('medios-pago.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Medio de Pago
        </a>
    </div>

    {{-- Card con la tabla --}}
    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Medios de Pago
        </div>
        <div class="card-body">
            {{-- Tabla responsive --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mediosPago as $medioPago)
                            <tr>
                                <td>{{ $medioPago->id }}</td>
                                <td>
                                    <i class="bi bi-{{ 
                                        $medioPago->nombre == 'Efectivo' ? 'cash-stack' : 
                                        ($medioPago->nombre == 'Cheque' ? 'receipt' : 
                                        ($medioPago->nombre == 'Transferencia Bancaria' ? 'bank' : 'credit-card'))
                                    }} me-2"></i>
                                    <strong>{{ $medioPago->nombre }}</strong>
                                </td>
                                <td>
                                    @if($medioPago->activo)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{-- Botones de acción --}}
                                    <div class="btn-group" role="group">
                                        {{-- Ver detalles --}}
                                        <a href="{{ route('medios-pago.show', $medioPago) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        {{-- Editar --}}
                                        <a href="{{ route('medios-pago.edit', $medioPago) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        {{-- Eliminar --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="confirmarEliminacion({{ $medioPago->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- Formulario oculto para eliminar --}}
                                    <form id="form-eliminar-{{ $medioPago->id }}" 
                                          action="{{ route('medios-pago.destroy', $medioPago) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- Mensaje cuando no hay medios de pago --}}
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay medios de pago registrados</p>
                                    <a href="{{ route('medios-pago.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>
                                        Crear primer medio de pago
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($mediosPago->hasPages())
                <div class="mt-3">
                    {{ $mediosPago->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Información adicional --}}
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Medios de pago:</strong> Los medios de pago son las formas en que los clientes pueden pagar 
                por sus compras. Solo los medios de pago activos aparecerán disponibles al momento de facturar. 
                Una factura puede pagarse usando múltiples medios de pago.
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    /**
     * Confirmar eliminación de medio de pago
     * 
     * Muestra un cuadro de confirmación antes de eliminar un medio de pago.
     * Verifica que no tenga pagos asociados.
     * 
     * @param {number} id - ID del medio de pago a eliminar
     */
    function confirmarEliminacion(id) {
        if (confirm('¿Estás seguro de eliminar este medio de pago?\n\nSe verificará que no tenga transacciones asociadas.\n\nEsta acción no se puede deshacer.')) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    }
</script>
@endpush