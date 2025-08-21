@extends('layout/plantilla')

@section("tituloPagina", "Eliminar un canal")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar un canal</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar este canal?

                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Enlace</th>
                            <th>Foto</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $canal->nombre }}</td>
                            <td><a href="{{ $canal->enlace }}">Enlace</a></td>

                            @if ($canal->piloto)
                            <td>
                                <img src="/fotos/{{ $canal->piloto->foto}}" width="15%">
                            </td>
                            @else
                            <td>
                                No tiene vinculado piloto
                            </td>
                            @endif

                        </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('canal.destroy', $canal->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('canal.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection