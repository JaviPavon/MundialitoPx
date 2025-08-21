@extends('layout/plantilla')

@section("tituloPagina", "Eliminar un video")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Eliminar un video</h5></div>

            <p class="card-text">
                <div class="alert alert-danger" role="alert">
                    ¿Estás seguro de eliminar este video?

                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Enlace</th>
                            <th>Fecha Publicación</th>
                            <th>Canal</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $video->nombre }}</td>
                            <td><a href="{{ $video->enlace }}">Enlace</a></td>
                            <td>{{ $video->fecha_publicacion }}</td>

                            @if ($video->canal)
                            <td>
                                {{ $video->canal->nombre }}
                            </td>
                            @else
                            <td>
                                No tiene vinculado canal
                            </td>
                            @endif

                        </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('video.destroy', $video->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a class="btn btn-primary" href=" {{ route('video.index') }} ">Volver</a>
                        <button class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </p>
           
        </div>
    </div>
@endsection