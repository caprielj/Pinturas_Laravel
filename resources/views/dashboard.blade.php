@extends('layouts.app')

@section('title', 'Dashboard - Paints')

@section('content')
<div class="container-fluid">
    {{-- Título de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </h2>
        <small class="text-muted">{{ now()->format('d/m/Y H:i') }}</small>
    </div>

    {{-- Cards con estadísticas --}}
    <div class="row">
        {{-- Total Clientes --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Clientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ \App\Models\Cliente::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-1 text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('clientes.index') }}" class="small text-primary">
                        Ver todos <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Productos --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Productos
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ \App\Models\Producto::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-1 text-success opacity-25"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('productos.index') }}" class="small text-success">
                        Ver todos <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Sucursales --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Sucursales
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ \App\Models\Sucursal::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-shop fs-1 text-info opacity-25"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('sucursales.index') }}" class="small text-info">
                        Ver todas <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Total Proveedores --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Proveedores
                            </div>
                            <div class="h5 mb-0 font-weight-bold">
                                {{ \App\Models\Proveedor::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-truck fs-1 text-warning opacity-25"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('proveedores.index') }}" class="small text-warning">
                        Ver todos <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-lightning-charge me-2"></i>
                    Accesos Rápidos
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-person-plus me-2"></i>
                                Nuevo Cliente
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('productos.create') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-plus-circle me-2"></i>
                                Nuevo Producto
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('proveedores.create') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-building-add me-2"></i>
                                Nuevo Proveedor
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('usuarios.create') }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-person-badge me-2"></i>
                                Nuevo Usuario
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos adicionales para las tarjetas de estadísticas */
    .border-left-primary {
        border-left: 4px solid var(--accent) !important;
    }
    .border-left-success {
        border-left: 4px solid var(--success) !important;
    }
    .border-left-info {
        border-left: 4px solid var(--info) !important;
    }
    .border-left-warning {
        border-left: 4px solid var(--warning) !important;
    }
</style>
@endsection