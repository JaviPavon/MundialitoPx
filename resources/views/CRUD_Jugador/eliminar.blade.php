@extends('layout/plantilla')

@section("tituloPagina", "Eliminar una noticia")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar una noticia</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar esta noticia?

                    <table class="table table-sm">
                    <thead>
                            <th>Título</th>
                            <th>Cuerpo</th>
                            <th>Fecha de Publicación</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $noticias->titulo }}</td>
                                <td>{{ $noticias->cuerpo }}</td>
                                <td>{{ $noticias->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('noticias.destroy', $noticias->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('noticias.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </p>
        </div>
    </div>
@endsection