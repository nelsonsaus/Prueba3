@extends('plantillas.plantilla1')
@section('titulo')
    Alumnos
@endsection
@section('cabecera')
    Alumnos Academia
@endsection
@section('contenido')
    @if ($text = Session::get('mensaje'))
        <p class="bg-secondary text-white p-2 my-3">{{ $text }}</p>
    @endif
    <form name="indice" method="get" action="{{route('alumnos.index')}}" class="form-inline">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('alumnos.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Crear Alumno</a>
            </div>
        </div>
    </form>

    <table class="table table-striped table-primary mt-3">
        <thead>
            <tr>
                <th scope="col">Detalle</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">email</th>
                <th scope="col">foto</th>
                <th scope="col">telefono</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $item)
                <tr style="vertical-align: middle">
                    <th scope="row">
                        <a href="{{ route('alumnos.show', $item) }}" class="btn btn-info btn-lg"><i class="fa fa-info"></i>
                            Detalles</a>
                    </th>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->apellidos }}</td>
                    <td>{{ $item->email }}</td>
                    <td><img src="{{asset($item->foto)}}" width="95rem" height="90rem" class="rounded-circe"></td>
                    <td>{{ $item->telefono }}</td>
                    <td>
                        <form name="a" action="{{ route('alumnos.destroy', $item) }}" method='POST' class="form-inline">
                            @csrf
                            @method("DELETE")
                            <a href="{{ route('alumnos.edit', $item) }}" class="btn btn-primary btn-lg"><i
                                    class="fa fa-edit"></i> Editar</a>
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Borrar Alumno?')">
                                <i class="fas fa-trash"></i> Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $alumnos->appends(Request::except('page'))->links() }}
@endsection
