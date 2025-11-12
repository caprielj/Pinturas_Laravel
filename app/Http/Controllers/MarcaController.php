<?php

// Declaración del namespace (espacio de nombres) donde se ubica este controlador
// Todos los controladores HTTP de Laravel se encuentran en App\Http\Controllers
namespace App\Http\Controllers;

// Importación del modelo Marca que representa la tabla 'marcas' en la base de datos
// Este modelo contiene la lógica de negocio, relaciones y atributos de las marcas
use App\Models\Marca;

// Importación de la clase Request de Laravel (librería Illuminate\Http)
// Esta clase maneja todas las peticiones HTTP entrantes (GET, POST, PUT, DELETE, PATCH)
// Permite acceder a datos de formularios, validar información, gestionar archivos, headers, etc.
use Illuminate\Http\Request;

/**
 * Controlador MarcaController
 * 
 * Este controlador implementa el patrón CRUD completo (Create, Read, Update, Delete)
 * para gestionar las marcas de productos en el sistema.
 * Hereda de la clase base Controller que proporciona funcionalidades comunes de Laravel.
 */
class MarcaController extends Controller
{
    /**
     * Método index()
     * 
     * Este método maneja las peticiones GET a la ruta principal de marcas
     * Obtiene y muestra el listado completo de todas las marcas registradas
     * 
     * @return \Illuminate\View\View Retorna la vista con el listado de marcas
     */
    public function index()
    {
        // Consulta a la base de datos usando Eloquent ORM (Object-Relational Mapping)
        // Marca::withCount('productos') - Agrega un campo 'productos_count' que contiene
        //                                  el número de productos asociados a cada marca
        //                                  Usa la relación 'productos' definida en el modelo Marca
        // ->orderBy('nombre') - Ordena los resultados alfabéticamente por el campo 'nombre' (A-Z)
        // ->get() - Ejecuta la consulta SQL y retorna una colección de Laravel con todos los registros
        // La variable $marcas almacena una colección de objetos Marca con su contador de productos
        $marcas = Marca::withCount('productos')->orderBy('nombre')->get();
        
        // view() - Helper function de Laravel que carga una vista desde resources/views/
        // 'marcas.index' - Busca el archivo resources/views/marcas/index.blade.php
        // compact('marcas') - Función de PHP que crea un array ['marcas' => $marcas]
        //                     Pasa la variable $marcas a la vista para que pueda usarse allí
        // return - Envía la vista renderizada como respuesta HTTP al navegador
        return view('marcas.index', compact('marcas'));
    }

    /**
     * Método create()
     * 
     * Este método maneja la petición GET para mostrar el formulario HTML
     * que permite al usuario crear una nueva marca
     * 
     * @return \Illuminate\View\View Retorna la vista con el formulario de creación
     */
    public function create()
    {
        // Retorna la vista del formulario de creación de marcas
        // Laravel buscará el archivo: resources/views/marcas/create.blade.php
        // Esta vista contendrá los campos del formulario (nombre, activa, etc.)
        return view('marcas.create');
    }

    /**
     * Método store()
     * 
     * Este método maneja la petición POST que recibe los datos del formulario de creación
     * Valida los datos y guarda una nueva marca en la base de datos
     * Incluye lógica especial para el campo 'activa' (checkbox)
     * 
     * @param Request $request Objeto que contiene todos los datos enviados desde el formulario
     * @return \Illuminate\Http\RedirectResponse Redirecciona después de guardar
     */
    public function store(Request $request)
    {
        // validate() - Método de Laravel que valida los datos recibidos contra reglas definidas
        // Si la validación falla, Laravel automáticamente redirige al formulario con los errores
        // Array de reglas de validación:
        $request->validate([
            // 'nombre' debe cumplir las siguientes reglas:
            // - required: Campo obligatorio, no puede estar vacío o null
            // - string: Debe ser una cadena de texto (no número, no booleano)
            // - max:80: Longitud máxima de 80 caracteres
            // - unique:marcas,nombre: Verifica que no exista otro registro con el mismo nombre
            //                         en la tabla 'marcas', columna 'nombre'
            'nombre' => 'required|string|max:80|unique:marcas,nombre',
            
            // 'activa' debe cumplir:
            // - boolean: Debe ser un valor booleano (true/false, 1/0)
            // Nota: No tiene 'required', por lo que es opcional
            'activa' => 'boolean',
        ]);

        // $request->all() - Obtiene todos los datos del formulario como un array asociativo
        // Se almacena en la variable $data para poder manipularla antes de guardar
        $data = $request->all();
        
        // isset() - Función de PHP que verifica si una variable existe y no es null
        // ! - Operador de negación, invierte el resultado (si NO existe)
        // Esta validación es necesaria porque los checkboxes en HTML solo envían datos
        // cuando están marcados. Si el checkbox 'activa' no está marcado, no se envía nada
        if (!isset($data['activa'])) {
            // Si el campo 'activa' no fue enviado (checkbox desmarcado)
            // Se asigna true por defecto (las marcas nuevas se crean como activas)
            $data['activa'] = true;
        }

        // create() - Método de Eloquent que inserta un nuevo registro en la base de datos
        // $data - Array con los valores a insertar (nombre, activa)
        // Ejecuta: INSERT INTO marcas (nombre, activa, created_at, updated_at) VALUES (...)
        // Laravel automáticamente agrega las fechas de creación y actualización (timestamps)
        Marca::create($data);

        // redirect()->route() - Crea una redirección a una ruta nombrada
        // 'marcas.index' - Nombre de la ruta que apunta al método index()
        // ->with() - Agrega un mensaje flash a la sesión (se muestra solo una vez)
        // 'success' - Clave del mensaje, usado en la vista para mostrar alertas con estilo
        // Patrón PRG (Post-Redirect-Get): evita que se reenvíe el formulario al recargar la página
        return redirect()->route('marcas.index')
            ->with('success', 'Marca creada exitosamente');
    }

    /**
     * Método show()
     * 
     * Este método muestra los detalles completos de una marca específica
     * junto con todos los productos que pertenecen a esa marca
     * 
     * @param Marca $marca Route Model Binding - Laravel automáticamente busca la marca por ID
     *                     desde la URL y la inyecta como parámetro
     * @return \Illuminate\View\View Retorna la vista con los detalles de la marca
     */
    public function show(Marca $marca)
    {
        // Accede a la relación 'productos' definida en el modelo Marca
        // $marca->productos - Propiedad mágica de Eloquent que ejecuta la consulta de relación
        //                     Obtiene todos los productos asociados a esta marca
        // Puede ser una relación hasMany (una marca tiene muchos productos)
        // Retorna una colección de objetos Producto
        $productos = $marca->productos;
        
        // Retorna la vista de detalle pasando dos variables:
        // - $marca: Objeto completo de la marca con todos sus atributos (id, nombre, activa, etc.)
        // - $productos: Colección de productos relacionados con esta marca
        // compact() crea: ['marca' => $marca, 'productos' => $productos]
        return view('marcas.show', compact('marca', 'productos'));
    }

    /**
     * Método edit()
     * 
     * Este método muestra el formulario de edición pre-llenado
     * con los datos actuales de una marca existente
     * 
     * @param Marca $marca Route Model Binding - Laravel busca la marca automáticamente por ID
     * @return \Illuminate\View\View Retorna la vista con el formulario de edición
     */
    public function edit(Marca $marca)
    {
        // Retorna la vista del formulario de edición
        // resources/views/marcas/edit.blade.php
        // La variable $marca contiene todos los datos actuales que se usarán
        // para pre-llenar los campos del formulario (value="{{ $marca->nombre }}")
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Método update()
     * 
     * Este método recibe los datos modificados del formulario de edición
     * Valida los datos y actualiza el registro de la marca en la base de datos
     * 
     * @param Request $request Objeto con los datos del formulario de edición
     * @param Marca $marca Instancia del modelo a actualizar (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse Redirecciona después de actualizar
     */
    public function update(Request $request, Marca $marca)
    {
        // Validación de los datos recibidos del formulario de edición
        $request->validate([
            // Validación del nombre con regla especial en unique
            // 'nombre' => validaciones:
            // - required: obligatorio
            // - string: tipo texto
            // - max:80: máximo 80 caracteres
            // - unique:marcas,nombre,' . $marca->id:
            //   Concatenación en PHP usando el operador (.)
            //   Verifica que el nombre sea único en la tabla 'marcas', columna 'nombre'
            //   EXCEPTO para el registro con id = $marca->id (el registro actual)
            //   Esto permite que la marca mantenga su mismo nombre al editarla
            //   Ejemplo: "unique:marcas,nombre,5" ignora el registro con id=5
            'nombre' => 'required|string|max:80|unique:marcas,nombre,' . $marca->id,
            
            // Validación del campo activa (misma regla que en store)
            'activa' => 'boolean',
        ]);

        // Obtener todos los datos del formulario
        $data = $request->all();

        // Manejo especial del checkbox 'activa'
        // Los checkboxes solo envían datos cuando están marcados
        // Si no está marcado, necesitamos asignar false manualmente
        // has() - Verifica si el campo existe en la petición
        // ? true : false - Si existe, es true (marcado), si no existe, es false (desmarcado)
        $data['activa'] = $request->has('activa') ? true : false;

        // update() - Método de Eloquent que actualiza el registro en la base de datos
        // $data - Array con todos los campos incluyendo el campo 'activa' correctamente asignado
        // Laravel compara los valores nuevos con los actuales (dirty checking)
        // Solo actualiza los campos que realmente cambiaron para optimizar la consulta
        // Ejecuta: UPDATE marcas SET nombre = ?, activa = ?, updated_at = ? WHERE id = ?
        $marca->update($data);

        // Redirección al listado con mensaje de éxito en sesión flash
        // Patrón PRG (Post-Redirect-Get) para evitar duplicación al refrescar la página
        return redirect()->route('marcas.index')
            ->with('success', 'Marca actualizada exitosamente');
    }

    /**
     * Método destroy()
     * 
     * Este método elimina una marca de la base de datos
     * Incluye validación de integridad referencial para proteger datos relacionados
     * No permite eliminar marcas que tienen productos asociados
     * 
     * @param Marca $marca Instancia del modelo a eliminar (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse Redirecciona con mensaje de éxito o error
     */
    public function destroy(Marca $marca)
    {
        // Validación de integridad referencial antes de eliminar
        // if - Estructura condicional que verifica la existencia de registros relacionados
        // $marca->productos() - Accede a la relación productos (retorna Query Builder, no la colección)
        //                       Los paréntesis () son importantes: permiten encadenar métodos de consulta
        // ->count() - Cuenta cuántos productos están relacionados con esta marca
        //             Ejecuta: SELECT COUNT(*) FROM productos WHERE marca_id = ?
        // > 0 - Verifica si el conteo es mayor que cero (si hay al menos un producto)
        if ($marca->productos()->count() > 0) {
            // Si hay productos asociados, NO se permite la eliminación
            // Esto previene errores de integridad referencial en la base de datos
            // redirect()->route() - Redirige al índice
            // with('error', ...) - Flash message con clave 'error' para mostrar alerta roja
            return redirect()->route('marcas.index')
                ->with('error', 'No se puede eliminar. Tiene productos asociados');
        }

        // delete() - Método de Eloquent que elimina el registro de la base de datos
        // Ejecuta: DELETE FROM marcas WHERE id = ?
        // Solo se ejecuta si la marca no tiene productos asociados (pasó la validación)
        // Laravel también puede disparar eventos de modelo (deleting, deleted)
        $marca->delete();

        // Redirección al listado con mensaje de confirmación exitosa
        // Flash message de éxito que se mostrará una sola vez en la siguiente vista
        return redirect()->route('marcas.index')
            ->with('success', 'Marca eliminada exitosamente');
    }
}