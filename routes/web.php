<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MedioPagoController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
|
| Estas rutas son accesibles sin autenticación.
| Los clientes pueden ver el catálogo de productos.
|
*/

/**
 * Ruta Principal - Catálogo Público
 *
 * Muestra la página de inicio con el catálogo de productos
 * Accesible para todos los visitantes sin necesidad de login
 */
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
|
| Rutas para login y logout del sistema administrativo
|
*/

/**
 * Mostrar formulario de login
 */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

/**
 * Procesar login
 */
Route::post('/login', [AuthController::class, 'login']);

/**
 * Cerrar sesión
 */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Autenticación)
|--------------------------------------------------------------------------
|
| Todas estas rutas requieren que el usuario esté autenticado.
| Si no está autenticado, será redirigido al login.
|
*/

Route::middleware(['auth'])->group(function () {

    /**
     * Dashboard
     *
     * Página principal del panel administrativo después del login.
     */
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /**
     * Rutas para Clientes
     *
     * Gestión completa de clientes del sistema.
     * Los clientes pueden registrarse para recibir promociones
     */
    Route::resource('clientes', ClienteController::class);

    /**
     * Rutas para Proveedores
     *
     * Gestión de proveedores que suministran productos.
     */
    Route::resource('proveedores', ProveedorController::class);

    /**
     * Rutas para Sucursales
     *
     * Gestión de las diferentes sucursales de la cadena "Paints".
     * Cada sucursal tiene su propio inventario.
     */
    Route::resource('sucursales', SucursalController::class);

    /**
     * Rutas para Productos
     *
     * Gestión del catálogo de productos (pinturas, solventes, accesorios, barnices).
     */
    Route::resource('productos', ProductoController::class);

    /**
     * Rutas para Categorías
     *
     * Gestión de categorías de productos (Pinturas Interior, Exterior, etc.).
     */
    Route::resource('categorias', CategoriaController::class);

    /**
     * Rutas para Marcas
     *
     * Gestión de marcas de productos (Sherwin Williams, Comex, etc.).
     */
    Route::resource('marcas', MarcaController::class);

    /**
     * Rutas para Medios de Pago
     *
     * Gestión de medios de pago aceptados (Efectivo, Tarjeta, Cheque, etc.).
     *
     * Nota: Laravel convierte automáticamente "medios-pago" en la URL
     * pero el controlador se llama MedioPagoController.
     */
    Route::resource('medios-pago', MedioPagoController::class);

    /**
     * Rutas para Usuarios
     *
     * Gestión de usuarios del sistema (empleados) con diferentes roles.
     * Roles: Digitador, Cajero, Gerente.
     */
    Route::resource('usuarios', UsuarioController::class);
});
