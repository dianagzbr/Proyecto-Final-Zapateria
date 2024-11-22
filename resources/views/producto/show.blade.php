@extends('template')

@section('content')
<div class="container">
    <h1>Detalles del Producto</h1>

    <div class="card">
        <div class="card-header">
            <h2>{{ $producto->nombre }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Código:</strong> {{ $producto->codigo }}</p>
            <p><strong>Descripción:</strong> {{ $producto->descripcion ?? 'No especificada' }}</p>
            <p><strong>Marca:</strong> {{ $producto->marca->caracteristica->nombre }}</p>
            <p><strong>Categorías:</strong>
                @if ($producto->categoria && $producto->categoria->caracteristica)
                <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center">
                    {{ $producto->categoria->caracteristica->nombre }}
                </span>
                @else
                <span class="text-danger">Sin categoría</span>
                @endif
            </p>
            @if($producto->img_path != null)
            <p><strong>Imagen:</strong></p>
            <!-- <p><strong>Ruta de la imagen:</strong> {{ asset($producto->img_path) }}</p> -->
            <img src="{{ asset($producto->img_path) }}" alt="{{ $producto->nombre }}" class="img-thumbnail">
            @else
            <p><strong>Imagen:</strong> No disponible</p>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
</div>
@endsection