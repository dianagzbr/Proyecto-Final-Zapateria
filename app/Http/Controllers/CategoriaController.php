<?php

namespace App\Http\Controllers;

use App\Models\Caracteristica; 
use App\Models\Categoria; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();
        return view('categoria.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:60', // Evitar nombres duplicados
        ]);

        // Crear la característica asociada
        $caracteristica = Caracteristica::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? null,
        ]);

        // Crear la categoría asociada
        Categoria::create([
            'caracteristica_id' => $caracteristica->id,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría y característica creadas exitosamente.');
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
    public function edit(Categoria $categoria)
    {
        return view('categoria.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:60|unique:caracteristicas,nombre,' . $categoria->caracteristica_id,
        ]);

        //Actualizar la característica asociada
        $categoria->caracteristica->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion ?? null,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría y característica actualizadas exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if($categoria->caracteristica->estado == 1) {
            Caracteristica::where('id', $categoria->caracteristica->id)->update(['estado' => 0]);
            $message = 'Categoría eliminada';
        }
        else {
            Caracteristica::where('id', $categoria->caracteristica->id)->update(['estado' => 1]);
            $message = 'Categoría restaurada';
        }
        
        return redirect()->route('categorias.index')->with('success', $message);
    }
}
