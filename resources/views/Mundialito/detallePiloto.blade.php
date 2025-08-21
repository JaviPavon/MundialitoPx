@extends('Mundialito/plantilla')

@section('tituloPagina', 'Piloto Paxangars')

@section('contenido')

<div class="row d-flex justify-content-center">
    <div class="col-12 col-xl-7 pt-5">
        <div class="card">
        <div class="position-relative">
            <div class="card-title">
                <div class="row pt-4 g-3">
                    <div class="col-6 col-sm-4 offset-sm-1">
                        <img class="object-fit-fill border rounded img-fluid shadow texto-foto" src="/fotos/{{ $piloto->foto }}" style="height: 100%; min-width: 160px;" alt="piloto">
                    </div>
                    <div class="col-6 offset-1 offset-sm-0 text-start">
                        
                            <h2>{{ $piloto->nombre }}</h2>
                            <img class="w-25 d-none d-lg-block" src="/banderas/{{ $piloto->pais->bandera }}" alt="{{$piloto->pais->nombre}}">
                            <p class="pt-4">Nº{{ $piloto->dorsal }}</p>
                            <p>Posición: {{$piloto->posicion}}º</p>
                            <p>Puntos: {{ $piloto->puntos }}pts</p>
                            <img class="w-25 d-lg-none position-absolute top-0 end-0 texto-valor texto-liga" src="/banderas/{{ $piloto->pais->bandera }}" alt="{{$piloto->pais->nombre}}">
                        </div>
                    </div>
                    </div>
                    <hr>
                    <div class="pt-3 card-text text-start">
                    
                        <div class="row">
                            <div class="col-10 offset-1 ">
                                <h2>Biografía</h2>
                                <p class="biografia">{{ $piloto->biografia }}</p>
                            </div>
                        </div>
                </div>
            </div>
            </div>
    </div>
    <div class="col-12 col-xl-4 pt-5">
        @if ($carreras)
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-responsive justify-content-center align-items-center text-center">
                <tr class="table-dark">
                    <th>Circuito</th>
                    <th>Posición</th>
                    <th>Puntos</th>
                </tr>
                @foreach ($carreras as $carrera )
                <tr>
                    <td class="table-light">{{ $carrera->circuito->nombre }}</td>
                    <td>{{$carrera->puesto }}º</td>
                    @if ($carrera->vuelta_rapida == True)
                    <td class="bg-success">{{ $carrera->puntos }}</td>
                    @else
                    <td>{{ $carrera->puntos }}</td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
        @else
        <p>No ha realizado ninguna carrera todavía</p>
        @endif
    </div>
</div>


@endsection
