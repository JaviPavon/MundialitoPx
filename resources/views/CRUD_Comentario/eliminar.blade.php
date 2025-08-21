@extends('layout/plantilla')

@section("tituloPagina", "Eliminar un comentario")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar un comentario</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar este comentario?

                    <table class="table table-sm">
                    <thead>
                            <th>Noticia</th>
                            <th>Comentario</th>
                            <th>Fecha de Publicación</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $comentario->id_noticia }}</td>
                                <td>{{ $comentario->comentario }}</td>
                                <td>{{ $comentario->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('comentario.destroy', $comentario->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('comentario.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </p>
        </div>
    </div>
@endsection