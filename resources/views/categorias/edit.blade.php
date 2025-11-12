{{-- 
    VISTA DE EDICIÓN DE CATEGORÍA
    Usa directivas de Blade (comandos con @) para plantillas HTML dinámicas
--}}

{{-- @extends: Hereda toda la estructura del layout principal --}}
@extends('layouts.app')

{{-- @section: Define el contenido que se insertará en @yield('content') del layout --}}
@section('content')
<div class="container mt-4">
    <h2>Editar Categoría</h2>

    <div class="card mt-3">
        <div class="card-body">
            {{-- {{ route() }}: Genera URL de ruta nombrada --}}
            {{-- $categoria: Variable pasada desde el controlador (Route Model Binding) --}}
            {{-- Genera: /categorias/{id} --}}
            <form action="{{ route('categorias.update', $categoria) }}" method="POST">
                {{-- @csrf: Token de seguridad contra ataques CSRF --}}
                @csrf
                
                {{-- @method('PUT'): Simula método HTTP PUT --}}
                {{-- HTML solo soporta GET/POST, Laravel simula PUT con campo oculto --}}
                {{-- Genera: <input type="hidden" name="_method" value="PUT"> --}}
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    {{-- @error: Agrega clase 'is-invalid' si hay error de validación --}}
                    <input type="text" name="nombre" id="nombre" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           value="{{ old('nombre', $categoria->nombre) }}" required>
                    {{-- old('nombre', $default): Prioriza valor anterior del form, si no hay usa $default --}}
                    {{-- $categoria->nombre: Accede a la propiedad del modelo --}}
                    
                    {{-- @error: Muestra mensaje de error si existe --}}
                    @error('nombre')
                        {{-- $message: Variable automática con el texto del error --}}
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    {{-- @enderror: Cierra el bloque @error --}}
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                {{-- {{ route() }}: Genera URL para volver al índice --}}
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection