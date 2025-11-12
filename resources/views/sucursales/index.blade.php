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

{{-- @extends: Hereda toda la estructura del layout 'layouts.app' --}}
@extends('layouts.app')

{{-- @section con valor inline: Define el título de la página que se mostrará en el <title> del HTML --}}
@section('title', 'Sucursales - Paints')

{{-- @section: Inicia una sección de contenido llamada 'content' que se insertará en el layout padre --}}
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-shop me-2"></i>
            Sucursales
        </h2>
        {{-- {{ route() }}: Helper de Laravel que genera URLs basadas en nombres de rutas definidas en routes/web.php --}}
        <a href="{{ route('sucursales.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>
            Nueva Sucursal
        </a>
    </div>

    {{-- @if: Directiva condicional que verifica si existe un mensaje de éxito en la sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{-- {{ }}: Imprime el valor de forma segura (escapando HTML para prevenir ataques XSS) --}}
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    {{-- @endif: Cierra el bloque condicional @if --}}
    @endif

    {{-- @if: Verifica si existe un mensaje de error en la sesión --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{-- {{ }}: Imprime el mensaje de error de forma segura --}}
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    {{-- @endif: Cierra el bloque condicional @if --}}
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-2"></i>
            Listado de Sucursales
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>GPS</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse: Bucle que itera sobre $sucursales, si está vacío ejecuta el bloque @empty --}}
                        @forelse($sucursales as $sucursal)
                            <tr>
                                {{-- {{ }}: Imprime el ID de la sucursal actual --}}
                                <td>{{ $sucursal->id }}</td>
                                {{-- {{ }}: Imprime el nombre de la sucursal --}}
                                <td><strong>{{ $sucursal->nombre }}</strong></td>
                                {{-- {{ }}: Usa Str::limit() para acortar la dirección a 40 caracteres, ?? 'N/A' si es null --}}
                                <td>{{ Str::limit($sucursal->direccion ?? 'N/A', 40) }}</td>
                                {{-- {{ }}: Imprime el teléfono o 'N/A' si no existe usando el operador ?? (null coalescing) --}}
                                <td>{{ $sucursal->telefono ?? 'N/A' }}</td>
                                <td>
                                    {{-- @if: Verifica si existen ambas coordenadas GPS (latitud Y longitud) --}}
                                    @if($sucursal->gps_lat && $sucursal->gps_lng)
                                        {{-- {{ }}: Interpola las coordenadas GPS en la URL de Google Maps --}}
                                        <a href="https://www.google.com/maps?q={{ $sucursal->gps_lat }},{{ $sucursal->gps_lng }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-map"></i>
                                        </a>
                                    {{-- @else: Se ejecuta si NO hay coordenadas GPS --}}
                                    @else
                                        <span class="text-muted">Sin GPS</span>
                                    {{-- @endif: Cierra el condicional del GPS --}}
                                    @endif
                                </td>
                                <td>
                                    {{-- @if: Verifica si la sucursal está activa (campo booleano) --}}
                                    @if($sucursal->activa)
                                        <span class="badge bg-success">Activa</span>
                                    {{-- @else: Se ejecuta si la sucursal NO está activa --}}
                                    @else
                                        <span class="badge bg-danger">Inactiva</span>
                                    {{-- @endif: Cierra el condicional del estado activa --}}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        {{-- {{ route() }}: Genera la URL para ver los detalles de la sucursal --}}
                                        <a href="{{ route('sucursales.show', $sucursal->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        {{-- {{ route() }}: Genera la URL para editar la sucursal --}}
                                        <a href="{{ route('sucursales.edit', $sucursal->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        {{-- {{ }}: Interpola el ID en la función JavaScript eliminar() --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="eliminar({{ $sucursal->id }})"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    {{-- {{ }}: Interpola el ID en el atributo id del formulario --}}
                                    <form id="delete-form-{{ $sucursal->id }}" 
                                          {{-- {{ route() }}: Genera la URL de eliminación con el método DELETE --}}
                                          action="{{ route('sucursales.destroy', $sucursal->id) }}" 
                                          method="POST" 
                                          class="d-none">
                                        {{-- @csrf: Directiva que genera un token de seguridad para proteger contra ataques CSRF --}}
                                        @csrf
                                        {{-- @method: Directiva que simula un método HTTP DELETE (los formularios HTML solo soportan GET/POST) --}}
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        {{-- @empty: Se ejecuta si $sucursales está vacío (no hay registros) --}}
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                    <p class="text-muted mb-0">No hay sucursales registradas</p>
                                </td>
                            </tr>
                        {{-- @endforelse: Cierra el bucle @forelse --}}
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- @if: Verifica si la colección tiene múltiples páginas para mostrar la paginación --}}
            @if($sucursales->hasPages())
                <div class="mt-3">
                    {{-- {{ }}: Imprime los enlaces de paginación de Bootstrap --}}
                    {{ $sucursales->links() }}
                </div>
            {{-- @endif: Cierra el condicional de paginación --}}
            @endif
        </div>
    </div>
</div>
{{-- @endsection: Cierra la sección 'content' que fue abierta al inicio --}}
@endsection

{{-- @push: Agrega contenido a una pila llamada 'scripts' definida en el layout padre --}}
@push('scripts')
<script>
    function eliminar(id) {
        if (confirm('¿Estás seguro de eliminar esta sucursal?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
{{-- @endpush: Cierra el bloque @push de scripts --}}
@endpush