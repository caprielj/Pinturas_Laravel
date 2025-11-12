<?php

// Declaración del namespace (espacio de nombres) donde se encuentra este controlador
namespace App\Http\Controllers;

// Importación del modelo Categoria que representa la tabla 'categorias' en la base de datos
// Este modelo contiene la lógica de negocio y las relaciones de la tabla categorias
use App\Models\Categoria;

// Importación de la clase Request de Laravel (librería Illuminate)
// Esta clase maneja todas las peticiones HTTP (GET, POST, PUT, DELETE)
// Permite acceder a datos del formulario, validar datos, y gestionar la entrada del usuario
use Illuminate\Http\Request;

/**
 * Controlador CategoriaController
 * 
 * Este controlador implementa el patrón CRUD (Create, Read, Update, Delete)
 * para gestionar las categorías de productos en el sistema.
 * Hereda de Controller que proporciona funcionalidades base de Laravel.
 */
class CategoriaController extends Controller
{
    /**
     * Método index()
     * 
     * Este método maneja la petición GET a la ruta principal de categorías
     * Muestra el listado de todas las categorías existentes
     * 
     * @return \Illuminate\View\View Retorna la vista con el listado de categorías
     */
    public function index()
    {
        // Consulta a la base de datos usando Eloquent ORM
        // withCount('productos') - Cuenta cuántos productos tiene cada categoría (relación definida en el modelo)
        // orderBy('nombre') - Ordena alfabéticamente por el campo nombre
        // get() - Ejecuta la consulta y obtiene todos los registros
        // El resultado se almacena en la variable $categorias como una colección de Laravel
        $categorias = Categoria::withCount('productos')->orderBy('nombre')->get();
        
        // view() - Helper de Laravel que carga una vista desde resources/views/
        // 'categorias.index' - Busca el archivo resources/views/categorias/index.blade.php
        // compact('categorias') - Crea un array asociativo ['categorias' => $categorias]
        //                          para pasar la variable $categorias a la vista
        // return - Devuelve la vista renderizada al navegador
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Método create()
     * 
     * Este método maneja la petición GET para mostrar el formulario
     * que permite crear una nueva categoría
     * 
     * @return \Illuminate\View\View Retorna la vista con el formulario de creación
     */
    public function create()
    {
        // Retorna la vista del formulario de creación
        // Laravel buscará el archivo: resources/views/categorias/create.blade.php
        return view('categorias.create');
    }

    /**
     * Método store()
     * 
     * Este método maneja la petición POST que recibe los datos del formulario
     * de creación y guarda una nueva categoría en la base de datos
     * 
     * @param Request $request Objeto que contiene todos los datos enviados por el formulario
     * @return \Illuminate\Http\RedirectResponse Redirecciona después de guardar
     */
    public function store(Request $request)
    {
        // validate() - Método de Laravel que valida los datos recibidos
        // Si la validación falla, automáticamente redirige de vuelta con los errores
        // Array de reglas de validación:
        $request->validate([
            // 'nombre' debe cumplir:
            // - required: Campo obligatorio, no puede estar vacío
            // - string: Debe ser una cadena de texto
            // - max:60: Máximo 60 caracteres
            // - unique:categorias,nombre: Verifica que no exista otro nombre igual en la tabla categorias
            'nombre' => 'required|string|max:60|unique:categorias,nombre',
            
            // 'descripcion' debe cumplir:
            // - nullable: Campo opcional, puede estar vacío
            // - string: Si se envía, debe ser una cadena de texto
            // - max:255: Máximo 255 caracteres
            'descripcion' => 'nullable|string|max:255',
        ]);

        // create() - Método de Eloquent que crea un nuevo registro en la base de datos
        // $request->all() - Obtiene todos los datos validados del formulario como un array
        // Laravel automáticamente asigna los valores a los campos correspondientes del modelo
        // Esta operación ejecuta un INSERT en la tabla categorias
        Categoria::create($request->all());

        // redirect()->route() - Redirige a una ruta nombrada
        // 'categorias.index' - Redirige al método index() de este controlador
        // with('success', 'mensaje') - Flash message (mensaje temporal de sesión)
        //                              Se muestra una sola vez en la siguiente página
        // Este patrón se conoce como PRG (Post-Redirect-Get) para evitar reenvíos duplicados
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Método show()
     * 
     * Este método muestra los detalles de una categoría específica
     * junto con todos los productos asociados a ella
     * 
     *  Categoria $categoria Inyección de dependencia (Route Model Binding)
     *                             Laravel automáticamente busca la categoría por ID
     * @return \Illuminate\View\View Retorna la vista con los detalles de la categoría
     */
    public function show(Categoria $categoria)
    {
        // Accede a la relación 'productos' definida en el modelo Categoria
        // $categoria->productos ejecuta una consulta JOIN para obtener
        // todos los productos relacionados con esta categoría
        // Esto usa la relación Eloquent hasMany o belongsToMany según la configuración
        $productos = $categoria->productos;
        
        // Retorna la vista de detalle pasando dos variables:
        // - $categoria: El objeto de la categoría actual
        // - $productos: Colección de productos relacionados
        return view('categorias.show', compact('categoria', 'productos'));
    }

    /**
     * Método edit()
     * 
     * Este método muestra el formulario de edición pre-llenado
     * con los datos de una categoría existente
     * 
     * @param Categoria $categoria Route Model Binding - Laravel busca la categoría automáticamente
     * @return \Illuminate\View\View Retorna la vista con el formulario de edición
     */
    public function edit(Categoria $categoria)
    {
        // Retorna la vista del formulario de edición
        // La variable $categoria contiene todos los datos actuales de la categoría
        // que se usarán para pre-llenar el formulario en la vista
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Método update()
     * 
     * Este método recibe los datos modificados del formulario de edición
     * y actualiza el registro en la base de datos
     * 
     * @param Request $request Objeto con los datos del formulario de edición
     * @param Categoria $categoria Instancia del modelo a actualizar (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse Redirecciona después de actualizar
     */
    public function update(Request $request, Categoria $categoria)
    {
        // Validación de los datos recibidos
        $request->validate([
            // Validación del nombre con regla especial para unique
            // 'nombre' => validaciones:
            // - required: obligatorio
            // - string: texto
            // - max:60: máximo 60 caracteres
            // - unique:categorias,nombre,' . $categoria->id:
            //   Verifica que el nombre sea único EXCEPTO para el registro actual
            //   El . $categoria->id concatena el ID para excluirlo de la validación
            //   Esto permite mantener el mismo nombre al editar
            'nombre' => 'required|string|max:60|unique:categorias,nombre,' . $categoria->id,
            
            // Validación de descripción (mismas reglas que en store)
            'descripcion' => 'nullable|string|max:255',
        ]);

        // update() - Método de Eloquent que actualiza el registro en la base de datos
        // $request->all() - Obtiene todos los campos validados del formulario
        // Laravel actualiza solo los campos que cambiaron (dirty checking)
        $categoria->update($request->all());

        // Redirección al listado con mensaje de éxito
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * Método destroy()
     * 
     * Este método elimina una categoría de la base de datos
     * Incluye validación para evitar eliminar categorías con productos asociados
     * 
     * @param Categoria $categoria Instancia del modelo a eliminar (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse Redirecciona con mensaje de éxito o error
     */
    public function destroy(Categoria $categoria)
    {
        // Validación de integridad referencial
        // if - Estructura condicional que verifica si hay productos asociados
        // $categoria->productos() - Accede a la relación productos (retorna Query Builder)
        // count() - Cuenta cuántos productos están relacionados
        // > 0 - Si hay al menos un producto relacionado
        if ($categoria->productos()->count() > 0) {
            // Si hay productos asociados, NO se permite eliminar
            // Redirecciona al índice con un mensaje de error en la sesión flash
            // 'error' - Clave del mensaje para mostrar con estilo de error
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar. Tiene productos asociados');
        }

        // delete() - Método de Eloquent que elimina el registro de la base de datos
        // Ejecuta: DELETE FROM categorias WHERE id = $categoria->id
        // Solo se ejecuta si pasó la validación anterior (no tiene productos)
        $categoria->delete();

        // Redirección al listado con mensaje de confirmación
        // Flash message de éxito que se mostrará una sola vez
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }
}