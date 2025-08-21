@extends('layout/plantilla')

@section('tituloPagina', 'Proyecto Integrado')

@section('contenido')
    <a class="btn btn-success" href="{{ route('admin') }}">Canales</a>
    <a class="btn btn-primary" href="{{ route('video.index') }}">Videos</a>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    @if ($mensaje = Session::get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ $mensaje }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-header"><h5 class="card-title">Listado de canales del Fantasy</h5>
                <a class="btn btn-primary" href="{{ route('canal.create') }}">Agregar</a>
            </div>
            <p class="card-text">
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Nombre</th>
                            <th>Enlace</th>
                            <th>Foto</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </thead>
                        <tbody>
                            @foreach ($canales as $canal )
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

                                <td>
                                    <form action="{{ route("canal.edit", $canal->id) }}" method="GET">
                                        <button class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route("canal.show", $canal->id) }}" method="GET">
                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </p>
        </div>
    </div>
@endsection