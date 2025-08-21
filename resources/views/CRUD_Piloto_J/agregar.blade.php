@extends('layout/plantilla')

@section("tituloPagina", "Crear un nuevo piloto")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Sincronizar Pilotos</h5></div>

            <p class="card-text">
                <form action="{{ route("pilotos_juego.store")}}" method="POST" >
                    @csrf
                    <h2>Pilotos que se crean</h2>
                    <p>{{$pilotosSeCrean->count()}}</p>
                    <div class="table table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <th>Nombre</th>
                                <th>Puntos</th>
                                <th>Valor</th>
                                <th>Foto</th>
                            </thead>
                            <tbody>
                                @foreach ($pilotosSeCrean as $piloto )
                                <tr>
                                    <td>{{ $piloto->nombre }}</td>
                                    <td>{{ $piloto->puntos }}</td>
                                    <td>Por establecer</td>
    
                                    @if ($piloto->foto)
                                        <td>
                                            <img src="/fotos/{{ $piloto->foto}}" width="15%">
                                        </td>
                                    @else
                                        <td>El Piloto no tiene Foto</td>
                                    @endif
                                </tr>
                                <input type="hidden" name="pilotos_ids[]" value="{{ $piloto->id }}">
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h2>Pilotos que se borran</h2>
                    <p>{{$pilotosSeBorran->count()}}</p>
                    <div class="table table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <th>Nombre</th>
                                <th>Puntos</th>
                                <th>Valor</th>
                                <th>Foto</th>
                            </thead>
                            <tbody>
                                @foreach ($pilotosSeBorran as $piloto )
                                <tr>
                                    @if ($piloto->piloto)
                                    <td>{{ $piloto->piloto->nombre }}</td>
                                    @else
                                    <td>No existe este piloto</td>
                                    @endif
                                    <td>{{ $piloto->puntos }}</td>
                                    <td>{{ $piloto->valor }}</td>
    
                                    @if ($piloto->piloto)
                                        <td>
                                            <img class="img-200" src="/fotos/{{ $piloto->piloto->foto}}" width="15%">
                                        </td>
                                    @else
                                        <td>El Piloto no tiene Foto</td>
                                    @endif
                                </tr>
                                
                                <input type="hidden" name="pilotos_ids_borrar[]" value="{{ $piloto->id }}">
    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary">Sincronizar</button>
                    <a href="{{ route("pilotos_juego.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
@endsection