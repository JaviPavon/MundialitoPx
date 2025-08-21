@extends('layout/plantilla')

@section('tituloPagina', 'Crud con Laravel 8')

@section('contenido')
<a class="btn btn-primary" href="{{ route('pilotos.index') }}">Pilotos</a>
<a class="btn btn-primary" href="{{ route('escuderias.index') }}">Escuderias</a>
<a class="btn btn-primary" href="{{ route('paises.index') }}">Paises</a>
<a class="btn btn-primary" href="{{ route('circuitos.index') }}">Circuitos</a>
<a class="btn btn-success" href="{{ route('admin') }}">Carreras</a>
<a class="btn btn-primary" href="{{ route('noticias.index') }}">Noticias</a>
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
                @if ($mensaje = Session::get('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ $mensaje }}
                    </div>
                @endif
            </div>
        </div>
        <div class="card-header"><h5 class="card-title">Listado de Carreras</h5>
            <a class="btn btn-primary" href="{{ route('carreras.create') }}">Agregar</a>
        </div>
        <p class="card-text">
            <div id="tabla-carreras" class="table table-responsive">
                <table class="table table-sm">
                    <!-- Encabezados de la tabla -->
                    <thead>
                        <th>Puesto</th>
                        <th>Piloto</th>
                        <th>Puntos</th>
                        @foreach ($circuitos as $circuito)
                            <th>{{ $circuito->nombre }}
                                <a href="{{ route('carreras.edit', $circuito->id) }}">
                                    <button class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </a>
                                <a href="{{ route('carreras.show', $circuito->id) }}">
                                    <button class="btn btn-danger">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </a>
                            </th>
                        @endforeach
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody id="orden">
                        @foreach ($pilotos as $piloto)
                            <tr data-id="{{ $piloto->id }}">
                                <td>{{ $piloto->posicion }}</td>
                                <td>{{ $piloto->nombre }}</td>
                                <td>{{ $piloto->estado == 'DSQ' || $piloto->estado == 'DNF' ? $piloto->estado : $piloto->puntos }}</td>
                                @foreach ($circuitos as $circuito)
                                    @php
                                        $carrera = $carreras->where('id_piloto', $piloto->id)->where('id_circuito', $circuito->id)->first();
                                    @endphp
                                    @if ($carrera)
                                        @php
                                            $fontColor = $carrera->vuelta_rapida ? 'color: green;' : '';
                                        @endphp
                                        <td style="{{ $fontColor }}">
                                            {{ $carrera->estado == 'DSQ' || $carrera->estado == 'DNF' ? $carrera->estado : $carrera->puntos }}
                                        </td>
                                    @else
                                        <td>NJ</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </p>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    new Sortable(document.getElementById('orden'), {
        animation: 250,
        ghostClass: 'table-info',
        store: {
            set: function (sortable) {
                const sorts = sortable.toArray();

                // Llamada Axios para enviar los datos al servidor
                axios.post("{{ route('api.sort.puestos') }}", {
                    sorts: sorts
                })
                .then(function (response) {
                    // Redirigir a la página actual después de completar la ordenación
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error); // Manejar errores si la solicitud falla
                });
            }
        }
    });
</script>
@endpush

@endsection
