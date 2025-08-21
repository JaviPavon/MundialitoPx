@extends('layout/plantilla')

@section('tituloPagina', 'Crud con Laravel 8')

@section('contenido')
    <a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
    <a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
    <a class="btn btn-primary" href="{{ route('paises.index') }}">Paises</a>
    <a class="btn btn-success" href="{{ route('admin') }}">Circuitos</a>
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
            <div class="card-header"><h5 class="card-title">Listado de circuitos</h5>
                <a class="btn btn-primary" href="{{ route('circuitos.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Alias</th>
                            <th>Pais</th>
                            <th>Fecha</th>
                            <th>Circuito</th>
                            <th>Silueta</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($circuitos as $circuito )
                            <tr>
                                <td>{{ $circuito->nombre }}</td>
                                <td>{{ $circuito->alias }}</td>
                                @if ($circuito->pais)
                                    <td>{{ $circuito->pais->nombre }}</td>
                                @else
                                    <td>No hay Pais</td>
                                @endif
                                @if ($circuito->fecha_circuito)
                                    <td>{{ $circuito->fecha_circuito }}</td>
                                @else
                                    <td>Proximamente...</td>
                                @endif
                                <td>
                                    <img class="img-200" src="/circuitos/{{ $circuito->circuito}}">
                                </td>
                                <td>
                                    <img class="img-200" src="/siluetas/{{ $circuito->silueta}}" style="height: 100px; width:auto;">
                                </td>
                                <td>
                                    <form action="{{ route("circuitos.edit", $circuito->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("circuitos.show", $circuito->id) }}" method="GET" >
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