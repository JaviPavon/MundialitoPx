@extends('layout.plantilla')

@section('tituloPagina', 'Listado de Noticias')

@section('contenido')
    <a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
    <a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
    <a class="btn btn-primary" href="{{ route('paises.index') }}">Paises</a>
    <a class="btn btn-primary" href="{{ route('circuitos.index') }}">Circuitos</a>
    <a class="btn btn-primary" href="{{ route('carreras.index') }}">Carreras</a>
    <a class="btn btn-success" href="{{ route('admin') }}">Noticias</a>
    <a class="btn btn-primary" href="{{ route('comentario.index') }}">Comentarios</a>
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
            <div class="card-header">
                <h5 class="card-title">Listado de Noticias</h5>
                <a class="btn btn-primary" href="{{ route('noticias.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Miniatura</th>
                            <th>Título</th>
                            <th>Cuerpo</th>
                            <th>Pilotos Relacionados</th>
                            <th>Escuderias Relacionadas</th>
                            <th>Circuito Relacionado</th>
                            <th>Fecha de Publicación</th>
                            <th>Escrito Por</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($noticias as $noticia )
                            <tr>
                                <td>
                                    <img class="img-200" src="/miniaturas/{{ $noticia->miniatura}}" width="15%">
                                </td>
                                <td>{{ $noticia->titulo }}</td>
                                <td>{{ $noticia->cuerpo }}</td>
                                @if ( count($noticia->pilotos) > 0 )
                                    <td>
                                        @foreach ($noticia->pilotos as $piloto)
                                            {{$piloto->nombre}}
                                        @endforeach
                                    </td>
                                @else
                                    <td>No tiene pilotos relacionados esta noticia</td>
                                @endif

                                @if ( count($noticia->escuderias) > 0 )
                                    <td>
                                        @foreach ($noticia->escuderias as $escuderia)
                                            {{$escuderia->nombre}}
                                        @endforeach
                                    </td>
                                @else
                                    <td>No tiene escuderias relacionadas esta noticia</td>
                                @endif

                                @if ( $noticia->circuito )
                                    <td>{{$noticia->circuito->nombre}}</td>
                                @else
                                    <td>No tiene circuito relacionado esta noticia</td>
                                @endif
                                <td>{{ $noticia->created_at }}</td>
                                <td>
                                    @if ($noticia->user_id)
                                        {{ $noticia->usuario->name }}
                                    @else
                                        Usuario no disponible
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route("noticias.edit", $noticia->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("noticias.show", $noticia->id) }}" method="GET">
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
