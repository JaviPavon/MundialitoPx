@extends('layout/plantilla')

@section('tituloPagina', 'Proyecto Integrado')

@section('contenido')
    @if (Auth::check() && Auth::user()->role === 'admin')
    <a class="" style="text-decoration: none" href="{{ route('fantasy.index') }}">
        <button class="carbutton">
            <div class="caption">Fantasy</div>
            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car"><path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"></path></svg>
        </button>
    </a>
    <a class="btn btn-success" href="{{ route('admin') }}">Pilotos Fantasy</a>
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
            <div class="card-header"><h5 class="card-title">Listado de pilotos del Fantasy</h5>
                <a class="btn btn-primary" href="{{ route('pilotos.create') }}">Agregar</a>
                <a class="btn btn-primary" href="{{ route('pilotos_juego.create') }}">Sincronizar Pilotos</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Puntos</th>
                            <th>Valor</th>
                            <th>Foto</th>
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
                                        <img class="" src="/fotos/{{ $piloto->piloto->foto}}" width="15%">
                                    </td>
                                @else
                                    <td>El Piloto no tiene Foto</td>
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
@endsection