@extends('layout/plantilla')

@section("tituloPagina", "Actualizar valor piloto")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar valor piloto</h5></div>

            <p class="card-text">
                <form action="{{ route("pilotos_juego.update", $piloto->id)}}" method="POST">
                    @csrf
                    @method("PUT")
                    <label for="">Valor</label>
                    <input type="number" name="valor" class="form-control" required value="{{$piloto->valor}}">
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("pilotos.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection