<?php

// Declaración del namespace (espacio de nombres) donde se ubica este controlador
// Todos los controladores HTTP de Laravel se encuentran en App\Http\Controllers
namespace App\Http\Controllers;

// Importación del modelo MedioPago que representa la tabla 'mediospago' en la base de datos
// Este modelo gestiona los diferentes métodos de pago (efectivo, tarjeta, transferencia, etc.)
use App\Models\MedioPago;

// Importación de la clase Request de Laravel (librería Illuminate\Http)
// Esta clase maneja todas las peticiones HTTP entrantes (GET, POST, PUT, DELETE)
// Permite acceder a datos de formularios, validar, gestionar archivos y sesiones
use Illuminate\Http\Request;

/**
 * Controlador MedioPagoController
 * 
 * Este controlador implementa el patrón CRUD completo (Create, Read, Update, Delete)
 * para gestionar los medios de pago disponibles en el sistema de facturación.
 * Hereda de la clase base Controller que proporciona funcionalidades comunes de Laravel.
 * 
 * Nota: Este controlador usa búsqueda manual por ID en lugar de Route Model Binding
 *       lo cual es una alternativa válida cuando se necesita más control sobre el manejo de errores.
 */
class MedioPagoController extends Controller
{
    /**
     * Método index()
     * 
     * Este método maneja las peticiones GET a la ruta principal de medios de pago
     * Obtiene y muestra el listado completo de todos los medios de pago registrados
     * 
     * @return \Illuminate\View\View Retorna la vista con el listado de medios de pago
     */
    public function index()
    {
        // Consulta a la base de datos usando Eloquent ORM
        // MedioPago::orderBy('nombre') - Ordena los resultados alfabéticamente por el campo 'nombre' (A-Z)
        // ->get() - Ejecuta la consulta SQL y retorna una colección de Laravel con todos los registros
        //           Ejecuta: SELECT * FROM mediospago ORDER BY nombre ASC
        // La variable $mediosPago almacena una colección de objetos MedioPago
        $mediosPago = MedioPago::orderBy('nombre')->get();
        
        // view() - Helper function de Laravel que carga una vista desde resources/views/
        // 'medios-pago.index' - Busca el archivo resources/views/medios-pago/index.blade.php
        //                       Nota: Laravel convierte automáticamente el punto (.) en barra (/)
        // compact('mediosPago') - Función de PHP que crea un array ['mediosPago' => $mediosPago]
        //                         Pasa la variable $mediosPago a la vista para renderizar la tabla
        // return - Envía la vista renderizada como respuesta HTTP al navegador
        return view('medios-pago.index', compact('mediosPago'));
    }

    /**
     * Método create()
     * 
     * Este método maneja la petición GET para mostrar el formulario HTML
     * que permite al usuario crear un nuevo medio de pago
     * 
     * @return \Illuminate\View\View Retorna la vista con el formulario de creación
     */
    public function create()
    {
        // Retorna la vista del formulario de creación de medios de pago
        // Laravel buscará el archivo: resources/views/medios-pago/create.blade.php
        // Esta vista contendrá los campos del formulario (nombre, activo)
        return view('medios-pago.create');
    }

    /**
     * Método store()
     * 
     * Este método maneja la petición POST que recibe los datos del formulario de creación
     * Valida los datos y guarda un nuevo medio de pago en la base de datos
     * Incluye manejo especial del campo 'activo' (checkbox) con conversión a 1/0
     * 
     * @param Request $request Objeto que contiene todos los datos enviados desde el formulario
     * @return \Illuminate\Http\RedirectResponse Redirecciona después de guardar
     */
    public function store(Request $request)
    {
        // validate() - Método de Laravel que valida los datos recibidos contra reglas definidas
        // Si la validación falla, Laravel automáticamente redirige al formulario con los errores
        // y los datos previamente ingresados (old input)
        // Array de reglas de validación:
        $request->validate([
            // 'nombre' debe cumplir las siguientes reglas:
            // - required: Campo obligatorio, no puede estar vacío o null
            // - string: Debe ser una cadena de texto
            // - max:50: Longitud máxima de 50 caracteres
            // - unique:mediospago,nombre: Verifica que no exista otro registro con el mismo nombre
            //                             en la tabla 'mediospago', columna 'nombre'
            //                             Evita duplicados (ej: dos "Efectivo")
            'nombre' => 'required|string|max:50|unique:mediospago,nombre',
            
            // 'activo' debe cumplir:
            // - nullable: Campo opcional, puede no estar presente en la petición
            // - boolean: Si se envía, debe ser un valor booleano (true/false, 1/0, "1"/"0")
            'activo' => 'nullable|boolean',
        ]);

        // only() - Método que extrae solo los campos especificados del request
        // ['nombre'] - Array con los nombres de campos a extraer
        // Esto es más seguro que all() porque solo toma los campos permitidos (mass assignment protection)
        // $data ahora contiene solo: ['nombre' => 'valor del formulario']
        $data = $request->only(['nombre']);
        
        // Manejo especial del campo checkbox 'activo'
        // $request->has('activo') - Verifica si el campo 'activo' existe en la petición
        //                           Los checkboxes en HTML solo envían datos cuando están marcados
        // ? 1 : 0 - Operador ternario de PHP (condición ? si_verdadero : si_falso)
        // Si el checkbox está marcado -> $data['activo'] = 1
        // Si el checkbox NO está marcado -> $data['activo'] = 0
        // Se usa 1/0 en lugar de true/false para compatibilidad con bases de datos
        $data['activo'] = $request->has('activo') ? 1 : 0;

        // create() - Método de Eloquent que inserta un nuevo registro en la base de datos
        // $data - Array con los valores a insertar (nombre, activo)
        // Ejecuta: INSERT INTO mediospago (nombre, activo, created_at, updated_at) VALUES (?, ?, NOW(), NOW())
        // Laravel automáticamente agrega las fechas de creación y actualización (timestamps)
        MedioPago::create($data);

        // redirect()->route() - Crea una redirección a una ruta nombrada
        // 'medios-pago.index' - Nombre de la ruta que apunta al método index()
        // ->with() - Agrega un mensaje flash a la sesión (se muestra solo una vez)
        // 'success' - Clave del mensaje, usado en la vista para mostrar alertas con estilo verde/éxito
        // Patrón PRG (Post-Redirect-Get): evita que se reenvíe el formulario al recargar la página
        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago creado exitosamente');
    }

    /**
     * Método show()
     * 
     * Este método muestra los detalles completos de un medio de pago específico
     * Usa búsqueda manual por ID en lugar de Route Model Binding
     * 
     * @param int $id ID del medio de pago a mostrar (viene desde la URL)
     * @return \Illuminate\View\View Retorna la vista con los detalles del medio de pago
     */
    public function show($id)
    {
        // findOrFail() - Método de Eloquent que busca un registro por su clave primaria (ID)
        // $id - Parámetro recibido desde la URL (ej: /medios-pago/5)
        // Si encuentra el registro: retorna el objeto MedioPago
        // Si NO encuentra el registro: lanza una excepción ModelNotFoundException
        //                               Laravel automáticamente muestra una página 404
        // Ejecuta: SELECT * FROM mediospago WHERE id = ? LIMIT 1
        $medioPago = MedioPago::findOrFail($id);
        
        // Retorna la vista de detalle pasando la variable $medioPago
        // resources/views/medios-pago/show.blade.php
        // compact('medioPago') crea: ['medioPago' => $medioPago]
        return view('medios-pago.show', compact('medioPago'));
    }

    /**
     * Método edit()
     * 
     * Este método muestra el formulario de edición pre-llenado
     * con los datos actuales de un medio de pago existente
     * 
     * @param int $id ID del medio de pago a editar (viene desde la URL)
     * @return \Illuminate\View\View Retorna la vista con el formulario de edición
     */
    public function edit($id)
    {
        // findOrFail() - Busca el medio de pago por ID o lanza error 404 si no existe
        // Esto previene intentar editar registros inexistentes
        $medioPago = MedioPago::findOrFail($id);
        
        // Retorna la vista del formulario de edición
        // resources/views/medios-pago/edit.blade.php
        // La variable $medioPago contiene todos los datos actuales que se usarán
        // para pre-llenar los campos del formulario (value="{{ $medioPago->nombre }}")
        return view('medios-pago.edit', compact('medioPago'));
    }

    /**
     * Método update()
     * 
     * Este método recibe los datos modificados del formulario de edición
     * Valida los datos y actualiza el registro del medio de pago en la base de datos
     * 
     * @param Request $request Objeto con los datos del formulario de edición
     * @param int $id ID del medio de pago a actualizar (viene desde la URL)
     * @return \Illuminate\Http\RedirectResponse Redirecciona después de actualizar
     */
    public function update(Request $request, $id)
    {
        // Primero busca el registro a actualizar
        // findOrFail() - Si no existe el ID, lanza error 404 antes de intentar actualizar
        $medioPago = MedioPago::findOrFail($id);
        
        // Validación de los datos recibidos del formulario de edición
        $request->validate([
            // Validación del nombre con regla especial en unique
            // 'nombre' => validaciones:
            // - required: obligatorio
            // - string: tipo texto
            // - max:50: máximo 50 caracteres
            // - unique:mediospago,nombre,' . $medioPago->id:
            //   Concatenación en PHP usando el operador (.)
            //   Verifica que el nombre sea único en la tabla 'mediospago', columna 'nombre'
            //   EXCEPTO para el registro con id = $medioPago->id (el registro actual)
            //   Esto permite que el medio de pago mantenga su mismo nombre al editarlo
            //   Ejemplo: "unique:mediospago,nombre,5" ignora el registro con id=5
            'nombre' => 'required|string|max:50|unique:mediospago,nombre,' . $medioPago->id,
            
            // Validación del campo activo (misma regla que en store)
            'activo' => 'nullable|boolean',
        ]);

        // only() - Extrae solo el campo 'nombre' del request (seguridad, evita mass assignment)
        $data = $request->only(['nombre']);
        
        // Manejo del checkbox 'activo'
        // has() - Verifica si el checkbox fue enviado (marcado)
        // Operador ternario: marcado = 1, no marcado = 0
        $data['activo'] = $request->has('activo') ? 1 : 0;

        // update() - Método de Eloquent que actualiza el registro en la base de datos
        // $data - Array con los nuevos valores (nombre, activo)
        // Laravel compara los valores nuevos con los actuales (dirty checking)
        // Solo actualiza los campos que realmente cambiaron para optimizar la consulta
        // Ejecuta: UPDATE mediospago SET nombre = ?, activo = ?, updated_at = NOW() WHERE id = ?
        $medioPago->update($data);

        // Redirección al listado con mensaje de éxito en sesión flash
        // Patrón PRG (Post-Redirect-Get) para evitar duplicación al refrescar la página
        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago actualizado exitosamente');
    }

    /**
     * Método destroy()
     * 
     * Este método elimina un medio de pago de la base de datos
     * Incluye validación comentada para futura implementación (Fase 2)
     * cuando exista el modelo Pago y sus relaciones
     * 
     * @param int $id ID del medio de pago a eliminar (viene desde la URL)
     * @return \Illuminate\Http\RedirectResponse Redirecciona con mensaje de éxito o error
     */
    public function destroy($id)
    {
        // Primero busca el registro a eliminar
        // findOrFail() - Si no existe el ID, lanza error 404 antes de intentar eliminar
        $medioPago = MedioPago::findOrFail($id);
        
        // VALIDACIÓN DE INTEGRIDAD REFERENCIAL - COMENTADA (FASE 2)
        // Este código está comentado porque el modelo Pago aún no existe en el sistema
        // En la Fase 2 del proyecto, cuando se implemente el módulo de facturación y pagos,
        // se activará esta validación para proteger datos relacionados
        // 
        // Comentado temporalmente - se activará en Fase 2 cuando exista el modelo Pago
        // Propósito: Prevenir la eliminación de medios de pago que tienen transacciones asociadas
        // if ($medioPago->pagos()->count() > 0) {
        //     // Si hay pagos/transacciones asociadas, NO se permite la eliminación
        //     // Esto previene errores de integridad referencial en la base de datos
        //     // y protege el historial de transacciones
        //     return redirect()->route('medios-pago.index')
        //         ->with('error', 'No se puede eliminar. Tiene transacciones asociadas');
        // }

        // delete() - Método de Eloquent que elimina el registro de la base de datos
        // Ejecuta: DELETE FROM mediospago WHERE id = ?
        // Por ahora se ejecuta sin restricciones (hasta implementar Fase 2)
        // Laravel también puede disparar eventos de modelo (deleting, deleted) si están definidos
        $medioPago->delete();

        // Redirección al listado con mensaje de confirmación exitosa
        // Flash message de éxito que se mostrará una sola vez en la siguiente vista
        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago eliminado exitosamente');
    }
}