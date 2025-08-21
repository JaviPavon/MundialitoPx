@extends('layout.plantilla')

@section('tituloPagina', 'Fantasy')

@section('contenido')
    @if (Auth::check() && Auth::user()->role === 'admin')
        <a class="" style="text-decoration: none" href="{{ route('admin') }}">
            <button class="carbutton">
                <div class="caption">Fantasy</div>
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car"><path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"></path></svg>
            </button>
        </a>
        <a class="btn btn-primary" href="{{ route('pilotos_juego.index') }}">Pilotos Fantasy</a>
        <a class="btn btn-primary" href="{{ route('jornada.index') }}">Jornada</a>
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
                <div class="row">
                    <div class="col-2"><a class="btn btn-primary" href="{{ route('liga.index') }}">Listado de Ligas</a>
                        </div>
                    <div class="col-2">
                        <form id="toggleForm" action="{{ route('fantasy.enJuego') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="toggler">
                                <input id="toggler-1" name="toggler-1" type="checkbox" value="1" {{ $fantasy->en_juego == 1 ? 'checked' : '' }} onchange="document.getElementById('toggleForm').submit()">
                                <label for="toggler-1">
                                    <svg class="toggler-on" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                        <polyline class="path check" points="100.2,40.2 51.5,88.8 29.8,67.5"></polyline>
                                    </svg>
                                    <svg class="toggler-off" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                        <line class="path line" x1="34.4" y1="34.4" x2="95.8" y2="95.8"></line>
                                        <line class="path line" x1="95.8" y1="34.4" x2="34.4" y2="95.8"></line>
                                    </svg>
                                </label>
                            </div>                        
                        </form>
                        
                    </div>
                    <div class="col-2">
                        <form action="{{ route('fantasy.editar') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Siguiente circuito</button>                       
                        </form>
                    </div>
                    <div class="col-2">
                        <a class="btn btn-primary" href="{{ route('fantasy.show') }}">Sincronizar puntos</a>
                    </div>
                </div>
            </div>
            
            
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Liga</th>
                            <th>Puntos</th>
                            <th>Nombre Usuario</th>
                            <th>Puesto</th>
                            <th>Saldo</th>
                            <th>Entrar</th>
                            <th>Abandonar</th>
                        </thead>
                        <tbody>
                            @foreach ($jugadores as $jugador )
                            <tr>
                                <td>{{ $jugador->liga->nombre }}</td>
                                <td>{{ $jugador->puntos }}</td>
                                <td>{{ $jugador->usuario->name }}</td>
                                <td>{{ $jugador->puesto }}</td>
                                <td>{{ number_format($jugador->saldo, 0, ',', '.') }}€</td>
                                <td><a class="btn btn-primary" href="{{ route('jugador.index', $jugador->id) }}">Entrar a la liga</a></td>
                                <td>
                                    <form action="{{ route('jugador.destroy', $jugador->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Abandonar</button>
                                    </form>
                                </td>
                                
                                {{-- <td>
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
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </p>
        </div>
    </div>
@endsection
