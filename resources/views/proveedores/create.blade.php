@extends('layouts.app')

@section('title', 'Nuevo Proveedor - Paints')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">Nuevo Proveedor</li>
        </ol>
    </nav>

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-building-add me-2"></i>
            Nuevo Proveedor
        </h2>
        <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>
            Volver al listado
        </a>
    </div>

    {{-- Formulario --}}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Información del Proveedor
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedores.store') }}" method="POST">
                        @csrf

                        {{-- Información de la Empresa --}}
                        <h5 class="mb-3 text-muted">
                            <i class="bi bi-building me-2"></i>
                            Información de la Empresa
                        </h5>

                        <div class="row mb-3">
                            {{-- Nombre --}}
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">
                                    Nombre del Proveedor <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       required
                                       placeholder="Ej: Distribuidora XYZ">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Razón Social --}}
                            <div class="col-md-6">
                                <label for="razon_social" class="form-label">Razón Social</label>
                                <input type="text" 
                                       class="form-control @error('razon_social') is-invalid @enderror" 
                                       id="razon_social" 
                                       name="razon_social" 
                                       value="{{ old('razon_social') }}"
                                       placeholder="Ej: Distribuidora XYZ, S.A.">
                                @error('razon_social')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            {{-- NIT --}}
                            <label for="nit" class="form-label">NIT</label>
                            <input type="text" 
                                   class="form-control @error('nit') is-invalid @enderror" 
                                   id="nit" 
                                   name="nit" 
                                   value="{{ old('nit') }}"
                                   placeholder="Ej: 1234567-8">
                            @error('nit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Información de Contacto --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-telephone me-2"></i>
                            Información de Contacto
                        </h5>

                        <div class="row mb-3">
                            {{-- Teléfono --}}
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono') }}"
                                       placeholder="Ej: 2345-6789">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       placeholder="contacto@proveedor.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            {{-- Contacto Principal --}}
                            <label for="contacto_principal" class="form-label">Nombre del Contacto Principal</label>
                            <input type="text" 
                                   class="form-control @error('contacto_principal') is-invalid @enderror" 
                                   id="contacto_principal" 
                                   name="contacto_principal" 
                                   value="{{ old('contacto_principal') }}"
                                   placeholder="Ej: Juan Pérez">
                            @error('contacto_principal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-geo-alt me-2"></i>
                            Dirección
                        </h5>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección Completa</label>
                            <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                      id="direccion" 
                                      name="direccion" 
                                      rows="2"
                                      placeholder="Ingresa la dirección física del proveedor">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <h5 class="mb-3 text-muted mt-4">
                            <i class="bi bi-toggle-on me-2"></i>
                            Estado
                        </h5>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="activo" 
                                       name="activo"
                                       value="1"
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="activo">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Proveedor Activo
                                </label>
                                <small class="text-muted d-block">
                                    Solo los proveedores activos aparecerán en las órdenes de compra
                                </small>
                            </div>
                        </div>

                        {{-- Botones --}}
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>
                                Guardar Proveedor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar con ayuda --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i>
                    Información
                </div>
                <div class="card-body">
                    <h6 class="card-title">Campos obligatorios</h6>
                    <ul class="small mb-3">
                        <li>Nombre del proveedor</li>
                    </ul>

                    <h6 class="card-title">¿Para qué sirve?</h6>
                    <p class="small mb-3">
                        Los proveedores son las empresas que te suministran los productos 
                        que vendes en tu tienda.
                    </p>

                    <h6 class="card-title">Datos importantes</h6>
                    <p class="small mb-0">
                        El <strong>NIT</strong> y la <strong>razón social</strong> son importantes 
                        para documentos legales y órdenes de compra oficiales.
                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-lightbulb me-2"></i>
                    Consejo
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        Asegúrate de tener toda la información del proveedor correcta 
                        antes de generar órdenes de compra.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection