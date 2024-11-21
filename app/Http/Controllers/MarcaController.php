<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica; 
use App\Models\Marca; 
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        return view('marca.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:60', 
        ]);

        // Crear la característica asociada
        $caracteristica = Caracteristica::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? null,
        ]);

        // Crear la marca asociada
        Marca::create([
            'caracteristica_id' => $caracteristica->id,
        ]);

        return redirect()->route('marcas.index')->with('success', 'Marca creada exitosamente.');
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
    public function edit(Marca $marca)
    {
        return view('marca.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {
        $request->validate([
            'nombre' => 'required|string|max:60|unique:caracteristicas,nombre,' . $marca->caracteristica_id,
        ]);

        //Actualizar la característica asociada
        $marca->caracteristica->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? null,
        ]);

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $marca = Marca::find($id);
        if($marca->caracteristica->estado == 1) {
            Caracteristica::where('id', $marca->caracteristica->id)->update(['estado' => 0]);
            $message = 'Marca eliminada';
        }
        else {
            Caracteristica::where('id', $marca->caracteristica->id)->update(['estado' => 1]);
            $message = 'Marca restaurada';
        }
        
        return redirect()->route('marcas.index')->with('success', $message);
    }
}
