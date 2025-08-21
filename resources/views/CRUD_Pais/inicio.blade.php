@extends('layout/plantilla')

@section('tituloPagina', 'Crud con Laravel 8')

@section('contenido')
    <a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
    <a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
    <a class="btn btn-success" href="{{ route('admin') }}">Paises</a>
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
            <div class="card-header"><h5 class="card-title">Listado de Paises</h5>
                <a class="btn btn-primary" href="{{ route('paises.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Bandera</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($paises as $pais )
                            <tr>
                                <td>{{ $pais->id }}</td>
                                <td>{{ $pais->nombre }}</td>
                                <td>
                                    <img src="/banderas/{{ $pais->bandera}}" width="15%">
                                </td>
                                <td>
                                    <form action="{{ route("paises.edit", $pais->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("paises.show", $pais->id) }}" method="GET">
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