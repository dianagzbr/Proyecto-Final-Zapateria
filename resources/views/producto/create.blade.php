@extends('template')

@section('title', 'Crear producto')

@push('css')
<style>
    #descripcion{
        resize: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Producto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="{{ route('panel') }}">Incio</a></li>
            <li class="breadcrumb-item "><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Crear producto</li>
        </ol>

        <div class="card p-3" style="background-color: #eb7ac5;">
        <form action="{{ route('productos.store') }}" method="post">
            @csrf
            <div class="row g-3">

                <!-- Código -->
                <div class="col-md-6 mb-2 ">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo')}}">
                    @error('codigo')
                    <small class="text-danger">{{'*'.message}}</small>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                    @error('nombre')
                    <small class="text-danger">{{'*'.message}}</small>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="col-md-12 mb-2">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{old('descripcion')}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'*'.message}}</small>
                    @enderror
                </div>

                <!-- Imagen -->
                <div class="col-md-6 mb-2">
                    <label for="img_path" class="form-label">Imagen:</label>
                    <input type="file" name="img_path" id="img_path" class="form-control" accept="Image/">
                    @error('img_path')
                    <small class="text-danger">{{'*'.message}}</small>
                    @enderror
                </div>

                <!-- Marca -->
                <div class="col-md-6 mb-2">
                    <label for="marca_id" class="form-label">Marca:</label>
                    <select name="marca_id" id="marca_id" class="form-control">
                        @foreach ($marcas as $item)
                            <option value="{{$item->id}}">{{$item->caracteristica->nombre}}</option>
                        @endforeach
                    </select>
                    @error('marca')
                    <small class="text-danger">{{'*'.message}}</small>
                    @enderror
                </div>

                <!-- Categorías -->
                <div class="col-md-6 mb-2">
                    <label for="categorias" class="form-label">Categorías:</label>
                    <select name="categorias" id="categorias" class="form-control">
                        @foreach ($categorias as $item)
                            <option value="{{$item->id}}">{{$item->caracteristica->nombre}}</option>
                        @endforeach
                    </select>
                    @error('categoria')
                    <small class="text-danger">{{'*'.message}}</small>
                    @enderror
                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn mt-2" style="background-color: #ffffff; color: black;">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush