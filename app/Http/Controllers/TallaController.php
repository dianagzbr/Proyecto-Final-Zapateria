<?php


namespace App\Http\Controllers;

use App\Models\Talla;
use Illuminate\Http\Request;

class TallaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tallas = Talla::all();
        return view('talla.index', compact('tallas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('talla.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:tallas,nombre',
        ]);

        Talla::create($request->all());

        return redirect()->route('tallas.index')->with('success', 'Talla creada exitosamente.');
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
    public function edit(Talla $talla)
    {
        return view('talla.edit', compact('talla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Talla $talla)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:tallas,nombre,' . $talla->id,
        ]);

        $talla->update($request->all());

        return redirect()->route('tallas.index')->with('success', 'Talla actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Talla $talla)
    {
        $talla->delete();

        return redirect()->route('tallas.index')->with('success', 'Talla eliminada exitosamente.');
    }
}
