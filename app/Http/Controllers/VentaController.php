<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use App\Mail\VentaRealizada;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with(['comprobante', 'cliente.persona', 'user'])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return view('venta.index', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Venta::class);

        //traer la tabla compra-producto y seleccionar el producto_id filtrando por el valor maximo, es decir el mas reciente 
        $subquery = DB::table('compra_producto')
            ->select('producto_id', DB::raw('MAX(created_at) as max_created_at'))
            ->groupBy('producto_id');

        /*se une el modelo producto con la tabla de compra producto con un join especificando la condición con on
        De la subquery traer los datos si se cumplen las condiciones
        Con esto se obtiene el precio de venta, se valida el estado de los productos y que el stock sea mayor a 0*/
        $productos = Producto::join('compra_producto as cpr', function ($join) use ($subquery) {
            $join->on('cpr.producto_id', '=', 'productos.id')
                ->whereIn('cpr.created_at', function ($query) use ($subquery) {
                    $query->select('max_created_at')
                        ->fromSub($subquery, 'subquery')
                        ->whereRaw('subquery.producto_id = cpr.producto_id');
                });
        })
            ->select('productos.nombre', 'productos.id', 'productos.stock', 'cpr.precio_venta')
            ->where('productos.estado', 1)
            ->where('productos.stock', '>', 0)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();

        $comprobantes = Comprobante::all();
        return view('venta.create', compact('productos', 'clientes', 'comprobantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        try {
            DB::beginTransaction();
            Log::info('Iniciando el proceso de creación de una nueva venta.');
    
            // Fecha y hora actual
            $fechaHora = Carbon::now();
            Log::info('Fecha y hora de la venta registrada:', ['fecha_hora' => $fechaHora->toDateTimeString()]);
    
            // Validación de datos
            $ventaData = $request->validated();
            $ventaData['fecha_hora'] = $fechaHora;
    
            Log::info('Datos validados para la venta:', $ventaData);
    
            // Crear la venta
            $venta = Venta::create($ventaData);
            Log::info('Venta creada exitosamente:', $venta->toArray());
    
            // Manejo de productos
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraydescuento');
    
            Log::info('Arrays recibidos para productos:', [
                'Productos' => $arrayProducto_id,
                'Cantidades' => $arrayCantidad,
                'Precios de venta' => $arrayPrecioVenta,
                'Descuentos' => $arrayDescuento
            ]);
    
            $sizeArray = count($arrayProducto_id);
    
            for ($cont = 0; $cont < $sizeArray; $cont++) {
                Log::info("Procesando producto ID: {$arrayProducto_id[$cont]}");
    
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                        'descuento' => $arrayDescuento[$cont],
                    ]
                ]);
    
                Log::info('Producto sincronizado con la venta:', [
                    'producto_id' => $arrayProducto_id[$cont],
                    'cantidad' => $arrayCantidad[$cont],
                    'precio_venta' => $arrayPrecioVenta[$cont],
                    'descuento' => $arrayDescuento[$cont]
                ]);
    
                // Actualizar stock
                $producto = Producto::find($arrayProducto_id[$cont]);
                if (!$producto) {
                    throw new Exception("Producto no encontrado: ID {$arrayProducto_id[$cont]}");
                }
    
                $producto->decrement('stock', $arrayCantidad[$cont]);
                Log::info("Stock actualizado para el producto ID {$producto->id}: Nuevo stock: {$producto->stock}");
            }
    
            DB::commit();
            Log::info('Transacción completada exitosamente.');
    
            // Enviar correo a los administradores
            $adminEmails = User::where('role', 'admin')->pluck('email');
            Log::info('Enviando correo a los administradores:', $adminEmails->toArray());
    
            Mail::to($adminEmails)->send(new VentaRealizada($venta));
            Log::info('Correo enviado exitosamente.');
    
            return redirect()->route('ventas.index')->with('success', 'Venta registrada exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar la venta: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('ventas.create')->with('error', 'Ocurrió un error al registrar la venta.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        return view('venta.show', compact('venta'));
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
    public function destroy(Venta $venta)
    {
        $this->authorize('delete', $venta);

        try {
            $venta->delete();
            return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('ventas.index')->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }
}
