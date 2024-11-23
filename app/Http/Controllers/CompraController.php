<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedore;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('compra.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedore::all();
        $comprobantes = Comprobante::all();
        $productos = Producto::where('estado', 1)->get();
        return view('compra.create', compact('proveedores', 'comprobantes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        try {
            DB::beginTransaction();
            //Log::info('Iniciando transacción para guardar la compra');
    
            // Convertir la fecha_hora al formato correcto
            $fechaHora = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->toDateTimeString());
            //Log::info('Fecha y hora convertida: ' . $fechaHora);
    
            // Agregar el campo convertido al request
            $compraData = $request->validated();
            $compraData['fecha_hora'] = $fechaHora;
    
            // Crear la compra
            $compra = Compra::create($compraData);
            //Log::info('Compra creada: ', $compra->toArray());
    
            // Llenar tabla compra_producto
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
    
            // Log::info('Arrays de productos recibidos: ', [
            //     'Productos' => $arrayProducto_id,
            //     'Cantidades' => $arrayCantidad,
            //     'Precios de compra' => $arrayPrecioCompra,
            //     'Precios de venta' => $arrayPrecioVenta
            // ]);
    
            $sizeArray = count($arrayProducto_id);
            for ($cont = 0; $cont < $sizeArray; $cont++) {
                //Log::info("Procesando producto ID: {$arrayProducto_id[$cont]}");
    
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_compra' => $arrayPrecioCompra[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                    ]
                ]);
    
                $producto = Producto::find($arrayProducto_id[$cont]);
                if (!$producto) {
                    throw new Exception("Producto no encontrado: ID {$arrayProducto_id[$cont]}");
                }
    
                $producto->increment('stock', $arrayCantidad[$cont]);
                //Log::info("Stock actualizado para el producto ID {$producto->id}: Nuevo stock: {$producto->stock}");
            }
    
            DB::commit();
            //Log::info('Transacción completada exitosamente');
    
            return redirect()->route('compras.index')->with('success', 'Compra registrada exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            //Log::error('Error al guardar la compra: ' . $e->getMessage());
    
            return redirect()->route('compras.create')->with('error', 'Ocurrió un error al registrar la compra.');
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
    public function destroy(string $id)
    {
        //
    }
}
