@extends('layout/plantilla')

@section("tituloPagina", "Actualizar Fantasy")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar Fantasy</h5></div>

            <p class="card-text">
                <form action="{{ route("fantasy.update")}}" method="POST">
                    @csrf
                    @method("PUT")
                    <label for="">Circuito</label>
                    <select name="circuito" id="circuito" required>
                        @foreach ($circuitos as $circuito)
                            @if ($circuito->id == $fantasy->siguiente_circuito)
                                <option value="{{ $circuito->id }}" selected>{{ $circuito->nombre }}</option>
                            @else
                                <option value="{{ $circuito->id }}">{{ $circuito->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("fantasy.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>

@endsection