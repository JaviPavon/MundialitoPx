@extends('layout/plantilla')

@section('tituloPagina', 'Proyecto Integrado')

@section('contenido')
    <a class="btn btn-primary" href="{{ route('canal.index') }}">Canales</a>
    <a class="btn btn-success" href="{{ route('admin') }}">Videos</a>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    @if ($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-header"><h5 class="card-title">Listado de videos de los canales</h5>
                <a class="btn btn-primary" href="{{ route('video.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Enlace</th>
                            <th>Fecha de Publicación</th>
                            <th>Canal</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($videos as $video )
                            <tr>
                                <td>{{ $video->nombre }}</td>
                                <td><a href="{{ $video->enlace }}">Enlace</a></td>
                                <td>{{ $video->fecha_publicacion }}</td>
                                <td>{{ $video->canal->nombre }}</td>


                                <td>
                                    <form action="{{ route("video.edit", $video->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("video.show", $video->id) }}" method="GET">
                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </p>
        </div>
    </div>
@endsection