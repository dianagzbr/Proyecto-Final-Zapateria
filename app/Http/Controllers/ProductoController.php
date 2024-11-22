<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Talla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with(['categoria.caracteristica', 'marca.caracteristica', 'tallas'])->latest()->get();
        return view('producto.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Join para hacer una union entre tablas marcas y categorias con caracteristicas 
        //y traer a las marcas y categorías "activas"    
        //Select para solo traer solo los id's y nombres
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
            ->select('marcas.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)->get();

        $tallas = Talla::all();

        return view('producto.create', compact('marcas', 'categorias', 'tallas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'codigo' => 'required|string|unique:productos,codigo',
            'nombre' => 'required|unique:productos,nombre',
            'descripcion' => 'nullable|max:255',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // Validación para subir imágenes
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'required|exists:categorias,id', // Asegurarse de que se seleccionen categorías
            'tallas' => 'required|array',
            'tallas.*.id' => 'exists:tallas,id',
            'tallas.*.cantidad' => 'nullable|integer|min:0',
        ]);


        // Crear el producto
        $data = $request->all();
        $data['categoria_id'] = $request->categoria_id;


        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/productos'), $fileName); // Guardar en public/img/productos
            $data['img_path'] = 'img/productos/' . $fileName;
        }

        $producto = Producto::create($data);

        // Asociar tallas con cantidades
        $tallas = [];
        foreach ($request->tallas as $talla) {
            $tallas[$talla['id']] = ['cantidad' => $talla['cantidad'] ?? 0];
        }
        $producto->tallas()->attach($tallas);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->load(['marca.caracteristica', 'categoria.caracteristica', 'tallas']); // Cargar relaciones
        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $marcas = Marca::join('caracteristicas as c', 'marcas.caracteristica_id', '=', 'c.id')
            ->select('marcas.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)->get();
        
        $tallas = Talla::all();

        return view('producto.edit', compact('producto', 'marcas', 'categorias', 'tallas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required|string|max:100|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'nullable|string|max:255',
            'img_path' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'marca_id' => 'required|exists:marcas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'tallas' => 'nullable|array',
            'tallas.*.id' => 'exists:tallas,id',
            'tallas.*.cantidad' => 'nullable|integer|min:0',
        ]);
    
        // Obtener los datos validados
        $data = $request->all();
        $data['categoria_id'] = $request->categoria_id;
    
        // Procesar la imagen si se subió una nueva
        if ($request->hasFile('img_path')) {
            $file = $request->file('img_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/productos'), $fileName);
            $data['img_path'] = 'img/productos/' . $fileName;
    
            // Eliminar la imagen anterior si existe
            if ($producto->img_path && file_exists(public_path($producto->img_path))) {
                unlink(public_path($producto->img_path));
            }
        } else {
            // Si no se sube una nueva imagen, mantener la actual
            unset($data['img_path']);
        }
    
        // Actualizar el producto
        $producto->update($data);
    
        // Actualizar las tallas asociadas
        if ($request->has('tallas')) {
            $tallas = [];
            foreach ($request->tallas as $talla) {
                $tallas[$talla['id']] = ['cantidad' => $talla['cantidad'] ?? 0];
            }
            $producto->tallas()->sync($tallas); // Sincronizar las tallas
        } else {
            $producto->tallas()->detach(); // Si no se seleccionan tallas, eliminar todas las relaciones
        }
    
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        try {
            // Eliminar la imagen asociada si existe
            if ($producto->img_path && file_exists(public_path($producto->img_path))) {
                unlink(public_path($producto->img_path));
            }
    
            // Eliminar las relaciones con tallas
            $producto->tallas()->detach();
    
            // Eliminar el producto
            $producto->delete();
    
            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->route('productos.index')->with('error', 'Error al eliminar el producto.');
        }
    }
}
