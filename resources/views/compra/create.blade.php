@extends('template')

@section('title','Realizar compra')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('compras.index')}}">Compras</a></li>
        <li class="breadcrumb-item active">Crear Compra</li>
    </ol>
</div>

<form action="{{route('compras.store')}}" method="POST">
    @csrf

    <div class="container mt-4">
        <div class="row gy-4">
            <!-- Compra Producto -->
            <div class="col-md-8">
                <div class="text-white p-1 text-center" style="background-color:#db2373">
                    Detalles de la compra
                </div>
                <div class="p-3 border border-3" style="--bs-border-color:#db2373">
                    <div class="row">
                        <!-- Producto -->
                        <div class="col-md-12 mb-4">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" title="Agregar producto">
                                @foreach ($productos as $item)
                                <option value="{{$item->id}}">{{$item->codigo.' '.$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cantidad -->
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>

                        <!-- Precio de compra -->
                        <div class="col-md-4 mb-2">
                            <label for="precio_compra" class="form-label">Precio de compra:</label>
                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">
                        </div>

                        <!-- Precio de venta -->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                        </div>

                        <!-- Boton agregar -->
                        <div class="col-md-12 mb-2 text-end">
                            <button id="btn_agregar" type="button" class="btn mt-2" style="background-color:#db2373; color: white;">Agregar</button>
                        </div>

                        <!-- Tabla detalle de compra -->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead style="background-color:#db2373; color:white;">
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio compra</th>
                                            <th>Precio venta</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Sumas</th>
                                            <th colspan="2"><span id="sumas">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">IVA %</th>
                                            <th colspan="2"><span id="iva">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="2"><input type="hidden" name="total" value="0" id="inputTotal"><span id="total">0</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Producto -->
            <div class="col-md-4">
                <div class="text-white p-1 text-center" style="background-color:#db2373">
                    Datos Generales
                </div>
                <div class="p-3 border border-3" style="--bs-border-color:#db2373">
                    <div class="row">
                        <!-- Proveedor -->
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Proveedor:</label>
                            <select name="proveedore_id" id="proveedore_id" class="form-select">
                                <option value="" selected disabled>Seleccione una opción</option>
                                @foreach ($proveedores as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('proveedore_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <!-- Tipo de comprobante -->
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="form-select">
                                <option value="" selected disabled>Seleccione una opción</option>
                                @foreach ($comprobantes as $item)
                                <option value="{{$item->id}}">{{$item->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <!-- Numero de comprobante -->
                        <div class="col-md-12 mb-2">
                            <label for="numero_comprobante" class="form-label">Número de comprobante:</label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                            @error('numero_comprobante')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        

                        <!-- Impuesto -->
                        <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">Impuesto (IVA):</label>
                            <input required type="text" name="impuesto" id="impuesto" class="form-control border-success">
                            @error('impuesto')
                                <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>

                        <!-- Fecha -->
                        <div class="col-md-6 mb-2">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input required type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
                        <?php
                        use Carbon\Carbon;
                        $fecha_hora = Carbon::now()->toDayDateTimeString();
                        ?>  
                        <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">  
                        </div>

                        <!-- Boton -->
                        <div class="col-md-12 mb-2 text-center">
                            <button type="submit" class="btn mt-2" style="background-color:#db2373; color: white;">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn_agregar').click(function() {
            agregarProducto();
        });

        $('#impuesto').val(impuesto + '%');
    });

    //Variables
    let cont = 0;
    let subtotal = [];
    let sumas = 0;
    let iva = 0;
    let total = 0;

    const impuesto = 16;

    function agregarProducto() {
        //Obtener valores de los campos
        let idProducto = $('#producto_id').val();
        let nameProducto = ($('#producto_id option:selected').text()).split(' ')[1];
        let cantidad = $('#cantidad').val();
        let precioCompra = $('#precio_compra').val();
        let precioVenta = $('#precio_venta').val();

        //Validar campos
        if (nameProducto != '' && nameProducto != undefined && cantidad != '' && precioCompra != '' && precioVenta != '') {
            if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(precioCompra) > 0 && parseFloat(precioVenta) > 0) {
                if (parseFloat(precioVenta) > parseFloat(precioCompra)) {

                    //Cálculos
                    subtotal[cont] = round(cantidad * precioCompra);
                    sumas += subtotal[cont];
                    iva = round(sumas / 100 * impuesto);
                    total = round(sumas + iva);
                    

                    //Fila nueva
                    let fila = '<tr id="fila'+ cont +'">' +
                        '<th>' + (cont + 1) + '</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                        '<td><input type="hidden" name="arraypreciocompra[]" value="' + precioCompra + '">' + precioCompra + '</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + precioVenta + '</td>' +
                        '<td>' + subtotal[cont] + '</td>' +
                        '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto('+ cont +')"><i class="fa-solid fa-trash"></i></button></td>' +
                        '</tr>';

                    $('#tabla_detalle').append(fila);
                    limpiarEntrys();
                    cont++;

                    $('#sumas').html(sumas);
                    $('#iva').html(iva);
                    $('#total').html(total);
                    $('#impuesto').val(iva);
                    $('#inputTotal').val(total);

                } else {
                    showModal('Precio de compra incorrecto');
                }

            } else {
                showModal('Valores incorrectos');
            }

        } else {
            showModal('Le faltan campos por llenar');
        }
    }

    function eliminarProducto(indice) {
        //Calcular valores
        sumas -= round(subtotal[indice]);
        iva = round(sumas / 100 * impuesto);
        total = round(sumas + iva);

        //Mostrar los campos calculados
        $('#sumas').html(sumas);
        $('#iva').html(iva);
        $('#total').html(total);
        $('#impuesto').val(iva);
        $('#inputTotal').val(total);

        //Eliminar el fila de la tabla
        $('#fila' + indice).remove();

    }

    function limpiarEntrys() {
        let select = $('#producto_id');
        select.selectpicker();
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_compra').val('');
        $('#precio_venta').val('');
    }

    function round(num, decimales = 2) {
        var signo = (num >= 0 ? 1 : -1);
        num = num * signo;
        if (decimales === 0) //con 0 decimales
            return signo * Math.round(num);
        // round(x * 10 ^ decimales)
        num = num.toString().split('e');
        num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
        // x * 10 ^ (-decimales)
        num = num.toString().split('e');
        return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
    }
    //Fuente: https://es.stackoverflow.com/questions/48958/redondear-a-dos-decimales-cuando-sea-necesario

    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: icon,
            title: message
        })
    }
</script>
@endpush