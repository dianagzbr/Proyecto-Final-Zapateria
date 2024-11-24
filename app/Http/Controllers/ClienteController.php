<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('persona.documento')->get();
        return view('cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('cliente.create', compact('documentos'));
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

            //Crear el cliente asociado a la persona
            Cliente::create(['persona_id' => $persona->id]);

            return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')->with('error', 'Error al crear el cliente.');
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
    public function edit(Cliente $cliente)
    {
        $cliente->load('persona.documento');
        $documentos = Documento::all();
        return view('cliente.edit', compact('cliente', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {

        $request->validate([
            'razon_social' => 'required|string|max:80',
            'direccion' => 'required|string|max:80',
            'documento_id' => 'required|exists:documentos,id',
            'numero_documento' => 'required|string|max:50|unique:personas,numero_documento,' . $cliente->persona->id,
        ]);
    
        try {
            //Cargar la persona relacionada con el cliente
            $persona = $cliente->persona;
    
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
    
            return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')->with('error', 'Error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        try {
            //Obtener la persona asociada
            $persona = $cliente->persona;
    
            //Eliminar el cliente
            $cliente->delete();
    
            //Eliminar la persona asociada
            if ($persona) {
                $persona->delete();
            }
    
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
        } catch (\Exception $e) {
    
            return redirect()->route('clientes.index')->with('error', 'Error al eliminar el cliente.');
        }
    }
}
