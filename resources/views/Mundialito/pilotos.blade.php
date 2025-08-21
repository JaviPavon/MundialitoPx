@extends('Mundialito/plantilla')

@section('tituloPagina', 'Pilotos Paxangars')

@section('contenido')

<div class="row pt-3 justify-content-center text-center">
    <div class="col-4">
        <h2>Clasificación</h2>
        <div class="row pt-3">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered justify-content-center align-items-center text-center">
                    <tr class="table-dark">
                        <th>Posición</th>
                        <th>Nombre</th>
                        <th>Puntos</th>
                    </tr>
                    @foreach ($pilotosc as $piloto)
                    <tr class="table-hover-row">
                        <td class="table-secondary">{{ $piloto->posicion }}º</td>
                        <td>{{ $piloto->nombre }}</td>
                        <td class="table-warning">{{ $piloto->puntos }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <h2>Pilotos</h2>
        <div class="row g-3 pt-3 d-flex justify-content-center">
            @foreach ($pilotosPorEscuderia as $parejaPilotos)
                @foreach ($parejaPilotos as $piloto)
                <div class="col-6 col-sm-3">
                    <a href="{{ route('mundialito.piloto', $piloto->id) }}">
                        <div class="position-relative">
                            <img class="object-fit-fill border rounded-4 img-fluid" src="/fotos/{{ $piloto->foto }}" alt="">
                            <div class="texto-foto texto-valor text-white position-absolute top-0 start-0">
                                <h4>{{ $piloto->dorsal }}</h4>
                            </div>
                            <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                                <h4>{{ $piloto->nombre }}</h4>
                                <h5>{{ $piloto->puntos }}pts</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endforeach
        </div>
        <div class="row g-3 pt-3 d-flex justify-content-center">
            @foreach ($pilotosExtra as $piloto)
            <div class="col-6 col-sm-3">
                <a href="{{ route('mundialito.piloto', $piloto->id) }}">
                    <div class="position-relative">
                        <img class="object-fit-fill border rounded-4 img-fluid" src="/fotos/{{ $piloto->foto }}" alt="">
                        <div class="texto-foto texto-valor text-white position-absolute top-0 start-0">
                            <h4>{{ $piloto->dorsal }}</h4>
                        </div>
                        <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                            <h4>{{ $piloto->nombre }}</h4>
                            <h5>{{ $piloto->puntos }}pts</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
