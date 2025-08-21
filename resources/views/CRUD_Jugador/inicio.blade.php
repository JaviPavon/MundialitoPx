@extends('layout.plantilla')

@section('tituloPagina', 'Listado de Jugador')

@section('contenido')
    @if (Auth::check() && Auth::user()->role === 'admin')
    <a class="" style="text-decoration: none" href="{{ route('fantasy.index') }}">
        <button class="carbutton">
            <div class="caption">Fantasy</div>
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car"><path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"></path></svg>
        </button>
    </a>
    <a class="btn btn-primary" href="{{ route('pilotos_juego.index') }}">Pilotos Fantasy</a>
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
                <h5 class="card-title">Listado de Jugador</h5>
                @if ($fantasy->en_juego == 0)
                <form action="{{ route('jugador.vaciarCampos', $jugador->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary" >Vaciar Pilotos</button>
                </form>
                @else
                    <button type="button" class="btn btn-primary" disabled>Vaciar Pilotos</button>
                @endif
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Puntos</th>
                            <th>Saldo</th>
                            <th>Piloto Lider</th>
                            <th>Piloto Secundario</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $jugador->usuario->name }}</td>
                                <td>{{ $jugador->puesto }}º</td>
                                <td>{{ $jugador->puntos }}</td>
                                <td>{{ number_format($jugador->saldo, 0, ',', '.') }}€</td>
                                <td>
                                    @if ($jugador->id_piloto_juego_lider)
                                        {{$jugador->piloto_juego_lider->piloto->nombre}}
                                    @else
                                        No dispone de Piloto líder
                                    @endif
                                </td>
                                <td>
                                    @if ($jugador->id_piloto_juego)
                                        {{$jugador->piloto_juego->piloto->nombre}}
                                    @else
                                        No dispone de Piloto Secundario
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </p>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            {{-- <div class="row">
                <div class="col">
                    @if ($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
            </div> --}}
            <div class="card-header">
                <h5 class="card-title">Historial del Jugador</h5>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Jornada</th>
                            <th>Jugador</th>
                            <th>Piloto Lider</th>
                            <th>Piloto</th>
                        </thead>
                        <tbody>
                            @foreach ($historiales as $historial )
                            <tr>
                                <td>{{ $historial->numero_jornada }}</td>
                                <td>{{ $historial->jugador->usuario->name }}</td>
                                @if ($historial->piloto_juego_lider)
                                <td>{{ $historial->piloto_juego_lider->piloto->nombre }}</td>
                                @else
                                <td>No contiene piloto líder</td>
                                @endif
                                @if ($historial->piloto_juego)
                                <td>{{ $historial->piloto_juego->piloto->nombre }}</td>
                                @else
                                <td>No contiene piloto</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </p>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            {{-- <div class="row">
                <div class="col">
                    @if ($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
            </div> --}}
            <div class="card-header">
                <h5 class="card-title">Listado de Pilotos</h5>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Puntos</th>
                            <th>Valor</th>
                            <th>Foto</th>
                            <th>Piloto Lider</th>
                            <th>Piloto</th>
                            <th>Editar</th>
                        </thead>
                        <tbody>
                            @foreach ($pilotos as $piloto )
                            <tr>
                                @if ($piloto->piloto)
                                <td>{{ $piloto->piloto->nombre }}</td>
                                @else
                                <td>No existe este piloto</td>
                                @endif
                                <td>{{ $piloto->puntos }}</td>
                                <td>{{ number_format($piloto->valor, 0, ',', '.') }}€</td>

                                @if ($piloto->piloto)
                                    <td>
                                        <img src="/fotos/{{ $piloto->piloto->foto}}" width="15%">
                                    </td>
                                @else
                                    <td>El Piloto no tiene Foto</td>
                                @endif
                                
                                @if ($fantasy->en_juego == 0)
                                    <td>
                                        <form action="{{ route('jugador.updatelider', $jugador->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="idpiloto" value="{{ $piloto->id }}">
                                            <button type="submit" class="btn btn-primary">Agregar</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('jugador.update', $jugador->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="idpiloto" value="{{ $piloto->id }}">
                                            <button type="submit" class="btn btn-primary">Agregar</button>
                                        </form>
                                    </td>
                                @else
                                    <td><button type="button" class="btn btn-primary" disabled>Agregar</button></td>
                                    <td><button type="button" class="btn btn-primary" disabled>Agregar</button></td>
                                @endif

                                <td>
                                    <form action="{{ route("pilotos_juego.edit", $piloto->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
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
    <br>
    <div class="card">
        <div class="card-body">
            {{-- <div class="row">
                <div class="col">
                    @if ($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
            </div> --}}
            <div class="card-header">
                <h5 class="card-title">Listado de Pilotos</h5>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Puntos</th>
                            <th>Piloto Lider</th>
                            <th>Piloto</th>
                        </thead>
                        <tbody>
                            @foreach ($jugadores as $jugador )
                            <tr>
                                <td>{{ $jugador->usuario->name }}</td>
                                <td>{{ $jugador->puesto }}º</td>
                                <td>{{ $jugador->puntos }}</td>
                                <td>
                                    @if ($jugador->id_piloto_juego_lider)
                                        {{$jugador->piloto_juego_lider->piloto->nombre}}
                                    @else
                                        No dispone de Piloto líder
                                    @endif
                                </td>
                                <td>
                                    @if ($jugador->id_piloto_juego)
                                        {{$jugador->piloto_juego->piloto->nombre}}
                                    @else
                                        No dispone de Piloto Secundario
                                    @endif
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
