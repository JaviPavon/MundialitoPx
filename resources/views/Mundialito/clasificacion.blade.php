@extends('Mundialito/plantilla')

@section('tituloPagina', 'Clasificación Paxangars')

@section('contenido')
<br>
<div class="clasificacion">
<div class="row pt-3 justify-content-center align-items-center text-center">
    <div class="col-12">
        <h3>Clasificación Pilotos</h3>
        <div class="table-responsive" id="tabla-carreras">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <th>Puesto</th>
                    <th>Piloto</th>
                    <th>Puntos</th>
                    @foreach ($circuitos as $circuito)
                        <th><img class="img-bandera-clasificacion" src="/banderas/{{ $circuito->pais->bandera }}" alt="bandera"></th>
                    @endforeach
                </thead>
                <tbody id="orden">
                    @foreach ($pilotos as $piloto)
                        <tr data-id="{{ $piloto->id }}">
                            <td class="table-secondary">{{ $piloto->posicion }}º</td>
                            <td>{{ $piloto->nombre }}</td>
                            <td class="table-success"><b>{{ $piloto->puntos }}</b></td>
                            @foreach ($carreras as $carrera)
                            @if ($piloto->id == $carrera->id_piloto)
                                @php
                                    if ($carrera->vuelta_rapida) {
                                        $color = 'table-info';
                                    } elseif ($carrera->estado == 'DSQ' || $carrera->estado == 'DNF') {
                                        $color = 'table-danger';
                                    } else {
                                        $color = '';
                                    }
                                @endphp
                                <td class="{{ $color }}">
                                    @if ($carrera->estado == 'DSQ' || $carrera->estado == 'DNF')
                                        {{ $carrera->estado }}
                                    @else
                                        {{ $carrera->puntos }}
                                    @endif
                                </td>
                            @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-12">
        <h3>Clasificación Escuderías</h3>
        <div class="table-responsive" id="tabla-carreras">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <th>Puesto</th>
                    <th>Escudería</th>
                    <th>Puntos</th>
                    @foreach ($circuitos as $circuito)
                        <th><img class="img-bandera-clasificacion" src="/banderas/{{ $circuito->pais->bandera }}" alt="bandera"></th>
                    @endforeach
                </thead>
                <tbody id="orden">
                    @foreach ($escuderias as $escuderia)
                        <tr data-id="{{ $escuderia->id }}">
                            <td class="table-secondary">{{ $escuderia->posicion }}º</td>
                            <td>{{ $escuderia->nombre }}</td>
                            <td class="table-success"><b>{{ $escuderia->puntos }}</b></td>
                            @foreach ($circuitos as $circuito)
                                @php
                                    $totalPuntosCircuito = 0;
                                    $hasVueltaRapida = false;
                                    foreach ($carreras as $carrera) {
                                        if ($carrera->piloto->id_escuderia == $escuderia->id && $carrera->id_circuito == $circuito->id) {
                                            $totalPuntosCircuito += $carrera->puntos;
                                            if ($carrera->vuelta_rapida) {
                                                $hasVueltaRapida = true;
                                            }
                                        }
                                    }
                                    
                                    if ($hasVueltaRapida) {
                                        $color = 'table-info';
                                    } elseif ($totalPuntosCircuito == 0) {
                                        $color = 'table-danger';
                                    } else {
                                        $color = '';
                                    }
                                @endphp
                                <td class="{{ $color }}">{{ $totalPuntosCircuito }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection
