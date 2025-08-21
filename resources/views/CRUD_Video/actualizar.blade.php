@extends('layout/plantilla')

@section("tituloPagina", "Actualizar un video")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar un Video</h5></div>

            <p class="card-text">
                <form action="{{ route("video.update", $video->id)}}" method="POST">
                    @csrf
                    @method("PUT")
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{$video -> nombre}}">
                    <label for="">Enlace</label>
                    <input type="text" name="enlace" class="form-control" required value="{{$video -> enlace}}">
                    <label for="">Fecha de Publicación</label>
                    <input type="date" name="fecha_publicacion" class="form-control" required value="{{$video -> fecha_publicacion}}">
                    <br>
                    <label for="">Canal</label>
                    <select name="canal" id="canal" required>
                        @foreach ($canales as $canal)
                            @if ($canal->id == $video->id_canal)
                                <option value="{{ $canal->id }}" selected>{{ $canal->nombre }}</option>
                            @else
                                <option value="{{ $canal->id }}">{{ $canal->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("video.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection