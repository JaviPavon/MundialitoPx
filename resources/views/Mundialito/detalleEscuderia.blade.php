@extends('Mundialito/plantilla')

@section('tituloPagina', 'Escuderia Paxangars')

@section('contenido')

<div class="row d-flex justify-content-center text-center ">
    <div class="col-12 col-xl-7 justify-content-center items-align-center text-center pt-5">
        <div class="card">
            <div class="card-title">
                <div class="row offset-1 pt-4 g-3">
                    <div class="col-11 col-md-6">
                        <div class="row pilotos">
                            @foreach ($pilotos as $piloto )
                            <div class="col-6 ">
                                <a href="{{ route('mundialito.piloto', $piloto->id) }}">
                                    <div class="position-relative">
                                        <img class="object-fit-fill border rounded img-fluid shadow" src="/fotos/{{ $piloto->foto }}" alt="">
                                        <div class="texto-foto text-white position-absolute top-0 start-0">
                                            <h4> {{ $piloto->dorsal }}</h4>
                                        </div>
                                        <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                                            <h3> {{ $piloto->nombre }}</h3>
                                            <h3> {{ $piloto->puntos }}pts</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-start">
                        <div class="position-relative">
                            <h2>{{ $escuderia->nombre }}</h2>
                            <p class="m-0">{{ $escuderia->alias }}</p>
                            <div class="position-absolute top-0 end-0 text-end mx-4">
                                <img class="w-25" src="/banderas/{{ $escuderia->pais->bandera }}" alt="bandera">
                            </div>
                            <img class="img-200" src="/logos/{{ $escuderia->logo }}" alt="logo">
                            <p>Posición: {{$escuderia->posicion}}º</p>
                            <p>Puntos: {{ $escuderia->puntos }}pts</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="pt-3 card-text text-start">

                    <div class="row">
                        <div class="col-10 offset-1 ">
                            <h2>Descripción</h2>
                            <p class="biografia">{{ $escuderia->descripcion }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4 pt-5 table-responsive">
        @if ($carreras)
        <table class="table table-bordered">
            <tr class="table-dark">
                <th>Circuito</th>
                <th>Piloto</th>
                <th>Puesto</th>
                <th>Puntos</th>
            </tr>
            @foreach ( $carreras as $carrera )
            <tr>
                <td class="table-light">{{ $carrera->circuito->nombre }}</td>
                <td>{{ $carrera->piloto->nombre }}</td>
                <td>{{ $carrera->puesto }}º</td>
                @if ($carrera->vuelta_rapida == True)
                <td class="bg-success">{{ $carrera->puntos }}</td>
                @else
                <td><b>{{ $carrera->puntos }}</b></td>
                @endif
            </tr>
            @endforeach
        </table>
        @else
        <p>Los pilotos de esta escudería no han jugado ninguna carrera</p>
        @endif
    </div>
</div>

<script>
    $('.pilotos').slick({
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: true,
            });
</script>

@endsection
