<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Persona;
use App\Models\Proveedore;
use Illuminate\Http\Request;

class ProveedoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('persona.documento')->get();
        return view('proveedore.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('proveedore.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'tipo_persona' => 'required|string',
            'documento_id' => 'required|integer|exists:documentos,id',
            'numero_documento' => 'required|string|max:50|unique:personas,numero_documento',
        ]);

        try {
            //Crear la persona asociada
            $persona = Persona::create([
                'razon_social' => $request->razon_social,
                'direccion' => $request->direccion,
                'tipo_persona' => $request->tipo_persona,
                'documento_id' => $request->documento_id,
                'numero_documento' => $request->numero_documento,
            ]);

            //Crear el proveedor asociado a la persona
            Proveedore::create(['persona_id' => $persona->id]);

            return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('proveedores.index')->with('error', 'Error al crear el proveedor.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedore $proveedore)
    {
        $proveedore->load('persona.documento');
        $documentos = Documento::all();
        return view('proveedore.edit', compact('proveedore', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedore $proveedore)
    {
        $request->validate([
            'razon_social' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'documento_id' => 'required|exists:documentos,id',
            'numero_documento' => 'required|string|max:50|unique:personas,numero_documento,' . $proveedore->persona->id,
        ]);
    
        try {
            //Cargar la persona relacionada con el proveedor
            $persona = $proveedore->persona;
    
            //Verificar si la relación está cargada correctamente
            if (!$persona) {
                throw new \Exception('La persona asociada no existe.');
            }
    
            //Actualizar los datos de la persona
            $persona->update([
                'razon_social' => $request->razon_social,
                'direccion' => $request->direccion,
                'documento_id' => $request->documento_id,
                'numero_documento' => $request->numero_documento,
            ]);
    
            return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('proveedores.index')->with('error', 'Error al actualizar el proveedor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedore $proveedore)
    {
        try {
            //Obtener la persona asociada
            $persona = $proveedore->persona;
    
            //Eliminar el proveedor
            $proveedore->delete();
    
            //Eliminar la persona asociada
            if ($persona) {
                $persona->delete();
            }
    
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
        } catch (\Exception $e) {
    
            return redirect()->route('proveedores.index')->with('error', 'Error al eliminar el proveedor.');
        }
    }
}
