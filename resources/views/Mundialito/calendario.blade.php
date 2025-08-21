@extends('Mundialito/plantilla')

@section('tituloPagina', 'Calendario Paxangars')

@section('contenido')
<br>
<div class="calendario-container pb-5">
    <!-- Carrusel solo visible en pantallas grandes -->
    
        <div class="slider-circuitos d-none d-xl-block">
                @foreach ($circuitos as $circuitoItem)
                    <div class="circuito-div">
                    @if ($fantasy->siguiente_circuito == $circuitoItem->id)
                    <li class="splide__slide " data-id="{{ $circuitoItem->id }}">
                        <div class="position-relative">
                            <img class="position-absolute top-0 start-0 img-fluid" src="/banderas/{{ $circuitoItem->pais->bandera }}" alt="">
                            <img src="/circuitos/{{ $circuitoItem->circuito }}" alt="" class="img-fluid" style="width: 96px; height: 56px;">
                        </div>
                    </li>
                    @else
                    <li class="splide__slide" data-id="{{ $circuitoItem->id }}">
                        <div class="position-relative">
                            <img class="position-absolute top-0 start-0 img-fluid" src="/banderas/{{ $circuitoItem->pais->bandera }}" alt="">
                            <img src="/circuitos/{{ $circuitoItem->circuito }}" alt="" class="img-fluid" style="width: 96px; height: 56px;">
                        </div>
                    </li>
                    @endif
                    </div>
                @endforeach
        </div>

    <!-- Select visible solo en pantallas pequeñas -->
    <div class="d-block d-xl-none pb-4">
        <select id="circuito-select" class="form-select" aria-label="Seleccionar circuito">
            @foreach ($circuitos as $circuitoItem)
                <option value="{{ $circuitoItem->id }}" {{ $circuito->id == $circuitoItem->id ? 'selected' : '' }}>
                    {{ $circuitoItem->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="card shadow card-calendario mt-4 pb-3">
    <div class="card-body">
        <div class="row g-5">
            <div class="col-12 col-lg-5">
                <div class="row g-4 p-4">
                    <div class="col-12">
                        @if ($circuito->id == $fantasy->siguiente_circuito)
                            <button type="button" class="btn btn-outline-warning w-100">Siguiente Carrera</button>
                        @elseif (count($carreras) > 0)
                            <button type="button" class="btn btn-outline-danger w-100">Carrera Finalizada</button>
                        @else
                            <button type="button" class="btn btn-outline-success w-100">Próximamente...</button>
                        @endif
                    </div>
                    <div class="col-2">
                        <img class="img-bandera shadow img-fluid" src="/banderas/{{ $circuito->pais->bandera }}" style="min-width: 55px;" alt="{{ $circuito->pais->nombre }}">
                    </div>
                    <div class="col-8 offset-2 offset-sm-0 col-sm-10">
                        <h5 class="card-title">{{ $circuito->pais->nombre }}</h5>
                    </div>
                    <div class="col-12">
                        <h2>{{ $circuito->nombre }}</h2>
                    </div>
                    @php
                        \Carbon\Carbon::setLocale('es');
                        $originalDate = $circuito->fecha_circuito;
                        $formattedDate = \Carbon\Carbon::parse($originalDate)->translatedFormat('d \d\e F \d\e Y');
                        $currentDate = \Carbon\Carbon::now();
                        if (\Carbon\Carbon::parse($originalDate)->isToday()) {
                            $dateClass = 'fecha-hoy';
                        } elseif (\Carbon\Carbon::parse($originalDate)->isPast()) {
                            $dateClass = 'fecha-pasada';
                        } else {
                            $dateClass = 'fecha-futura';
                        }
                    @endphp

                    <div class="col-12 pt-3">
                        <h4 class="{{ $dateClass }}">{{ $formattedDate }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7 justify-content-center align-items-center">
                <div class="row d-flex flex-column justify-content-center align-items-center">
                    <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                        <article class="pt-3 d-flex flex-column align-items-center">
                            <img class="circuito img-fluid" src="/circuitos/{{ $circuito->circuito }}" alt="">
                            <img class="silueta img-fluid" src="/siluetas/{{ $circuito->silueta }}" alt="">
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@if (count($carreras) > 0)
    <h2>Repeticiones</h2>
    <div class="row pb-5">
        @foreach ($videos as $video )
        <a href="{{$video->enlace}}" class="text-decoration-none">
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="/fotos/{{ $video->canal->piloto->foto }}" alt="" class="img-fluid" style="height: 100%; width: auto; border-radius: 10%;">
                            </div>
                            <div class="col-8">
                                <div class="row text-center pt-2">
                                    <div class="col">
                                        <h3>{{ $video->canal->nombre }}</h3>
                                    </div>
                                    <div class="col pt-2">
                                        {{ $video->nombre }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
@endif

@if (count($carreras) > 0)
    <h2>Resultado pilotos en carrera</h2>
    <div class="card shadow">
        <div class="card-body slider justify-content-center align-items-center flex-wrap">
            @foreach ($carreras as $index => $carrera)
                <div class="piloto text-center d-flex flex-column align-items-center">
                    <img class="img-200 img-fluid" src="/fotos/{{ $carrera->piloto->foto }}" alt="{{ $carrera->piloto->nombre }}" style="border-radius:10%;">
                    <div class="piloto-info text-center">
                        <p class="clasificacion-num">{{ $index + 1 }}</p>
                        <h2 class="nombre-piloto">{{ $carrera->piloto->nombre }}</h2>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
<h2>Pilotos por posición</h2>
<div class="card shadow">
    <div class="card-body slider justify-content-center align-items-center flex-wrap">
        @foreach ($pilotos as $index => $piloto)
            <div class="piloto text-center d-flex flex-column align-items-center">
                <img class="img-200 img-fluid" src="/fotos/{{ $piloto->foto }}" alt="{{ $piloto->nombre }}" style="border-radius: 10px;">
                <div class="piloto-info text-center">
                    <p class="clasificacion-num">{{ $index + 1 }}</p>
                    <h2 class="nombre-piloto">{{ $piloto->nombre }}</h2>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<script>
    $(document).ready(function () {
        $('.splide__slide').click(function() {
            var circuitoId = $(this).data('id');
            window.location.href = "{{ route('mundialito.calendario') }}" + "/" + circuitoId;
        });

        $('#circuito-select').change(function() {
            var circuitoId = $(this).val();
            window.location.href = "{{ route('mundialito.calendario') }}" + "/" + circuitoId;
        });
    });
    $('.slider-circuitos').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 12,
        slidesToScroll: 4,
        responsive: [
            {
            breakpoint: 1400,
            settings: {
                slidesToShow: 10,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
        ]
        });
        $(document).ready(function () {
        $('.slider').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            prevArrow: '<button type="button" class="slick-prev" style="color: red;">Previous</button>',
            nextArrow: '<button type="button" class="slick-next" style="color: red;">Next</button>',
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>

@endsection
