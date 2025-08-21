@extends('layout/plantilla')

@section("tituloPagina", "Eliminar una Escuderia")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar una escuderia</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar esta escuderia?

                    <table class="table table-sm">
                        <thead>
                            <th>Posicion</th>
                            <th>Nombre</th>
                            <th>Alias</th>
                            <th>Descripción</th>
                            <th>Puntos</th>
                            <th>Pais</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $escuderias->posicion }}º</td>
                                <td>{{ $escuderias->nombre }}</td>
                                <td>{{ $escuderias->alias }}</td>
                                <td>{{ $escuderias->descripcion }}</td>
                                <td>{{ $escuderias->puntos }}</td>
                                @if ($escuderias->pais)
                                    <td>{{ $escuderias->pais->nombre }}</td>
                                @else
                                    <td>No hay Pais</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('escuderias.destroy', $escuderias->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('escuderias.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection