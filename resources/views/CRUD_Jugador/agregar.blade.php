@extends('layout.plantilla')

@section("tituloPagina", "Crear un nuevo jugador")

@section('contenido')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                @if ($mensaje = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ $mensaje }}
                    </div>
                @endif
            </div>
        </div>
        <div class="card-header"><h5 class="card-title">¿Quieres unirte a esta Liga?</h5></div>


        <p class="card-text">
            <form action="{{ route("jugador.store", $liga->id)}}" method="POST">
                @csrf
                <h2>{{ $liga->nombre }}</h2>

                @if ($liga->estado == 'privada')
                <label for="contraseña">Contraseña</label>
                <br>
                <input type="password" name="contraseña" class="form-control" id="contraseña" required>
                <br>
                @endif

                <br>
                <div class="table table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Puesto</th>
                            <th>Nombre Usuario</th>
                            <th>Puntos</th>
                        </thead>
                        <tbody>
                            @foreach ($jugadores as $jugador)
                                <tr>
                                    <td>{{ $jugador->puesto }}º</td>
                                    <td>{{ $jugador->usuario->name }}</td>
                                    <td>{{ $jugador->puntos }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-primary">Unirse</button>
                <a href="{{ route("liga.index") }}" class="btn btn-info">Volver</a>
            </form>
        </p>
    </div>
</div>
@endsection
