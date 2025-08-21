@extends('layout/plantilla')

@section("tituloPagina", "Sincronizar Puntos Fantasy")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Sincronizar Putaje</h5></div>

            <p class="card-text">
                <form action="{{ route("fantasy.sincronizarPuntaje")}}" method="POST" >
                    @csrf
                    @method("PUT")
                    <h2>Puntuaciones de los pilotos en {{ $circuito->nombre }}</h2>
                    <div class="table table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <th>Puesto</th>
                                <th>Piloto</th>
                                <th>Q1->Q2</th>
                                <th>Q2->Q3</th>
                                <th>Adelantamientos</th>
                                <th>Sanciones de 3 segundos</th>
                                <th>Sanciones de 5 segundos</th>
                                <th>Amonestaciones</th>
                                <th>Puntos</th>
                            </thead>
                            <tbody>
                                @foreach ($jornadas as $jornada)
                                    <tr data-id="{{ $jornada->id }}">
                                        <td>{{ $jornada->puesto }}</td>
                                        <td>{{ $jornada->piloto_juego->piloto->nombre }}</td>
                                        @if ($jornada->qually2 == 1)
                                            <td><i class="bi bi-check"></i></td>
                                        @else
                                            <td><i class="bi bi-x"></i></td>
                                        @endif
                                        @if ($jornada->qually3 == 1)
                                            <td><i class="bi bi-check"></i></td>
                                        @else
                                            <td><i class="bi bi-x"></i></td>
                                        @endif
                                        <td>{{ $jornada->adelantamientos }}</td>
                                        <td>{{ $jornada->sancion3sec }}</td>
                                        <td>{{ $jornada->sancion5sec }}</td>
                                        <td>{{ $jornada->amonestaciones }}</td>
                                        <td>{{ $jornada->puntos }}pts</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary">Sincronizar</button>
                    <a href="{{ route('admin') }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection