@extends('layout/plantilla')

@section("tituloPagina", "Actualizar un comentario")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar una Comentario</h5></div>

            <p class="card-text">
                <form action="{{ route("comentario.update", $comentario->id)}}" method="POST">
                    @csrf
                    @method("PUT")
                    <label for="">Comentario</label>
                    <br>
                    <textarea name="comentario" id="comentario" cols="30" rows="10" required>{{ $comentario->comentario }}</textarea>
                    <label for="">Noticia</label>
                    <select name="noticia" id="noticia" required>
                        @foreach ($noticias as $noticia)
                            @if ($noticia->id == $comentario->id_noticia)
                                <option value="{{ $noticia->id }}" selected>{{ $noticia->titulo }}</option>
                            @else
                                <option value="{{ $noticia->id }}">{{ $noticia->titulo }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("comentario.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection