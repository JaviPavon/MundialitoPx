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
                            <th>Pilotos Relacionados</th>
                            <th>Escuderias Relacionadas</th>
                            <th>Circuito Relacionado</th>
                            <th>Fecha de Publicación</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $noticia->titulo }}</td>
                                <td>{{ $noticia->cuerpo }}</td>
                                @if ( count($noticia->pilotos) > 0 )
                                    <td>
                                        @foreach ($noticia->pilotos as $piloto)
                                            {{$piloto->nombre}}
                                        @endforeach
                                    </td>
                                @else
                                    <td>No tiene pilotos relacionados esta noticia</td>
                                @endif

                                @if ( count($noticia->escuderias) > 0 )
                                    <td>
                                        @foreach ($noticia->escuderias as $escuderia)
                                            {{$escuderia->nombre}}
                                        @endforeach
                                    </td>
                                @else
                                    <td>No tiene escuderias relacionadas esta noticia</td>
                                @endif

                                @if ( $noticia->circuito )
                                    <td>{{$noticia->circuito->nombre}}</td>
                                @else
                                    <td>No tiene circuito relacionado esta noticia</td>
                                @endif

                                <td>{{ $noticia->created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form action="{{ route('noticias.destroy', $noticia->id) }}" method="POST">
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