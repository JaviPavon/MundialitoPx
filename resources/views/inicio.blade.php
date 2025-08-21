@extends('layout/plantilla')

@section('tituloPagina', 'Mundialito Paxangars') 
@section('contenido')

<div class="row">
<div class="col-10">
    <a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
    <a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
    <a class="btn btn-primary" href="{{ route('paises.index') }}">Paises</a>
    <a class="btn btn-primary" href="{{ route('circuitos.index') }}">Circuitos</a>
    <a class="btn btn-primary" href="{{ route('carreras.index') }}">Carreras</a>
    <a class="btn btn-primary" href="{{ route('noticias.index') }}">Noticias</a>
    @if (Auth::check() && Auth::user()->role === 'admin')
        <a class="" style="text-decoration: none" href="{{ route('fantasy.index') }}">
            <button class="carbutton">
                <div class="caption">Fantasy</div>
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car"><path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"></path></svg>
            </button>
        </a>
    @endif
    <a class="btn btn-primary" href="{{ route('canal.index') }}">Canales</a>
    <a class="btn btn-warning" href="{{ route('index') }}">Página principal</a>
</div>

<div class="col-2">
<div class="row">
    @if (Auth::check())
        <!-- El usuario está autenticado -->
        <div class="col-6 text-center align-items-center">
            <span>Bienvenido {{ Auth::user()->name }}!</span>
        </div>
        <div class="col-6">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Cerrar Sesión</button>
            </form>
        </div>
    @else
        <!-- El usuario no está autenticado -->
        <div class="col-4">
            <a class="btn btn-primary" href="{{ route('login') }}">Iniciar Sesión</a>
        </div>
        <div class="col-3">
            <a class="btn btn-primary" href="{{ route('register') }}">Registrarse</a>
        </div>
    @endif
</div>
</div>
</div>


<hr>
@endsection
