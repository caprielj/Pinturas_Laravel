{{-- Vista de bienvenida/landing page del sistema --}}
{{-- Archivo Blade: Motor de plantillas de Laravel --}}

{{-- @extends: Hereda la estructura base del layout --}}
{{-- Toma todo el HTML de layouts/app.blade.php (header, navbar, footer, etc.) --}}
@extends('layouts.app')

{{-- @section inline: Define el título de la página --}}
{{-- Se insertará donde el layout tenga @yield('title') --}}
@section('title', 'Bienvenido - Paints')

{{-- @section('content'): Inicia el bloque de contenido principal --}}
{{-- Todo lo que esté aquí se inyecta donde el layout tenga @yield('content') --}}
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            {{-- Card de bienvenida principal --}}
            <div class="card text-center">
                <div class="card-body py-5">
                    {{-- Icono de Bootstrap Icons --}}
                    <i class="bi bi-paint-bucket display-1 text-primary mb-4"></i>
                    
                    <h1 class="display-4 mb-3">Bienvenido a Paints</h1>
                    
                    <p class="lead text-muted mb-4">
                        Sistema de Gestión para Tienda de Pinturas
                    </p>
                    
                    <p class="mb-4">
                        Administra clientes, productos, inventarios y ventas de manera eficiente.
                    </p>
                    
                    {{-- route('dashboard'): Genera la URL de la ruta nombrada 'dashboard' --}}
                    {{-- Laravel convierte esto en la URL real, ej: /dashboard --}}
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-arrow-right-circle me-2"></i>
                        Ir al Dashboard
                    </a>
                </div>
            </div>

            {{-- Cards con las características principales del sistema --}}
            <div class="row mt-4">
                {{-- Card 1: Gestión de Clientes --}}
                <div class="col-md-4 mb-3">
                    <div class="card h-100"> {{-- h-100: Altura 100% para cards iguales --}}
                        <div class="card-body text-center">
                            <i class="bi bi-people display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Gestión de Clientes</h5>
                            <p class="card-text text-muted">
                                Administra la información de tus clientes
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Catálogo de Productos --}}
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-box-seam display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Catálogo de Productos</h5>
                            <p class="card-text text-muted">
                                Control completo de productos y precios
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Reportes y Ventas --}}
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-graph-up display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Reportes y Ventas</h5>
                            <p class="card-text text-muted">
                                Análisis de ventas e inventarios
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endsection: Cierra el bloque de contenido --}}
@endsection