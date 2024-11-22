@extends('template')

@section('title', 'proveedore')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')

@if(session('success'))
<script>
    let message = "{{ session('success') }}"; 

if (message) { 
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    Toast.fire({
        icon: "success", 
        title: message 
    });
}
</script>
@endif

<div class="container-fluid px-4">
    <h1 class="mt-4">Proveedores</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Proveedores</li>
    </ol>

    <div class="mb-4">
        <a href="{{ route('proveedores.create') }}"><button type="button" class="btn btn-outline-primary">Añadir nuevo proveedor</button></a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Proveedores
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Documento</th>
                        <th>Tipo de Persona</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($proveedores as $item)
                    <tr>
                        <td>
                            {{$item->persona->razon_social}}
                        </td>
                        <td>
                            {{$item->persona->direccion}}
                        </td>
                        <td>
                            <p class="fw-semibold mb-1">{{$item->persona->documento->tipo_documento}}</p>
                            <p class="text-muted mb-0">{{$item->persona->numero_documento}}</p>
                        </td>
                        <td>
                            {{$item->persona->tipo_persona}}
                        </td>
                        <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('proveedores.edit', $item->id) }}" class="btn btn-warning">Editar</a>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Eliminar</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Modal de confirmación-->
                    <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ '¿Seguro que quieres eliminar el proveedor?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('proveedores.destroy',$item->id) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
