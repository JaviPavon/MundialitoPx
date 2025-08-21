@extends('layout/plantilla')

@section("tituloPagina", "Eliminar un Pais")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar un pais</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar este pais?

                    <table class="table table-sm table-hover">
                        <thead>
                            <th>ID</th>
                            <th>Nombre</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $pais-> id }}</td>
                                <td>{{ $pais-> nombre }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('paises.destroy', $pais->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('paises.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection