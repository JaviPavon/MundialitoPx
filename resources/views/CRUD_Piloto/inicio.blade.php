@extends('layout/plantilla')

@section('tituloPagina', 'Proyecto Integrado')

@section('contenido')
    <a class="btn btn-success" href="{{ route('admin') }}">Pilotos</a>
    <a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
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
            <div class="card-header"><h5 class="card-title">Listado de pilotos</h5>
                <a class="btn btn-primary" href="{{ route('pilotos.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Posicion</th>
                            <th>Nombre</th>
                            <th>Dorsal</th>
                            <th>Biografia</th>
                            <th>Puntos</th>
                            <th>Escuderia</th>
                            <th>Pais</th>
                            <th>Foto</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($pilotos as $piloto )
                            <tr>
                                <td>{{ $piloto->posicion }}º</td>
                                <td>{{ $piloto->nombre }}</td>
                                <td>{{ $piloto->dorsal }}</td>
                                <td>{{ $piloto->biografia }}</td>
                                <td>{{ $piloto->puntos }}</td>
                                
                                @if ($piloto->escuderia)
                                    <td>{{ $piloto->escuderia->nombre }}</td>
                                @else
                                    <td>No hay escuderia</td>
                                @endif
                                @if ($piloto->pais)
                                    <td>{{ $piloto->pais->nombre }}</td>
                                @else
                                    <td>No hay pais</td>
                                @endif
                                <td>
                                    <img src="/fotos/{{ $piloto->foto}}" width="15%">
                                </td>

                                <td>
                                    <form action="{{ route("pilotos.edit", $piloto->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("pilotos.show", $piloto->id) }}" method="GET">
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