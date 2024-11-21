@extends('template')

@section('title', 'Crear marca')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Marca</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item "><a href="{{ route('panel') }}">Incio</a></li>
            <li class="breadcrumb-item "><a href="{{ route('marcas.index') }}">Marcas</a></li>
            <li class="breadcrumb-item active">Crear marca</li>
        </ol>

        <div class="card" style="background-color: #eb7ac5;">
        <form action="{{ route('marcas.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row g-4">

                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                        @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{old('descripcion')}}</textarea>
                        @error('descripcion')
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