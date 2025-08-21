@extends('layout/plantilla')

@section('tituloPagina', 'Crud con Laravel 8')

@section('contenido')
    @if (Auth::check() && Auth::user()->role === 'admin')
        <a class="" style="text-decoration: none" href="{{ route('fantasy.index') }}">
            <button class="carbutton">
                <div class="caption">Fantasy</div>
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car"><path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"></path></svg>
            </button>
        </a>
        <a class="btn btn-primary" href="{{ route('pilotos_juego.index') }}">Pilotos Fantasy</a>
        <a class="btn btn-success" href="{{ route('admin') }}">Jornada</a>
    @endif
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
            <br>
            <label for="">Circuito</label>
            <form action="{{ route('jornada.store') }}" method="POST">
                @csrf
                <select class="form-select" name="circuito" id="circuito" required>
                    @foreach ($circuitos as $circuito)
                    @if ($circuito->id == $fantasy->siguiente_circuito)
                                <option value="{{ $circuito->id }}" selected>{{ $circuito->nombre }}</option>
                            @else
                                <option value="{{ $circuito->id }}">{{ $circuito->nombre }}</option>
                            @endif
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Crear Jornada Circuito</button>
            </form>
        
            <br>
            <form action="{{ route('jornada.edit') }}" method="GET">
                @csrf
                <input type="hidden" name="circuito_id" id="circuito_id">
                <button type="submit" class="btn btn-primary">Editar Jornada</button>
            </form>
        </div>
        <p class="card-text">
            <div id="tabla-carreras" class="table table-responsive">
                <table class="table table-sm">
                    <!-- Encabezados de la tabla -->
                    <thead>
                        <th>Puesto</th>
                        <th>Piloto</th>
                        <th>Q1->Q2</th>
                        <th>Q2->Q3</th>
                        <th>Adelantamientos</th>
                        <th>Sanciones de 3 segundos</th>
                        <th>Sanciones de 5 segundos</th>
                        <th>Amonestaciones</th>
                        <th>Puntos</th>
                        
                    </thead>
                    <!-- Cuerpo de la tabla -->
                    <tbody id="orden">
                        @foreach ($jornadas as $jornada)
                            <tr data-id="{{ $jornada->id }}">
                                <td>{{ $jornada->puesto }}</td>
                                <td>{{ $jornada->piloto_juego->piloto->nombre }}</td>
                                @if ($jornada->qually2 == 1)
                                    <td><i class="bi bi-check"></i></td>
                                @else
                                    <td><i class="bi bi-x"></i></td>
                                @endif
                                @if ($jornada->qually3 == 1)
                                    <td><i class="bi bi-check"></i></td>
                                @else
                                    <td><i class="bi bi-x"></i></td>
                                @endif
                                <td>{{ $jornada->adelantamientos }}</td>
                                <td>{{ $jornada->sancion3sec }}</td>
                                <td>{{ $jornada->sancion5sec }}</td>
                                <td>{{ $jornada->amonestaciones }}</td>
                                <td>{{ $jornada->puntos }}pts</td>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Definir una función para cargar las jornadas por circuito
    function cargarJornadasPorCircuito() {
        var circuitoId = document.getElementById('circuito').value;

        axios.get("{{ route('jornada.jornadas_por_circuito') }}", {
                params: {
                    circuitoId: circuitoId
                }
            })
            .then(function (response) {
                // Limpiar la tabla antes de agregar nuevas filas
                document.getElementById('orden').innerHTML = '';

                // Iterar sobre las jornadas recibidas y agregarlas a la tabla
                response.data.jornadas.forEach(function (jornada) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${jornada.puesto}</td>
                        <td>${jornada.piloto_juego.piloto.nombre}</td>
                        <td>${jornada.qually2 ? '<i class="bi bi-check"></i>' : '<i class="bi bi-x"></i>'}</td>
                        <td>${jornada.qually3 ? '<i class="bi bi-check"></i>' : '<i class="bi bi-x"></i>'}</td>
                        <td>${jornada.adelantamientos}</td>
                        <td>${jornada.sancion3sec}</td>
                        <td>${jornada.sancion5sec}</td>
                        <td>${jornada.amonestaciones}</td>
                        <td>${jornada.puntos}pts</td>
                    `;
                    document.getElementById('orden').appendChild(row);
                });
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    // Llamar a la función al cargar el DOM y al cambiar la selección del circuito
    document.addEventListener('DOMContentLoaded', function() {
        cargarJornadasPorCircuito();
        
        // Evento change del elemento select
        document.getElementById('circuito').addEventListener('change', function () {
            cargarJornadasPorCircuito();
        });
    });
</script>

<script>
    // Obtener el elemento select
    var selectCircuito = document.getElementById('circuito');

    // Escuchar el evento de cambio en el select
    selectCircuito.addEventListener('change', function() {
        // Obtener el valor seleccionado del select
        var selectedCircuitoId = this.value;
        // Actualizar el valor del campo oculto 'circuito_id' en el formulario
        document.getElementById('circuito_id').value = selectedCircuitoId;
    });
</script>

<script>

    document.getElementById('circuito').addEventListener('change', function () {
        var circuitoId = this.value;
        document.getElementById('circuito_id').value = circuitoId;
    });
    var circuitoId = document.getElementById('circuito').value;
    document.getElementById('circuito_id').value = circuitoId;

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
