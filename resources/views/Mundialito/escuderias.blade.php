@extends('Mundialito/plantilla')

@section('tituloPagina', 'Escuderias Paxangars')

@section('contenido')

<div class="row pt-3 justify-content-center text-center">
    <div class="col-12 col-lg-4 sticky-left">
        <h2>Clasificación</h2>
        <div class="row pt-3 ">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-bordered table-responsive justify-content-center align-items-center text-center">
                    <tr class="table-dark">
                        <th>Posición</th>
                        <th>Nombre</th>
                        <th>Puntos</th>
                    </tr>
                    @foreach ($escuderiasc as $escuderia)
                    <tr>
                        <td class="table-secondary">{{$escuderia->posicion}}º</td>
                        <td>{{$escuderia->nombre}}</td>
                        <td class="table-warning">{{$escuderia->puntos}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <h2>Escuderias</h2>
        <div class="row escuderias pt-3">
            @foreach ($escuderias as $escuderia)
            <div class="col-12">
                <a href="{{ route('mundialito.escuderia', $escuderia->id) }}">
                    <div class="position-relative">
                        <img class="object-fit-fill border rounded img-fluid" src="/monoplazas/{{ $escuderia->monoplaza }}" alt="">
                        <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                            <div class="row">
                                <div class="col-12">
                                    <h3>{{ $escuderia->nombre }}</h3>
                                    <h3>{{ $escuderia->puntos }}pts</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Incluye los archivos de Slick -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!-- Inicializa Slick -->
<script>
    $(document).ready(function(){
        $('.escuderias').slick({
            slidesToShow: 3,
            slidesToScroll: 2,
            arrows: true,
            vertical: true,
            centerMode: false,
            focusOnSelect: true,
            autoplay: true,
            autoplaySpeed: 1500,
            touchMove: true
        });
    });
</script>

@endsection
