<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $modelType, $modelId)
    {
        $request->validate([
            'archivos.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $model = $this->getModel($modelType, $modelId);

        foreach ($request->file('archivos') as $archivo) {
            $path = $archivo->store('uploads', 'public');

            $model->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $path,
            ]);
        }

        return redirect()->back()->with('success', 'Archivos subidos exitosamente.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Archivo $archivo)
    {
        Storage::disk('public')->delete($archivo->ruta);
        $archivo->delete();

        return redirect()->back()->with('success', 'Archivo eliminado exitosamente.');
    }

    private function getModel($modelType, $modelId)
    {
        $models = [
            'producto' => \App\Models\Producto::class,
            'compra' => \App\Models\Compra::class,
        ];

        if (!array_key_exists($modelType, $models)) {
            abort(404, 'Modelo no encontrado');
        }

        return $models[$modelType]::findOrFail($modelId);
    }

    public function download(Archivo $archivo)
    {
        $filePath = storage_path('app/public/' . $archivo->ruta);

        if (!file_exists($filePath)) {
            abort(404, 'El archivo no existe.');
        }

        return response()->download($filePath, $archivo->nombre);
    }
}
