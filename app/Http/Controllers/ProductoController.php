<?php

// Declaración del namespace (espacio de nombres) donde se ubica este controlador
// Todos los controladores HTTP de Laravel se encuentran en App\Http\Controllers
namespace App\Http\Controllers;

// Importación del modelo Producto que representa la tabla 'productos' en la base de datos
// Este modelo gestiona la información de los productos (pinturas) del sistema
use App\Models\Producto;

// Importación del modelo Categoria - necesario para las relaciones y selects de categorías
// Se usa para llenar el dropdown/select de categorías en los formularios
use App\Models\Categoria;

// Importación del modelo Marca - necesario para las relaciones y selects de marcas
// Se usa para llenar el dropdown/select de marcas en los formularios
use App\Models\Marca;

// Importación de la clase Request de Laravel (librería Illuminate\Http)
// Esta clase maneja todas las peticiones HTTP entrantes (GET, POST, PUT, DELETE)
// Permite acceder a datos de formularios, validar, gestionar archivos y sesiones
use Illuminate\Http\Request;

// Importación de Storage para manejar archivos (imágenes)
// Permite guardar, eliminar y gestionar archivos en el sistema
use Illuminate\Support\Facades\Storage;

/**
 * Controlador ProductoController
 * 
 * Este controlador implementa el patrón CRUD completo (Create, Read, Update, Delete)
 * para gestionar los productos (pinturas) del sistema.
 * Maneja relaciones con Categorias y Marcas (claves foráneas).
 * Hereda de la clase base Controller que proporciona funcionalidades comunes de Laravel.
 */
class ProductoController extends Controller
{
    /**
     * Método index()
     * 
     * Este método maneja las peticiones GET a la ruta principal de productos
     * Obtiene y muestra el listado paginado de todos los productos con sus relaciones
     * Implementa EAGER LOADING para optimizar consultas a la base de datos
     * 
     * @return \Illuminate\View\View Retorna la vista con el listado paginado de productos
     */
    public function index()
    {
        // Consulta a la base de datos usando Eloquent ORM con optimización
        // Producto::with(['categoria', 'marca']) - EAGER LOADING (carga anticipada)
        //     Carga las relaciones categoria y marca en UNA sola consulta optimizada
        //     Evita el problema N+1 (hacer una consulta por cada producto para obtener relaciones)
        //     Sin with(): 1 consulta productos + 10 consultas categorias + 10 consultas marcas = 21 consultas
        //     Con with(): 1 consulta productos + 1 consulta categorias + 1 consulta marcas = 3 consultas
        //     Esto mejora significativamente el rendimiento
        // ->orderBy('descripcion', 'asc') - Ordena alfabéticamente por descripción (ascendente A-Z)
        // ->paginate(10) - Divide los resultados en páginas de 10 registros cada una
        //     Genera automáticamente los links de navegación (página 1, 2, 3, etc.)
        //     Retorna un objeto LengthAwarePaginator en lugar de una Collection
        //     Ejecuta: SELECT * FROM productos ORDER BY descripcion ASC LIMIT 10 OFFSET 0
        $productos = Producto::with(['categoria', 'marca'])
            ->orderBy('descripcion', 'asc')
            ->paginate(10);
        
        // Retorna la vista del listado con la variable $productos paginada
        // resources/views/productos/index.blade.php
        // compact('productos') crea: ['productos' => $productos]
        // En la vista se puede usar: $productos->links() para mostrar la paginación
        return view('productos.index', compact('productos'));
    }

    /**
     * Método create()
     * 
     * Este método muestra el formulario de creación de productos
     * Pre-carga las colecciones de categorías y marcas para los dropdowns/selects
     * 
     * @return \Illuminate\View\View Retorna la vista con el formulario y los datos necesarios
     */
    public function create()
    {
        // Obtiene todas las categorías ordenadas alfabéticamente
        // orderBy('nombre', 'asc') - Ordena por nombre ascendente (A-Z)
        // get() - Ejecuta la consulta y retorna una Collection
        // Se usará para llenar el select/dropdown de categorías en el formulario
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        
        // Obtiene solo las marcas ACTIVAS ordenadas alfabéticamente
        // where('activa', true) - Filtra solo marcas con activa = 1 (true)
        //     Esto asegura que solo se muestren marcas habilitadas en el sistema
        //     Evita que se creen productos con marcas desactivadas
        // orderBy('nombre', 'asc') - Ordena por nombre (A-Z)
        // get() - Retorna una Collection de marcas activas
        // Ejecuta: SELECT * FROM marcas WHERE activa = 1 ORDER BY nombre ASC
        $marcas = Marca::where('activa', true)->orderBy('nombre', 'asc')->get();
        
        // Retorna la vista del formulario de creación pasando dos variables:
        // - $categorias: Collection de todas las categorías para el select
        // - $marcas: Collection de marcas activas para el select
        // compact('categorias', 'marcas') crea: ['categorias' => $categorias, 'marcas' => $marcas]
        return view('productos.create', compact('categorias', 'marcas'));
    }

    /**
     * Método store()
     * 
     * Este método recibe los datos del formulario de creación, los valida
     * y guarda un nuevo producto en la base de datos
     * Incluye validación de claves foráneas y campos opcionales
     * 
     * @param Request $request Objeto con todos los datos del formulario
     * @return \Illuminate\Http\RedirectResponse Redirecciona al listado después de guardar
     */
    public function store(Request $request)
    {
        // validate() - Valida los datos recibidos del formulario
        // Si la validación falla, Laravel automáticamente:
        // 1. Redirige de vuelta al formulario
        // 2. Muestra los errores de validación
        // 3. Mantiene los datos ingresados (old input)
        $request->validate([
            // Validación de la clave foránea categoria_id:
            // - required: obligatorio, debe seleccionar una categoría
            // - exists:categorias,id: Valida que el ID exista en la tabla 'categorias'
            //     Previene ataques donde se envíe un ID inexistente o manipulado
            //     Ejecuta: SELECT COUNT(*) FROM categorias WHERE id = ?
            'categoria_id' => 'required|exists:categorias,id',
            
            // Validación de la clave foránea marca_id:
            // - required: obligatorio, debe seleccionar una marca
            // - exists:marcas,id: Valida que el ID exista en la tabla 'marcas'
            //     Asegura integridad referencial a nivel de validación
            'marca_id' => 'required|exists:marcas,id',
            
            // Validación del código SKU (Stock Keeping Unit - código único del producto):
            // - required: obligatorio
            // - string: debe ser texto
            // - max:50: máximo 50 caracteres
            // - unique:productos,codigo_sku: Debe ser único en la tabla productos
            //     Evita duplicados de códigos SKU en el inventario
            'codigo_sku' => 'required|string|max:50|unique:productos,codigo_sku',
            
            // Validación de descripción del producto:
            // - required: obligatorio
            // - string: debe ser texto
            // - max:255: máximo 255 caracteres
            'descripcion' => 'required|string|max:255',
            
            // Validación del tamaño (ej: "1L", "4L", "20L"):
            // - nullable: campo opcional, puede estar vacío
            // - string: si se envía, debe ser texto
            // - max:40: máximo 40 caracteres
            'tamano' => 'nullable|string|max:40',
            
            // Validación de duración en años (vida útil del producto):
            // - nullable: campo opcional
            // - integer: si se envía, debe ser número entero (no decimales)
            // - min:0: mínimo 0 años (no permite negativos)
            'duracion_anios' => 'nullable|integer|min:0',
            
            // Validación de extensión en metros cuadrados (rendimiento):
            // - nullable: campo opcional
            // - numeric: puede ser decimal (ej: 12.5 m²)
            // - min:0: mínimo 0 (no permite negativos)
            'extension_m2' => 'nullable|numeric|min:0',
            
            // Validación del color del producto:
            // - nullable: campo opcional
            // - string: si se envía, debe ser texto
            // - max:60: máximo 60 caracteres
            'color' => 'nullable|string|max:60',

            // Validación de la imagen del producto:
            // - nullable: la imagen es opcional
            // - image: debe ser un archivo de imagen (jpeg, png, gif, etc.)
            // - mimes:jpeg,png,jpg,gif: formatos permitidos
            // - max:2048: tamaño máximo 2MB (2048 KB)
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejo de la imagen del producto
        // Inicializa la variable $imagenPath como null
        $imagenPath = null;

        // hasFile('imagen') - Verifica si se subió un archivo de imagen
        // file('imagen')->isValid() - Verifica que el archivo se subió correctamente
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // store('productos', 'public') - Guarda la imagen en storage/app/public/productos
            // Laravel genera automáticamente un nombre único para evitar duplicados
            // Retorna la ruta relativa: "productos/nombre_unico.jpg"
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }

        // create() - Método de Eloquent que inserta un nuevo registro
        // Se pasan explícitamente todos los campos (más seguro que usar $request->all())
        // Array asociativo con los datos a insertar:
        Producto::create([
            // Campos de claves foráneas (relaciones):
            'categoria_id' => $request->categoria_id,  // ID de la categoría seleccionada
            'marca_id' => $request->marca_id,          // ID de la marca seleccionada
            
            // Campos obligatorios:
            'codigo_sku' => $request->codigo_sku,      // Código único del producto
            'descripcion' => $request->descripcion,     // Nombre/descripción del producto
            
            // Campos opcionales (pueden ser null):
            'tamano' => $request->tamano,               // Tamaño/presentación
            'duracion_anios' => $request->duracion_anios, // Vida útil en años
            'extension_m2' => $request->extension_m2,   // Rendimiento en m²
            'color' => $request->color,                 // Color del producto
            'imagen' => $imagenPath,                    // Ruta de la imagen (null si no se subió)

            // Campo checkbox 'activo':
            // has('activo') - Verifica si el checkbox fue marcado
            // ? 1 : 0 - Operador ternario: marcado = 1, no marcado = 0
            // Los productos nuevos pueden crearse como activos o inactivos según el checkbox
            'activo' => $request->has('activo') ? 1 : 0,
        ]);
        // Ejecuta: INSERT INTO productos (...campos...) VALUES (...valores...)

        // Redirección al listado con mensaje de éxito
        // route('productos.index') - Redirige al método index()
        // with('success', '...') - Flash message que se muestra una sola vez
        // Patrón PRG (Post-Redirect-Get) para evitar reenvío al recargar
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Método show()
     * 
     * Este método muestra los detalles completos de un producto específico
     * Incluye EAGER LOADING de sus relaciones (categoría y marca)
     * 
     * @param int $id ID del producto a mostrar (viene desde la URL)
     * @return \Illuminate\View\View Retorna la vista con los detalles del producto
     */
    public function show($id)
    {
        // with(['categoria', 'marca']) - EAGER LOADING de relaciones
        //     Carga el producto junto con su categoría y marca en una consulta optimizada
        //     Evita consultas adicionales (problema N+1)
        // findOrFail($id) - Busca el producto por ID o lanza error 404 si no existe
        // Ejecuta: SELECT * FROM productos WHERE id = ? LIMIT 1
        //          SELECT * FROM categorias WHERE id IN (...)
        //          SELECT * FROM marcas WHERE id IN (...)
        $producto = Producto::with(['categoria', 'marca'])->findOrFail($id);
        
        // Retorna la vista de detalle con el producto y sus relaciones cargadas
        // En la vista se puede acceder a: $producto->categoria->nombre, $producto->marca->nombre
        return view('productos.show', compact('producto'));
    }

    /**
     * Método edit()
     * 
     * Este método muestra el formulario de edición pre-llenado
     * con los datos actuales del producto
     * También carga las colecciones de categorías y marcas para los selects
     * 
     * @param int $id ID del producto a editar (viene desde la URL)
     * @return \Illuminate\View\View Retorna la vista con el formulario de edición
     */
    public function edit($id)
    {
        // Busca el producto a editar
        // findOrFail($id) - Si no existe, lanza error 404
        $producto = Producto::findOrFail($id);
        
        // Carga todas las categorías ordenadas alfabéticamente
        // Se usará para el select de categorías en el formulario
        // La categoría actual del producto estará pre-seleccionada en la vista
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        
        // Carga solo las marcas ACTIVAS ordenadas alfabéticamente
        // Solo se permiten seleccionar marcas activas al editar
        // La marca actual del producto estará pre-seleccionada en la vista
        $marcas = Marca::where('activa', true)->orderBy('nombre', 'asc')->get();
        
        // Retorna la vista de edición con tres variables:
        // - $producto: Objeto con los datos actuales del producto
        // - $categorias: Collection para el select de categorías
        // - $marcas: Collection para el select de marcas (solo activas)
        // compact() crea: ['producto' => $producto, 'categorias' => $categorias, 'marcas' => $marcas]
        return view('productos.edit', compact('producto', 'categorias', 'marcas'));
    }

    /**
     * Método update()
     * 
     * Este método recibe los datos modificados del formulario de edición,
     * los valida y actualiza el registro del producto en la base de datos
     * 
     * @param Request $request Objeto con los datos del formulario de edición
     * @param int $id ID del producto a actualizar (viene desde la URL)
     * @return \Illuminate\Http\RedirectResponse Redirecciona al listado después de actualizar
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos recibidos del formulario de edición
        $request->validate([
            // Validación de categoría (misma que en store):
            'categoria_id' => 'required|exists:categorias,id',
            
            // Validación de marca (misma que en store):
            'marca_id' => 'required|exists:marcas,id',
            
            // Validación del código SKU con regla especial en unique:
            // unique:productos,codigo_sku,' . $id
            //     Concatenación con el operador (.) de PHP
            //     Verifica que el código SKU sea único EXCEPTO para el producto actual
            //     Permite mantener el mismo código SKU al editar
            //     Ejemplo: "unique:productos,codigo_sku,5" ignora el registro con id=5
            'codigo_sku' => 'required|string|max:50|unique:productos,codigo_sku,' . $id,
            
            // Validaciones de los demás campos (mismas que en store):
            'descripcion' => 'required|string|max:255',
            'tamano' => 'nullable|string|max:40',
            'duracion_anios' => 'nullable|integer|min:0',
            'extension_m2' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:60',

            // Validación de la imagen (misma que en store):
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Busca el producto a actualizar antes de modificarlo
        // findOrFail($id) - Si no existe, lanza error 404
        $producto = Producto::findOrFail($id);

        // Manejo de la imagen al editar producto
        // Conserva la imagen actual si no se sube una nueva
        $imagenPath = $producto->imagen;

        // Verifica si se subió una nueva imagen
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            // Si había una imagen anterior, la elimina del storage
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                // delete() - Elimina el archivo de imagen anterior del storage
                Storage::disk('public')->delete($producto->imagen);
            }

            // Guarda la nueva imagen y actualiza la ruta
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }

        // update() - Método de Eloquent que actualiza el registro
        // Se pasan explícitamente todos los campos a actualizar
        // Laravel compara los valores nuevos con los actuales (dirty checking)
        // Solo actualiza los campos que realmente cambiaron
        $producto->update([
            // Actualiza todos los campos del producto:
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id,
            'codigo_sku' => $request->codigo_sku,
            'descripcion' => $request->descripcion,
            'tamano' => $request->tamano,
            'duracion_anios' => $request->duracion_anios,
            'extension_m2' => $request->extension_m2,
            'color' => $request->color,
            'imagen' => $imagenPath,  // Actualiza con la nueva imagen o mantiene la anterior
            // Manejo del checkbox 'activo' (mismo que en store):
            'activo' => $request->has('activo') ? 1 : 0,
        ]);
        // Ejecuta: UPDATE productos SET ...campos... WHERE id = ?

        // Redirección al listado con mensaje de éxito en sesión flash
        // Patrón PRG para evitar duplicación al refrescar la página
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Método destroy()
     * 
     * Este método elimina un producto de la base de datos
     * 
     * NOTA IMPORTANTE: Este método NO tiene validación de integridad referencial
     * En un sistema real de producción, debería validar:
     * - Si el producto tiene presentaciones asociadas
     * - Si el producto está en inventarios
     * - Si el producto está en facturas/ventas
     * Esta validación se implementará en fases posteriores del proyecto
     * 
     * @param int $id ID del producto a eliminar (viene desde la URL)
     * @return \Illuminate\Http\RedirectResponse Redirecciona con mensaje de éxito
     */
    public function destroy($id)
    {
        // Busca el producto a eliminar
        // findOrFail($id) - Si no existe el ID, lanza error 404
        $producto = Producto::findOrFail($id);

        // Elimina la imagen del storage si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // delete() - Método de Eloquent que elimina el registro de la base de datos
        // Ejecuta: DELETE FROM productos WHERE id = ?
        // ADVERTENCIA: Se elimina sin validar relaciones
        // En fases futuras debe agregarse validación de:
        // - if ($producto->presentaciones()->count() > 0) { return error }
        // - if ($producto->inventarios()->count() > 0) { return error }
        // - if ($producto->detallesFactura()->count() > 0) { return error }
        $producto->delete();

        // Redirección al listado con mensaje de confirmación exitosa
        // Flash message de éxito que se muestra una sola vez
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}