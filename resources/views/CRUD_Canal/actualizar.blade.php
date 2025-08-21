@extends('layout/plantilla')

@section("tituloPagina", "Actualizar un piloto")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar un piloto</h5></div>

            <p class="card-text">
                <form action="{{ route("canal.update", $canal->id)}}" method="POST">
                    @csrf
                    @method("PUT")
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{$canal -> nombre}}">
                    <label for="">Enlace</label>
                    <input type="text" name="enlace" class="form-control" required value="{{$canal -> enlace}}">
                    <br>
                    <label for="">Piloto</label>
                    <select name="piloto" id="piloto" required>
                        @foreach ($pilotos as $piloto)
                            @if ($piloto->id == $canal->id_piloto)
                                <option value="{{ $piloto->id }}" selected>{{ $piloto->nombre }}</option>
                            @else
                                <option value="{{ $piloto->id }}">{{ $piloto->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("canal.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection