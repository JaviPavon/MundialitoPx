@extends('layout/plantilla')

@section("tituloPagina", "Actualizar una Noticia")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar una Noticia</h5></div>

            <p class="card-text">
                <form action="{{ route("noticias.update", $noticias->id)}}" method="POST">
                    @csrf
                    @method("PUT")
                    <label for="">Título</label>
                    <input type="text" name="titulo" class="form-control" required value="{{ $noticias->titulo }}">
                    <label for="">Cuerpo</label>
                    <br>
                    <textarea name="cuerpo" id="cuerpo" cols="30" rows="10" required>{{ $noticias->cuerpo }}</textarea>
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("noticias.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection