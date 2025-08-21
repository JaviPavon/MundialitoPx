@extends('layout/plantilla')

@section('tituloPagina', 'Listado de Comentarios')

@section('contenido')
    <a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
    <a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
    <a class="btn btn-primary" href="{{ route('paises.index') }}">Paises</a>
    <a class="btn btn-primary" href="{{ route('circuitos.index') }}">Circuitos</a>
    <a class="btn btn-primary" href="{{ route('carreras.index') }}">Carreras</a>
    <a class="btn btn-primary" href="{{ route('noticias.index') }}">Noticias</a>
    <a class="btn btn-success" href="{{ route('admin') }}">Comentarios</a>
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
            <div class="card-header"><h5 class="card-title">Listado de Comentarios</h5>
                <a class="btn btn-primary" href="{{ route('comentario.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Noticia</th>
                            <th>Comentario</th>
                            <th>Fecha de Publicación</th>
                        </thead>
                        <tbody>
                            @foreach ($comentarios as $comentario )
                            <tr>
                                <td>{{ $comentario->noticia->titulo }}</td>
                                <td>{{ $comentario->comentario }}</td>
                                <td>{{ $comentario->created_at }}</td>
                                <td>
                                    <form action="{{ route("comentario.edit", $comentario->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("comentario.show", $comentario->id) }}" method="GET">
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