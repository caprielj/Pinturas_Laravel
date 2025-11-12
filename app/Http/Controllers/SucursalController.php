<?php

// Declaración del namespace donde se ubica este controlador
namespace App\Http\Controllers;

// Importación del modelo Sucursal que representa la tabla 'sucursales' en la base de datos
// Este modelo gestiona la información de las diferentes sucursales/tiendas del negocio
use App\Models\Sucursal;

// Importación de la clase Request de Laravel para manejar peticiones HTTP
// Permite acceder a datos de formularios, validar y gestionar la entrada del usuario
use Illuminate\Http\Request;

/**
 * Controlador SucursalController
 * 
 * Implementa el patrón CRUD para gestionar las sucursales del sistema
 * Las sucursales son las diferentes ubicaciones físicas donde opera el negocio
 * Incluye validación de coordenadas GPS para geolocalización
 */
class SucursalController extends Controller
{
    /**
     * Método index()
     * 
     * Muestra el listado paginado de todas las sucursales
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // orderBy('nombre', 'asc') - Ordena alfabéticamente por nombre
        // paginate(10) - Divide los resultados en páginas de 10 registros
        // Genera automáticamente los links de navegación entre páginas
        $sucursales = Sucursal::orderBy('nombre', 'asc')->paginate(10);
        
        // Retorna la vista resources/views/sucursales/index.blade.php
        // compact('sucursales') pasa la variable a la vista
        return view('sucursales.index', compact('sucursales'));
    }

    /**
     * Método create()
     * 
     * Muestra el formulario para crear una nueva sucursal
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        return view('sucursales.create');
    }

    /**
     * Método store()
     * 
     * Recibe los datos del formulario, los valida y crea una nueva sucursal
     * Incluye validación especial para coordenadas GPS
     * 
     * @param Request $request Datos del formulario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate() - Valida los datos recibidos del formulario
        // Si falla, Laravel redirige automáticamente con los errores
        $request->validate([
            // nombre: obligatorio (required), texto (string), máximo 120 caracteres
            // unique:sucursales,nombre - No puede haber dos sucursales con el mismo nombre
            'nombre' => 'required|string|max:120|unique:sucursales,nombre',
            
            // direccion: opcional (nullable), texto, máximo 255 caracteres
            'direccion' => 'nullable|string|max:255',
            
            // gps_lat: Latitud GPS (coordenada geográfica)
            // nullable - opcional
            // numeric - puede ser decimal (ej: 4.7110)
            // between:-90,90 - Rango válido de latitud (-90° a +90°)
            'gps_lat' => 'nullable|numeric|between:-90,90',
            
            // gps_lng: Longitud GPS (coordenada geográfica)
            // nullable - opcional
            // numeric - puede ser decimal (ej: -74.0721)
            // between:-180,180 - Rango válido de longitud (-180° a +180°)
            'gps_lng' => 'nullable|numeric|between:-180,180',
            
            // telefono: opcional, texto, máximo 30 caracteres
            'telefono' => 'nullable|string|max:30',
        ]);

        // create() - Inserta un nuevo registro en la tabla sucursales
        // Se pasan explícitamente todos los campos a insertar
        Sucursal::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'gps_lat' => $request->gps_lat,        // Latitud para mapas
            'gps_lng' => $request->gps_lng,        // Longitud para mapas
            'telefono' => $request->telefono,
            // has('activa') - Verifica si el checkbox fue marcado
            // Operador ternario: si está marcado = 1, si no = 0
            'activa' => $request->has('activa') ? 1 : 0,
        ]);

        // redirect()->route() - Redirige a la ruta nombrada 'sucursales.index'
        // with('success', '...') - Flash message que se muestra una sola vez
        // Patrón PRG (Post-Redirect-Get) para evitar reenvío al recargar
        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }

    /**
     * Método show()
     * 
     * Muestra los detalles de una sucursal específica
     * Puede incluir mapa con las coordenadas GPS en la vista
     * 
     * @param int $id ID de la sucursal
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // findOrFail($id) - Busca la sucursal por ID
        // Si no existe, lanza error 404 automáticamente
        $sucursal = Sucursal::findOrFail($id);
        
        // Retorna la vista de detalle con los datos de la sucursal
        // Puede mostrar un mapa usando gps_lat y gps_lng
        return view('sucursales.show', compact('sucursal'));
    }

    /**
     * Método edit()
     * 
     * Muestra el formulario de edición pre-llenado con los datos actuales
     * 
     * @param int $id ID de la sucursal
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Busca la sucursal a editar
        $sucursal = Sucursal::findOrFail($id);
        
        // Retorna la vista del formulario de edición
        // Los campos se pre-llenan con los datos actuales
        return view('sucursales.edit', compact('sucursal'));
    }

    /**
     * Método update()
     * 
     * Recibe los datos modificados, los valida y actualiza la sucursal
     * 
     * @param Request $request Datos del formulario
     * @param int $id ID de la sucursal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validación con reglas similares a store()
        $request->validate([
            // unique:sucursales,nombre,' . $id
            // Concatenación: verifica que el nombre sea único EXCEPTO para esta sucursal
            // Permite mantener el mismo nombre al editar
            'nombre' => 'required|string|max:120|unique:sucursales,nombre,' . $id,
            
            'direccion' => 'nullable|string|max:255',
            
            // Validación de coordenadas GPS (mismo que en store)
            'gps_lat' => 'nullable|numeric|between:-90,90',
            'gps_lng' => 'nullable|numeric|between:-180,180',
            
            'telefono' => 'nullable|string|max:30',
        ]);

        // Busca la sucursal a actualizar
        $sucursal = Sucursal::findOrFail($id);
        
        // update() - Actualiza el registro en la base de datos
        // Laravel solo actualiza los campos que cambiaron (dirty checking)
        $sucursal->update([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'gps_lat' => $request->gps_lat,
            'gps_lng' => $request->gps_lng,
            'telefono' => $request->telefono,
            // Manejo del checkbox (mismo que en store)
            'activa' => $request->has('activa') ? 1 : 0,
        ]);

        // Redirige al listado con mensaje de éxito
        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada exitosamente.');
    }

    /**
     * Método destroy()
     * 
     * Elimina una sucursal de la base de datos
     * 
     * NOTA: No tiene validación de integridad referencial
     * En producción debería validar si tiene:
     * - Usuarios asignados
     * - Inventario de productos
     * - Ventas/facturas registradas
     * 
     * @param int $id ID de la sucursal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Busca la sucursal a eliminar
        $sucursal = Sucursal::findOrFail($id);
        
        // delete() - Elimina el registro de la base de datos
        // Ejecuta: DELETE FROM sucursales WHERE id = ?
        $sucursal->delete();

        // Redirige al listado con mensaje de confirmación
        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada exitosamente.');
    }
}