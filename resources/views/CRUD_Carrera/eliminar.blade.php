@extends('layout/plantilla')

@section("tituloPagina", "Eliminar una carrera")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar carreras</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar las carreras de {{ $circuito->nombre }}?

                    <form action="{{ route('carreras.destroy', $circuito->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('carreras.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection