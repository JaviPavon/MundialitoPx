@extends('layout/plantilla')

@section("tituloPagina", "Eliminar un piloto")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar un piloto</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar este piloto?

                    <table class="table table-sm table-hover">
                        <thead>
                            <th>Posicion</th>
                            <th>Nombre</th>
                            <th>Dorsal</th>
                            <th>Biografia</th>
                            <th>Puntos</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $pilotos-> posicion }}</td>
                                <td>{{ $pilotos-> nombre }}</td>
                                <td>{{ $pilotos-> dorsal }}</td>
                                <td>{{ $pilotos-> biografia }}</td>
                                <td>{{ $pilotos-> puntos }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('pilotos.destroy', $pilotos->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('pilotos.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection