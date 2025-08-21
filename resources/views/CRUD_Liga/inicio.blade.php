@extends('layout.plantilla')

@section('tituloPagina', 'Fantasy')

@section('contenido')
    @if (Auth::check() && Auth::user()->role === 'admin')
        <a class="btn btn-success" href="{{ route('admin') }}">Fantasy</a>
    @endif
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
                <h5 class="card-title">Listado de Ligas a las que perteneces</h5>
                <a class="btn btn-primary" href="{{ route('liga.create') }}">Agregar</a>
                <a class="btn btn-success" href="{{ route('fantasy.index') }}">Listado de Ligas</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Liga</th>
                            <th>Nombre</th>
                            <th>Contador Jugadores</th>
                            <th>Unirse</th>
                        </thead>
                        <tbody>
                            @if ($ligas)
                                @foreach ($ligas as $liga )
                                <tr>
                                    <td>{{ $liga->estado }}</td>
                                    <td>{{ $liga->nombre }}</td>
                                    @if ( $liga->jugador->count()  > 1)
                                        <td>{{ $liga->jugador->count() }} jugadores</td>
                                    @else
                                        <td>{{ $liga->jugador->count() }} jugador</td>
                                    @endif
                                    <td><a class="btn btn-primary" href="{{ route('jugador.create', $liga->id) }}">Unirse</a></td>
                                </tr>
                                @endforeach
                            @else
                                No hay ligas disponibles
                            @endif
                        </tbody>
                    </table>
                </div>
            </p>
        </div>
    </div>
@endsection
