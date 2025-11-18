<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Paints - Tienda de Pinturas')</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-light: #ADEADA;
            --primary-medium: #BDEADB;
            --primary: #CDEADC;
            --primary-dark: #87D4C8;
            --accent: #2C9B89;
            --accent-dark: #1F7A6B;
            --text-dark: #1A3E3A;
            --text-light: #5A7B77;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #F8F9FA;
            color: var(--text-dark);
        }

        /* Navbar público */
        .navbar-public {
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

        /* Botones */
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
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

        /* Cards de producto */
        .product-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .product-img {
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .product-img-placeholder {
            height: 200px;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .badge-categoria {
            background-color: var(--accent);
        }

        /* Footer */
        .footer {
            background-color: var(--text-dark);
            color: white;
            padding: 40px 0;
            margin-top: 80px;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(44, 155, 137, 0.25);
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- NAVBAR PÚBLICO --}}
    <nav class="navbar navbar-public navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-paint-bucket"></i> Paints
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Administración
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-paint-bucket"></i> Paints</h5>
                    <p class="text-white-50">
                        Tu tienda de confianza para pinturas de calidad.
                        Encuentra las mejores marcas y productos para tus proyectos.
                    </p>
                </div>
                <div class="col-md-3">
                    <h6>Enlaces</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                        <li><a href="{{ route('login') }}" class="text-white-50 text-decoration-none">Administración</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Contacto</h6>
                    <p class="text-white-50">
                        <i class="bi bi-envelope"></i> info@paints.com<br>
                        <i class="bi bi-telephone"></i> (502) 1234-5678
                    </p>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center text-white-50">
                <small>&copy; {{ date('Y') }} Paints. Todos los derechos reservados.</small>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
