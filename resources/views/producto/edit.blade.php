@extends('template')

@section('title', 'Editar producto')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
        <li class="breadcrumb-item active">Editar producto</li>
    </ol>

    <div class="card p-3" style="background-color: #eb7ac5;">
        <form action="{{ route('productos.update', $producto->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row g-3">

                <!-- Código -->
                <div class="col-md-6 mb-2">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $producto->codigo) }}">
                    @error('codigo')
                    <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}">
                    @error('nombre')
                    <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="col-md-12 mb-2">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Imagen -->
                <div class="col-md-6 mb-2">
                    <label for="img_path" class="form-label">Imagen:</label>
                    <input type="file" name="img_path" id="img_path" class="form-control" accept="image/*">
                    @error('img_path')
                    <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Marca -->
                <div class="col-md-6 mb-2">
                    <label for="marca_id" class="form-label">Marca:</label>
                    <select name="marca_id" id="marca_id" class="form-control">
                        @foreach ($marcas as $item)
                        <option value="{{ $item->id }}" {{ old('marca_id', $producto->marca_id) == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('marca_id')
                    <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Categoría -->
                <div class="col-md-6 mb-2">
                    <label for="categoria_id" class="form-label">Categoría:</label>
                    <select name="categoria_id" id="categoria_id" class="form-control">
                        @foreach ($categorias as $item)
                        <option value="{{ $item->id }}" {{ old('categoria_id', $producto->categoria_id) == $item->id ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                    <small class="text-danger">{{ '*' . $message }}</small>
                    @enderror
                </div>

                <!-- Tallas -->
                <div class="col-md-6 mb-2">
                    <label class="form-label">Tallas:</label><br>
                    <button type="button" class="btn" style="background-color: #ffffff" data-bs-toggle="modal" data-bs-target="#tallasModal">Editar Tallas</button>
                </div>

                <!-- Modal de Tallas -->
                <div class="modal fade" id="tallasModal" tabindex="-1" aria-labelledby="tallasModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tallasModalLabel">Seleccionar Tallas</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @foreach ($tallas as $talla)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="talla_{{ $talla->id }}" name="tallas[{{ $talla->id }}][id]" value="{{ $talla->id }}"
                                        {{ in_array($talla->id, $producto->tallas->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="talla_{{ $talla->id }}">{{ $talla->nombre }}</label>
                                    <input type="number" name="tallas[{{ $talla->id }}][cantidad]" class="form-control mt-2" placeholder="Cantidad" min="0"
                                        value="{{ $producto->tallas->find($talla->id)->pivot->cantidad ?? 0 }}" {{ in_array($talla->id, $producto->tallas->pluck('id')->toArray()) ? '' : 'disabled' }}>
                                </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn mt-2" style="background-color: #eb348c; color: white;">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.form-check-input');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const cantidadInput = this.closest('.form-check').querySelector('input[type="number"]');
                cantidadInput.disabled = !this.checked;
                if (!this.checked) {
                    cantidadInput.value = '';
                }
            });
        });
    });
</script>
@endpush
