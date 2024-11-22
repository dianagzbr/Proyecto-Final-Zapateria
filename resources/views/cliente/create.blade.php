@extends('template')

@section('title', 'Crear cliente')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
    #box-razon-social {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Crear Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item "><a href="{{ route('panel') }}">Incio</a></li>
        <li class="breadcrumb-item "><a href="{{ route('clientes.index') }}">Clientes</a></li>
        <li class="breadcrumb-item active">Crear cliente</li>
    </ol>

    <div class="card" style="background-color: #eb7ac5;">
        <form action="{{ route('clientes.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row g-4">

                    <!-- Tipo persona -->
                    <div class="col-md-6">
                        <label for="tipo_persona" class="form-label">Tipo de Persona:</label>
                        <select class="form-select" name="tipo_persona" id="tipo_persona">
                            <option value="" selected disabled>Seleccione una opción</option>
                            <option value="natural" {{old('tipo_persona' == 'natural' ? 'selected' : '')}}>Persona Natural</option>
                            <option value="juridica" {{old('tipo_persona' == 'juridica' ? 'selected' : '')}}>Persona Jurídica</option>
                        </select>
                        @error('tipo_persona')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!--Razón social-->
                    <div class="col-12" id="box-razon-social">
                        <label id="label-natural" for="razon_social" class="form-label">Nombres y Apellidos:</label>
                        <label id="label-juridica" for="razon_social" class="form-label">Nombre de la Empresa:</label>

                        <input required type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}">

                        @error('razon_social')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!--Dirección-->
                    <div class="col-12">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input required type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion')}}">
                        @error('direccion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!--Documento-->
                    <div class="col-md-6">
                        <label for="documento_id" class="form-label">Tipo de documento:</label>
                        <select class="form-select" name="documento_id" id="documento_id">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($documentos as $item)
                            <option value="{{$item->id}}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>{{$item->tipo_documento}}</option>
                            @endforeach
                        </select>
                        @error('documento_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Numero de documento:</label>
                        <input required type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{old('numero_documento')}}">
                        @error('numero_documento')
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
<script>
    $(document).ready(function() {
        $('#tipo_persona').on('change', function() {
            let selectValue = $(this).val();
            //natural //juridica
            if (selectValue == 'natural') {
                $('#label-juridica').hide();
                $('#label-natural').show();
            } else {
                $('#label-natural').hide();
                $('#label-juridica').show();
            }

            $('#box-razon-social').show();
        });
    });
</script>
@endpush