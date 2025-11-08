<?php

namespace App\Http\Controllers;

use App\Models\MedioPago;
use Illuminate\Http\Request;

/**
 * Controlador MedioPagoController
 * 
 * Maneja todas las operaciones CRUD para la entidad MedioPago.
 * Los medios de pago son las formas de pago aceptadas (Efectivo, Tarjeta, Cheque, etc.)
 */
class MedioPagoController extends Controller
{
    /**
     * Muestra un listado de todos los medios de pago.
     * GET /medios-pago
     */
    public function index()
    {
        // Obtener todos los medios de pago ordenados por nombre
        $mediosPago = MedioPago::orderBy('nombre', 'asc')->paginate(10);
        
        return view('medios-pago.index', compact('mediosPago'));
    }

    /**
     * Muestra el formulario para crear un nuevo medio de pago.
     * GET /medios-pago/create
     */
    public function create()
    {
        return view('medios-pago.create');
    }

    /**
     * Guarda un nuevo medio de pago en la base de datos.
     * POST /medios-pago
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|unique:mediospago,nombre',
            'activo' => 'boolean',
        ]);

        // Si no se envía 'activo', por defecto será true
        if (!isset($validated['activo'])) {
            $validated['activo'] = true;
        }

        // Crear el medio de pago
        $medioPago = MedioPago::create($validated);

        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago creado exitosamente.');
    }

    /**
     * Muestra los detalles de un medio de pago específico.
     * GET /medios-pago/{id}
     */
    public function show(MedioPago $medioPago)
    {
        // Cargar los pagos realizados con este medio
        $medioPago->load('pagos');
        
        return view('medios-pago.show', compact('medioPago'));
    }

    /**
     * Muestra el formulario para editar un medio de pago.
     * GET /medios-pago/{id}/edit
     */
    public function edit(MedioPago $medioPago)
    {
        return view('medios-pago.edit', compact('medioPago'));
    }

    /**
     * Actualiza un medio de pago en la base de datos.
     * PUT/PATCH /medios-pago/{id}
     */
    public function update(Request $request, MedioPago $medioPago)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:50|unique:mediospago,nombre,' . $medioPago->id,
            'activo' => 'boolean',
        ]);

        // Actualizar el medio de pago
        $medioPago->update($validated);

        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago actualizado exitosamente.');
    }

    /**
     * Elimina un medio de pago de la base de datos.
     * DELETE /medios-pago/{id}
     */
    public function destroy(MedioPago $medioPago)
    {
        // Verificar si tiene pagos asociados
        if ($medioPago->pagos()->count() > 0) {
            return redirect()->route('medios-pago.index')
                ->with('error', 'No se puede eliminar el medio de pago porque tiene transacciones asociadas.');
        }

        $medioPago->delete();

        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago eliminado exitosamente.');
    }
}