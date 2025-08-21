@extends('Mundialito/plantilla')

@section('tituloPagina', 'Noticias Paxangars')

@section('contenido')
    <br>
    @php
        use Carbon\Carbon;
        Carbon::setLocale('es');
    @endphp
    <div class="noticias-container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12">
                <div class="row justify-content-center align-items-start">
                    <div class="col-10">
                        <div class="slider-for">
                            @foreach ($noticias as $noticia)
                            <div>
                                <a href="{{ route('mundialito.noticia', $noticia->id) }}">
                                    <img class="border border-dark-subtle border-3" src="/miniaturas/{{ $noticia->miniatura }}" alt="">
                                    <p class="m-0">{{ $noticia->usuario->name }} &#x2022; {{ Carbon::parse($noticia->created_at)->diffForHumans() }}</p>
                                    <h2 class="pt-1"><b>{{ $noticia->titulo }}</b></h2>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-2 d-none d-xxl-block">
                        <div class="slider-nav">
                            @foreach ($noticias as $noticia)
                            <div>
                                <img class="img-200 border border-dark-subtle border-3" src="/miniaturas/{{ $noticia->miniatura }}" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 pt-5">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="{{ route('mundialito.noticias') }}" class="form-inline">
                            <div class="row align-items-end">
                                <div class="col-12 col-lg-3">
                                    <label for="piloto" class="mr-2">Piloto</label>
                                    <select name="piloto" id="piloto" class="form-control">
                                        <option value="">Todos los Pilotos</option>
                                        @foreach ($pilotos as $piloto)
                                            <option value="{{ $piloto->id }}" {{ request('piloto') == $piloto->id ? 'selected' : '' }}>{{ $piloto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="escuderia" class="mr-2">Escudería</label>
                                    <select name="escuderia" id="escuderia" class="form-control">
                                        <option value="">Todas las Escuderías</option>
                                        @foreach ($escuderias as $escuderia)
                                            <option value="{{ $escuderia->id }}" {{ request('escuderia') == $escuderia->id ? 'selected' : '' }}>{{ $escuderia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="circuito" class="mr-2">Circuito</label>
                                    <select name="circuito" id="circuito" class="form-control">
                                        <option value="">Todos los Circuitos</option>
                                        @foreach ($circuitos as $circuito)
                                            <option value="{{ $circuito->id }}" {{ request('circuito') == $circuito->id ? 'selected' : '' }}>{{ $circuito->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row pt-3">
                    <h2>Noticias Populares</h2>
                    <p>
                        @if($filtroPiloto)
                            <span class="">Piloto: {{ $filtroPiloto->nombre }}</span>
                        @endif
                        @if($filtroEscuderia)
                            <span class="">Escudería: {{ $filtroEscuderia->nombre }}</span>
                        @endif
                        @if($filtroCircuito)
                            <span class="">Circuito: {{ $filtroCircuito->nombre }}</span>
                        @endif
                    </p>
                    @foreach ($noticiasPopulares as $index => $noticia )
                        <div class="col-12 col-sm-6 col-lg-3 pb-3">
                            <a href="{{ route('mundialito.noticia', $noticia->id) }}">
                                <img class="img-fluid" src="/miniaturas/{{ $noticia->miniatura }}" alt="" style="width: 100%;">
                                <p class="m-0">{{ $noticia->usuario->name }} &#x2022; {{ Carbon::parse($noticia->created_at)->diffForHumans() }}</p>
                                <h5>{{ $noticia->titulo }}</h5>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav',
                autoplay: true,
                autoplaySpeed: 2000
            });
            $('.slider-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 2,
                asNavFor: '.slider-for',
                vertical: true,
                arrows: false,
                centerMode: false,
                focusOnSelect: true
            });
        });
    </script>
    <style>
        .slider-for img {
            width: 95.5%;
            height: auto;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
@endsection
