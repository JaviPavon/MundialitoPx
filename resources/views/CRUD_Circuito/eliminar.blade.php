@extends('layout/plantilla')

@section("tituloPagina", "Eliminar un circuito")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar un circuito</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar este circuito?

                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Alias</th>
                            <th>Pais</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $circuitos->nombre }}</td>
                                <td>{{ $circuitos->alias }}</td>
                                @if ($circuitos->pais)
                                    <td>{{ $circuitos->pais->nombre }}</td>
                                @else
                                    <td>No hay Pais</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('circuitos.destroy', $circuitos->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('circuitos.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection