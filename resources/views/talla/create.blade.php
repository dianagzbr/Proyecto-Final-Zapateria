@extends('template')

@section('title', 'Crear talla')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Talla</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="{{ route('panel') }}">Incio</a></li>
            <li class="breadcrumb-item "><a href="{{ route('tallas.index') }}">Tallas</a></li>
            <li class="breadcrumb-item active">Crear talla</li>
        </ol>

        <div class="card" style="background-color: #eb7ac5;">
        <form action="{{ route('tallas.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row g-4">

                    <div class="col">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                        @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn" style="background-color: #ffffff; color: black;">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush