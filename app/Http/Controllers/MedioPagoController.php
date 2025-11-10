<?php

namespace App\Http\Controllers;

use App\Models\MedioPago;
use Illuminate\Http\Request;

class MedioPagoController extends Controller
{
    public function index()
    {
        $mediosPago = MedioPago::orderBy('nombre')->get();
        return view('medios-pago.index', compact('mediosPago'));
    }

    public function create()
    {
        return view('medios-pago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:mediospago,nombre',
            'activo' => 'nullable|boolean',
        ]);

        $data = $request->only(['nombre']);
        $data['activo'] = $request->has('activo') ? 1 : 0;

        MedioPago::create($data);

        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago creado exitosamente');
    }

    public function show($id)
    {
        $medioPago = MedioPago::findOrFail($id);
        return view('medios-pago.show', compact('medioPago'));
    }

    public function edit($id)
    {
        $medioPago = MedioPago::findOrFail($id);
        return view('medios-pago.edit', compact('medioPago'));
    }

    public function update(Request $request, $id)
    {
        $medioPago = MedioPago::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:50|unique:mediospago,nombre,' . $medioPago->id,
            'activo' => 'nullable|boolean',
        ]);

        $data = $request->only(['nombre']);
        $data['activo'] = $request->has('activo') ? 1 : 0;

        $medioPago->update($data);

        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago actualizado exitosamente');
    }

    public function destroy($id)
    {
        $medioPago = MedioPago::findOrFail($id);
        
        // Comentado temporalmente - se activará en Fase 2 cuando exista el modelo Pago
        // if ($medioPago->pagos()->count() > 0) {
        //     return redirect()->route('medios-pago.index')
        //         ->with('error', 'No se puede eliminar. Tiene transacciones asociadas');
        // }

        $medioPago->delete();

        return redirect()->route('medios-pago.index')
            ->with('success', 'Medio de pago eliminado exitosamente');
    }
}