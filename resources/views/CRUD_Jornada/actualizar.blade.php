@extends('layout/plantilla')

@section("tituloPagina", "Actualizar Jornada")

@section('contenido')

    <a href="{{ route("jornada.index") }}" class="btn btn-info">Volver</a>
    <br>

    <h1>Controlador Jornada</h1>


    <h2>{{ $circuito->nombre }}</h2>
    <div class="row" id="orden">
        @foreach ($jornadas as $jornada )
            <div class="col-3" data-id="{{ $jornada->id }}">
                <div class="card text-center" style="width: 20rem;">
                    <div class="position-relative" style="max-width: 100%; max-height: 200px; overflow: hidden;">
                        <div class="position-absolute top-0 start-0 text-white fs-1 m-4"> {{ $jornada->puesto }}º </div>
                        <img src="/fotos/{{ $jornada->piloto_juego->piloto->foto}}" class="card-img-top" alt="Piloto" style="width: 100%; height: auto; object-position: center center;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $jornada->piloto_juego->piloto->nombre }}</h5>
                        <p class="card-text">
                            <div class="row">
                                <div class="col-6">
                                    @if ($jornada->qually2 == 1)
                                    <form action="{{ route('jornada.pasoAQ2', ['id' => $jornada->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    Q1->Q2
                                    @else
                                    <form action="{{ route('jornada.pasoAQ2', ['id' => $jornada->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                    Q1->Q2
                                    @endif
                                </div>
                                <div class="col-6">
                                    @if ($jornada->qually3 == 1)
                                    <form action="{{ route('jornada.pasoAQ3', ['id' => $jornada->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    Q2->Q3
                                    @else
                                    <form action="{{ route('jornada.pasoAQ3', ['id' => $jornada->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                    Q2->Q3
                                    @endif
                                </div>
                                <div class="col-12 border mt-2">
                                    <div class="row">
                                        <div class="col-7 align-self-center">
                                            Adelantamientos
                                        </div>
                                        <div class="col-2 align-self-center">
                                            {{ $jornada->adelantamientos }}
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.masAdelantamiento', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-plus-square"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.menosAdelantamiento', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-dash-square"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 border mt-2">
                                    <div class="row">
                                        <div class="col-7 align-self-center">
                                            Amonestaciones
                                        </div>
                                        <div class="col-2 align-self-center">
                                            {{ $jornada->amonestaciones }}
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.masAmonestacion', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-plus-square"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.menosAmonestacion', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-dash-square"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 border mt-2">
                                    <div class="row">
                                        <div class="col-7 align-self-center">
                                            Sanciones 3 Segundos
                                        </div>
                                        <div class="col-2 align-self-center">
                                            {{ $jornada->sancion3sec }}
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.masSancion3', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-plus-square"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.menosSancion3', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-dash-square"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 border mt-2">
                                    <div class="row">
                                        <div class="col-7 align-self-center">
                                            Sanciones 5 Segundos
                                        </div>
                                        <div class="col-2 align-self-center">
                                            {{ $jornada->sancion5sec }}
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.masSancion5', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-plus-square"></i></button>
                                                    </form>
                                                </div>
                                                <div class="col-12">
                                                    <form action="{{ route('jornada.menosSancion5', ['id' => $jornada->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link"><i class="bi bi-dash-square"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </p>
                    </div>
                    <div class="card-footer text-body-secondary">
                        {{ $jornada->puntos }} pts
                    </div>
                </div>
            </div>
        @endforeach
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
                    axios.post("{{ route('api.sort.puestosJornada') }}", {
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
