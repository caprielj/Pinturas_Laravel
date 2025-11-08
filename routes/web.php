<?php

use Illuminate\Support\Facades\Route;
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
| Rutas Web
|--------------------------------------------------------------------------
|
| Aquí es donde registramos todas las rutas web para la aplicación.
| Estas rutas son cargadas por el RouteServiceProvider dentro del grupo
| "web" que contiene el grupo de middleware "web".
|
*/

/**
 * Ruta Principal
 * 
 * Esta es la página de inicio de la aplicación.
 * Redirige al dashboard o página principal.
 */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * Dashboard
 * 
 * Página principal después del login.
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas de Recursos (CRUD Completo)
|--------------------------------------------------------------------------
|
| Route::resource() crea automáticamente todas las rutas necesarias para un CRUD:
|
| Método HTTP  | URI                        | Acción      | Nombre de Ruta
| -------------|----------------------------|-------------|---------------------------
| GET          | /clientes                  | index       | clientes.index
| GET          | /clientes/create           | create      | clientes.create
| POST         | /clientes                  | store       | clientes.store
| GET          | /clientes/{id}             | show        | clientes.show
| GET          | /clientes/{id}/edit        | edit        | clientes.edit
| PUT/PATCH    | /clientes/{id}             | update      | clientes.update
| DELETE       | /clientes/{id}             | destroy     | clientes.destroy
|
*/

/**
 * Rutas para Clientes
 * 
 * Gestión completa de clientes del sistema.
 * Los clientes pueden registrarse para recibir promociones y comprar en línea.
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

/*
|--------------------------------------------------------------------------
| Rutas Adicionales (Opcional - para futuras funcionalidades)
|--------------------------------------------------------------------------
*/

/**
 * Ruta para buscar productos (AJAX)
 * 
 * Ejemplo de ruta adicional que podrías usar para búsquedas en tiempo real.
 */
// Route::get('/productos/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');

/**
 * Ruta para obtener sucursal más cercana por GPS
 * 
 * Para el módulo de localización del proyecto final.
 */
// Route::post('/sucursales/cercana', [SucursalController::class, 'cercana'])->name('sucursales.cercana');

/**
 * Rutas para reportes (para la fase final del proyecto)
 */
// Route::prefix('reportes')->group(function () {
//     Route::get('/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
//     Route::get('/inventario', [ReporteController::class, 'inventario'])->name('reportes.inventario');
// });