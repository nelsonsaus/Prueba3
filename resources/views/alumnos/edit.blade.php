@extends('plantillas.plantilla1')
@section('titulo')
    Alumnos
@endsection
@section('cabecera')
    Editar Alumno
@endsection
@section('contenido')
@if($errors->any())
    <div class="alert alert-danger my-3 p-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form name="fom" action="{{route('alumnos.update', $alumno)}}" method="POST" enctype="multipart/form-data" class="mt-3">
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-2">
            <input type="text" name="nombre" required value="{{$alumno->nombre}}" class="form-control">

        </div>
        <div class="col-5">
            <input type="text" name="apellidos" required value="{{$alumno->apellidos}}" class="form-control">
        </div>
        <div class="col-5">
            <input type="email" name="email" required value="{{$alumno->email}}" class="form-control">
        </div>
    </div>
    <div class="row mt-3">
    <div class="col-7">
        <input type="file" name="foto" class="form-control-file" />
        <img src="{{asset($alumno->foto)}}" class="img-thumbnail" width="180rem" height="180rem">
    </div>
    <div class="col-3">
        <input type="text" name="telefono" required value="{{$alumno->telefono}}" class="form-control">
    </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Actualizar Alumno</button>
            <button type="reset" class="btn btn-warning"><i class="fa fa-brush"></i> Limpiar</button>
            <a href="{{route('alumnos.index')}}" class="btn btn-primary"><i class="fa fa-house-user"></i> Inicio</a>
        </div>
    </div>
</form>
@endsection
