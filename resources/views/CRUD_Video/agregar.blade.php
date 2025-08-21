@extends('layout/plantilla')

@section("tituloPagina", "Crear un nuevo video")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear un video</h5></div>

            <p class="card-text">
                <form action="{{ route("video.store")}}" method="POST">
                    @csrf
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                    <label for="">Enlace</label>
                    <input type="text" name="enlace" class="form-control" required>
                    <label for="">Fecha de Publicación</label>
                    <input type="date" name="fecha_publicacion" class="form-control" required>
                    <br>
                    <label for="">Canales</label>
                    <select name="canal" id="canal" required>
                        @foreach ($canales as $canal)
                            <option value="{{ $canal->id }}">{{ $canal->nombre }}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Crear</button>
                    <a href="{{ route("video.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection