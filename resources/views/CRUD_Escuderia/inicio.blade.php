@extends('layout/plantilla')

@section('tituloPagina', 'Crud con Laravel 8')

@section('contenido')
    <a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
    <a class="btn btn-success" href="{{ route('admin') }}">Escuderias</a>
    <a class="btn btn-primary" href="{{ route('paises.index') }}">Paises</a>
    <a class="btn btn-primary" href="{{ route('circuitos.index') }}">Circuitos</a>
    <a class="btn btn-primary" href="{{ route('carreras.index') }}">Carreras</a>
    <a class="btn btn-primary" href="{{ route('noticias.index') }}">Noticias</a>

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
            <div class="card-header"><h5 class="card-title">Listado de escuderias</h5>
                <a class="btn btn-primary" href="{{ route('escuderias.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Posicion</th>
                            <th>Nombre</th>
                            <th>Alias</th>
                            <th>Descripción</th>
                            <th>Puntos</th>
                            <th>Pais</th>
                            <th>Logo</th>
                            <th>Monoplaza</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                        @foreach ($escuderias as $escuderia )
                            <tr>
                                <td>{{ $escuderia->posicion }}º</td>
                                <td>{{ $escuderia->nombre }}</td>
                                <td>{{ $escuderia->alias }}</td>
                                <td>{{ $escuderia->descripcion }}</td>
                                <td>{{ $escuderia->puntos }}</td>
                                @if ($escuderia->pais)
                                    <td>{{ $escuderia->pais->nombre }}</td>
                                @else
                                    <td>No hay Pais</td>
                                @endif
                                <td>
                                    <img src="/logos/{{ $escuderia->logo}}" width="50%">
                                </td>
                                <td>
                                    <img src="/monoplazas/{{ $escuderia->monoplaza}}" width="75%">
                                </td>
                                <td>
                                    <form action="{{ route("escuderias.edit", $escuderia->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("escuderias.show", $escuderia->id) }}" method="GET">
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