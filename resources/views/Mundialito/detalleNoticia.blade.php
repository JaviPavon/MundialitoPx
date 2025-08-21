@extends('Mundialito.plantilla')

@section('tituloPagina', 'Noticia Paxangars')

@section('contenido')
@php
    use Carbon\Carbon;
    Carbon::setLocale('es');
@endphp
<div class="row pt-3 d-flex justify-content-center align-items-center text-center">
    <div class="col-10 pt-4">
        <div class="row g-3">
            @if ($noticia->circuito)
            <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
                <div class="card tema">
                    <div class="card-body">
                        <h3>{{ $noticia->circuito }}</h3>
                    </div>
                </div>
            </div>
            @endif
            @if ($noticia->escuderias->count() > 0)
                @foreach ($escuderiasRelacionadas as $escuderia)
                <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
                    <a class="text-decoration-none" href="{{ route('mundialito.escuderia', $escuderia->id_escuderia) }}">
                        <div class="card tema">
                            <div class="card-body ">
                                <h5>{{ $escuderia->escuderia->nombre }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
            @if ($noticia->pilotos->count() > 0)
                @foreach ($pilotosRelacionados as $piloto)
                <div class="col-12 col-sm-6 col-lg-4 col-xxl-2">
                    <a class="text-decoration-none" href="{{ route('mundialito.piloto', $piloto->id_piloto) }}">
                        <div class="card tema">
                            <div class="card-body">
                                <h5>{{ $piloto->piloto->nombre }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-10 pt-4">
        <h2 class="text-start">{{ $noticia->titulo }}</h2>
        <h4 class="text-start">{{ $noticia->subtitulo }}</h4>
    </div>
    <div class="col-10 text-start pt-3">
        <p class="m-0">
            <b>{{ $noticia->usuario->name }}</b> 
            &#x2022; 
            {{ Carbon::parse($noticia->created_at)->diffForHumans() }}
        </p>
    </div>
    <div class="col-10">
        <img class="img-noticia border border-5" src="/miniaturas/{{ $noticia->miniatura }}" alt="">
    </div>
</div>
<div class="row d-flex justify-content-center pt-3">
    <div class="text-start noticia col-10 pt-2">
        <h5>{{ $noticia->cuerpo }}</h5>
    </div>
</div>
<div class="row mb-5 justify-content-center align-items-center text-center">
    @if (Auth::check())
        <div class="col-10 col-lg-8 pb-3">
            <div class="row align-items-center">
                <div class="col-1">
                    @if (Auth::user()->profile_image)
                        <img src="/profile_image/{{ Auth::user()->profile_image}}" alt="foto-perfil" width="50" height="50" class="rounded-circle border border-3">
                    @else
                        <img src="{{ asset('recursos-PI/driver.png') }}" alt="foto-perfil" width="50" height="50" class="rounded-circle border border-3">
                    @endif
                
                </div>
                <div class="col-9 col-lg-11 offset-1 offset-lg-0 text-start">
                    <p class="m-0">
                        <b>{{ $noticia->usuario->name }}</b> 
                    </p>
                    <form action="{{ route("mundialito.comentario", $noticia->id)}}" method="POST">
                        @csrf
                            <div class="position-relative">
                                <textarea name="comentario" id="comentario" cols="30" rows="3" required class="form-control"></textarea>
                                <div class="position-absolute bottom-0 end-0">
                                    <button class="btn btn-secondary"><i class="bi bi-send"></i></button>
                                </div>
                            </div>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <div class="col-12">
        @foreach ($comentarios as $comentario)
        <div class="row d-flex justify-content-center">
            <div class="col-11 col-sm-10 col-md-6">
                <div class="row pt-3">
                    <div class="col-2">
                        @if ($comentario->usuario->profile_image)
                            <img src="/profile_image/{{ $comentario->usuario->profile_image}}" alt="foto-perfil" width="50" height="50" class="rounded-circle border border-3">
                        @else
                            <img src="{{ asset('recursos-PI/driver.png') }}" alt="foto-perfil" width="50" height="50" class="rounded-circle border border-3">
                        @endif
                    </div>
                    <div class="col-10">
                        <div class="row text-start">
                            <div class="col-12">
                                <p class="m-0">
                                    <b>{{ $comentario->usuario->name }}</b> 
                                    &#x2022; 
                                    {{ Carbon::parse($comentario->created_at)->diffForHumans() }}
                                </p>
                            </div>
                            <div class="col-12">
                                <p>{{ $comentario->comentario }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<style>
    .img-noticia {
    width: 100%;
}
.tema{
    background-color: #1e1e23;
    color: #EAEAEA;
}
</style>
@endsection
