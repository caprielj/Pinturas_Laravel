<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Título dinámico de la página --}}
    <title>@yield('title', 'Paints - Sistema de Ventas')</title>
    
    {{-- Bootstrap 5 CSS desde CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    {{-- Estilos personalizados --}}
    <style>
        /**
         * PALETA DE COLORES PERSONALIZADA
         * Basada en los colores de la universidad con mejoras de contraste
         */
        :root {
            /* Colores principales */
            --primary-light: #ADEADA;
            --primary-medium: #BDEADB;
            --primary: #CDEADC;
            --primary-dark: #87D4C8;
            
            /* Color de acento para botones y enlaces */
            --accent: #2C9B89;
            --accent-dark: #1F7A6B;
            
            /* Colores de texto */
            --text-dark: #1A3E3A;
            --text-light: #5A7B77;
            --text-muted: #7A9B97;
            
            /* Colores de fondo */
            --bg-light: #F8F9FA;
            --bg-white: #FFFFFF;
            
            /* Colores de estado (Bootstrap por defecto están bien) */
            --success: #28A745;
            --danger: #DC3545;
            --warning: #FFC107;
            --info: #17A2B8;
        }

        /**
         * ESTILOS GENERALES
         */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        /**
         * NAVBAR
         * Barra de navegación superior con el logo y título
         */
        .navbar {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary-dark) 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-brand:hover {
            color: var(--primary-light) !important;
        }

        /**
         * SIDEBAR
         * Menú lateral de navegación
         */
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: var(--bg-white);
            border-right: 1px solid var(--primary-light);
            padding: 0;
        }

        .sidebar .nav-link {
            color: var(--text-dark);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary-light);
            border-left-color: var(--accent);
            color: var(--accent-dark);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-medium);
            border-left-color: var(--accent);
            color: var(--accent-dark);
            font-weight: 600;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /**
         * CONTENIDO PRINCIPAL
         */
        .main-content {
            padding: 20px;
            min-height: calc(100vh - 56px);
        }

        /**
         * CARDS
         * Tarjetas para mostrar contenido
         */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: var(--primary-light);
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 2px solid var(--primary-dark);
            border-radius: 10px 10px 0 0 !important;
        }

        /**
         * BOTONES
         */
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--accent-dark);
            border-color: var(--accent-dark);
        }

        .btn-outline-primary {
            color: var(--accent);
            border-color: var(--accent);
        }

        .btn-outline-primary:hover {
            background-color: var(--accent);
            border-color: var(--accent);
            color: white;
        }

        /**
         * TABLAS
         */
        .table {
            background-color: white;
        }

        .table thead th {
            background-color: var(--primary-light);
            color: var(--text-dark);
            border-bottom: 2px solid var(--primary-dark);
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: var(--primary-light);
        }

        /**
         * BADGES
         */
        .badge.bg-success {
            background-color: var(--success) !important;
        }

        .badge.bg-danger {
            background-color: var(--danger) !important;
        }

        /**
         * FORMULARIOS
         */
        .form-label {
            color: var(--text-dark);
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(44, 155, 137, 0.25);
        }

        /**
         * PAGINACIÓN
         */
        .pagination .page-link {
            color: var(--accent);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        /**
         * ALERTAS
         */
        .alert {
            border-radius: 8px;
            border: none;
        }

        /**
         * RESPONSIVE
         * Ocultar sidebar en móviles
         */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 56px;
                left: -100%;
                width: 250px;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }

        /**
         * OVERLAY para cerrar sidebar en móvil
         */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>

    {{-- Estilos adicionales específicos de cada página --}}
    @stack('styles')
</head>
<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            {{-- Botón para toggle del sidebar en móvil --}}
            <button class="btn btn-link text-white d-lg-none me-2" id="sidebarToggle" type="button">
                <i class="bi bi-list fs-4"></i>
            </button>

            {{-- Logo y título --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-paint-bucket"></i> Paints
            </a>

            {{-- Info del usuario y logout --}}
            <div class="ms-auto d-flex align-items-center">
                <div class="text-white me-3">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->nombre ?? 'Usuario' }}
                    @if(Auth::user()->rol)
                        <small class="text-white-50">({{ Auth::user()->rol->nombre }})</small>
                    @endif
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            {{-- SIDEBAR --}}
            <nav class="col-lg-2 d-lg-block sidebar" id="sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        {{-- Dashboard --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door"></i>
                                Dashboard
                            </a>
                        </li>

                        {{-- Separador --}}
                        <hr class="my-2">
                        <li class="nav-item px-3">
                            <small class="text-muted">CATÁLOGOS</small>
                        </li>

                        {{-- Clientes --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                                <i class="bi bi-people"></i>
                                Clientes
                            </a>
                        </li>

                        {{-- Proveedores --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}" href="{{ route('proveedores.index') }}">
                                <i class="bi bi-truck"></i>
                                Proveedores
                            </a>
                        </li>

                        {{-- Sucursales --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sucursales.*') ? 'active' : '' }}" href="{{ route('sucursales.index') }}">
                                <i class="bi bi-shop"></i>
                                Sucursales
                            </a>
                        </li>

                        {{-- Separador --}}
                        <hr class="my-2">
                        <li class="nav-item px-3">
                            <small class="text-muted">PRODUCTOS</small>
                        </li>

                        {{-- Productos --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                                <i class="bi bi-box-seam"></i>
                                Productos
                            </a>
                        </li>

                        {{-- Categorías --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">
                                <i class="bi bi-tags"></i>
                                Categorías
                            </a>
                        </li>

                        {{-- Marcas --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marcas.*') ? 'active' : '' }}" href="{{ route('marcas.index') }}">
                                <i class="bi bi-award"></i>
                                Marcas
                            </a>
                        </li>

                        {{-- Separador --}}
                        <hr class="my-2">
                        <li class="nav-item px-3">
                            <small class="text-muted">CONFIGURACIÓN</small>
                        </li>

                        {{-- Medios de Pago --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('medios-pago.*') ? 'active' : '' }}" href="{{ route('medios-pago.index') }}">
                                <i class="bi bi-credit-card"></i>
                                Medios de Pago
                            </a>
                        </li>

                        {{-- Usuarios --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                                <i class="bi bi-person-badge"></i>
                                Usuarios
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- CONTENIDO PRINCIPAL --}}
            <main class="col-lg-10 ms-sm-auto main-content">
                {{-- Alertas de éxito/error --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Contenido de la página --}}
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Overlay para cerrar sidebar en móvil --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Bootstrap 5 JS y dependencias --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script para toggle del sidebar en móvil --}}
    <script>
        /**
         * Toggle del sidebar en móviles
         * 
         * Este script maneja la apertura y cierre del sidebar
         * en dispositivos móviles mediante un botón y un overlay.
         */
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Si existe el botón toggle (solo en móvil)
            if (sidebarToggle) {
                // Al hacer click en el botón, mostrar/ocultar sidebar
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });

                // Al hacer click en el overlay, cerrar sidebar
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>

    {{-- Scripts adicionales específicos de cada página --}}
    @stack('scripts')
</body>
</html>