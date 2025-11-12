{{-- 
    DIRECTIVAS DE BLADE
    Las directivas son comandos especiales de Blade que comienzan con @
    Blade es el motor de plantillas de Laravel que simplifica el uso de PHP en HTML
--}}

{{-- @extends: Hereda la estructura completa del layout principal --}}
{{-- Toma todo el HTML de layouts/app.blade.php (navbar, sidebar, estilos, etc.) --}}
@extends('layouts.app')

{{-- @section: Define un bloque de contenido que se inserta en el layout padre --}}
{{-- Este contenido se inyecta donde el layout tenga @yield('content') --}}
@section('content')
<div class="container mt-4">
    <h2>Nueva Categoría</h2>

    <div class="card mt-3">
        <div class="card-body">
            {{-- {{ route() }}: Genera la URL de una ruta nombrada --}}
            {{-- Ej: route('categorias.store') → http://localhost/categorias --}}
            <form action="{{ route('categorias.store') }}" method="POST">
                {{-- @csrf: Protección contra ataques CSRF (Cross-Site Request Forgery) --}}
                {{-- Genera un token secreto: <input type="hidden" name="_token" value="..."> --}}
                {{-- Laravel verifica que el formulario viene realmente de tu sitio --}}
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    {{-- @error: Verifica si hay errores de validación en el campo --}}
                    {{-- Agrega clase 'is-invalid' si hay error --}}
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre') }}" required>
                    {{-- old('nombre'): Recupera el valor anterior si hubo error de validación --}}
                    
                    {{-- @error: Muestra el mensaje de error si existe --}}
                    @error('nombre')
                        {{-- $message: Variable automática con el mensaje de error --}}
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    {{-- @enderror: Cierra el bloque @error --}}
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                {{-- {{ route() }}: Genera URL para volver al listado --}}
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque @section('content') --}}
@endsection