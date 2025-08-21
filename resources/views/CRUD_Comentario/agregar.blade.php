@extends('layout/plantilla')

@section("tituloPagina", "Crear un nuevo comentario")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear un Comentario</h5></div>

            <p class="card-text">
                <form action="{{ route("comentario.store")}}" method="POST">
                    @csrf
                    <label for="">Comentario</label>
                    <br>
                    <textarea name="comentario" id="comentario" cols="30" rows="10" required></textarea>
                    <label for="">Noticia</label>
                    <select name="noticia" id="noticia" required>
                        @foreach ($noticias as $noticia)
                            <option value="{{ $noticia->id }}">{{ $noticia->titulo }}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Crear</button>
                    <a href="{{ route("comentario.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection