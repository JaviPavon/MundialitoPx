@extends('layout/plantilla')

@section("tituloPagina", "Crear un nuevo canal")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear un canal</h5></div>

            <p class="card-text">
                <form action="{{ route("canal.store")}}" method="POST">
                    @csrf
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                    <label for="">Enlace</label>
                    <input type="text" name="enlace" class="form-control" required>
                    <br>
                    <label for="">Piloto</label>
                    <select name="piloto" id="piloto" required>
                        @foreach ($pilotos as $piloto)
                            <option value="{{ $piloto->id }}">{{ $piloto->nombre }}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Crear</button>
                    <a href="{{ route("canal.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection