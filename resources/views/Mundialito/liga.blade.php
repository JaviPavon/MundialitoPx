@extends('Mundialito/plantilla')

@section('tituloPagina', 'Fantasy Paxangars')

@section('contenido')
    <div class="container-liga">
        <div class="row text-white justify-content-center text-center align-items-start">
            <div class="col-12 col-sm-1">
                <a class="btn btn-dark" style=" color:#EAEAEA;"  href="{{ route('mundialito.fantasy') }}"><i class="bi bi-arrow-return-left"></i></a>
            </div>
            <div class="col-11 col-sm-1 offset-1">
                <button type="button" class="btn btn-abandonar" data-bs-toggle="modal" data-bs-target="#confirmAbandonModal">Abandonar</button>
            </div>
            <div class="col-12 col-lg-8">
                <h1>{{ $liga->nombre }}</h1>
            </div>
            
            <div class="col-12 col-lg-4 order-2 order-lg-1">
                <div class="clasificacion">
                    <h2>Clasificación</h2>
                    <div class="table table-responsive p-3">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr class="table-dark">
                                    <th>Puesto</th>
                                    <th>Nombre</th>
                                    <th>Puntos</th>
                                    <th>Historial</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($jugadores as $jugador)
                                @php
                                    $isCurrentUser = $jugador->usuario->id === auth()->user()->id;
                                @endphp
                                <tr>
                                    <td class="{{ $isCurrentUser ? 'table-success' : 'table-secondary' }}">{{ $jugador->puesto }}º</td>
                                    <td class="{{ $isCurrentUser ? 'table-success' : '' }}">{{ $jugador->usuario->name }}</td>
                                    <td class="{{ $isCurrentUser ? 'table-success' : '' }}">{{ $jugador->puntos }}</td>
                                    <td class="{{ $isCurrentUser ? 'table-success' : '' }}">
                                        <a href="#" class="btn-historial" data-id="{{ $jugador->id }}">
                                            <i style="text-decoration: none;" class="bi bi-clock"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="plantillaPilotos col-12 col-lg-8 pt-5 order-1 order-lg-2">
                <input type="hidden" id="jugadorID" name="jugadorID" value="{{ $jugador->id }}">
                <h2>Siguiente Jornada: {{ $circuito->nombre }}</h2>
                <h2>Saldo: {{ $jugador->saldo }}€</h2>
                @if($fantasy->en_juego == 0)
                <form action="{{ route('jugador.vaciarCampos', $jugador->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-dark" >Vaciar Pilotos</button>
                </form>
                @elseif($fantasy->en_juego == 1)
                    <button class="btn btn-dark disabled">Vaciar pilotos</button>
                @endif


                <div class="row justify-content-center text-center">
                    <div class="col-6 col-sm-3" id="lider" data-role="lider">
                        @if ($jugador->piloto_juego_lider)
                            <div class="card card-piloto card-mejor" data-id="{{ $jugador->piloto_juego_lider->id }}">
                                <div class="position-relative">
                                    <img class="object-fit-fill border rounded m-2" src="/fotos/{{ $jugador->piloto_juego_lider->piloto->foto }}" alt="" >
                                    <div class="texto-valor texto-foto text-white position-absolute top-0 start-0">
                                        <h4>{{ number_format($jugador->piloto_juego_lider->valor, 0, ',', '.') }}€</h4>
                                    </div>
                                    <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                                        <h3>{{ $jugador->piloto_juego_lider->piloto->nombre }}</h3>
                                        <h3>{{ $jugador->piloto_juego_lider->puntos }}pts</h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class=" sin-piloto-lider" data-id="">
                                <img src="{{ asset('recursos-PI/driver-lider.png') }}" style="width:60%;" alt="">
                            </div>
                        @endif
                        <input type="hidden" id="pilotoIdLider" name="pilotoIdLider" value="">
                    </div>
                    <div class="col-6 col-sm-3" id="normal" data-role="normal">
                        @if ($jugador->piloto_juego)
                            <div class="card card-piloto card-secundario" data-id="{{ $jugador->piloto_juego->id }}">
                                <div class="position-relative">
                                    <img class="object-fit-fill border rounded img-fluid m-2" src="/fotos/{{ $jugador->piloto_juego->piloto->foto }}" alt="">
                                    <div class="texto-valor texto-foto text-white position-absolute top-0 start-0">
                                        <h4>{{ number_format($jugador->piloto_juego->valor, 0, ',', '.') }}€</h4>
                                    </div>
                                    <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                                        <h3>{{ $jugador->piloto_juego->piloto->nombre }}</h3>
                                        <h3>{{ $jugador->piloto_juego->puntos }}pts</h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class=" sin-piloto" data-id="">
                                <img src="{{ asset('recursos-PI/drivergris.png') }}" style="width:60%;" alt="">
                            </div>
                        @endif
                        <input type="hidden" id="pilotoIdNormal" name="pilotoIdNormal" value="">
                    </div>
                </div>
                <div class="row">
                    @foreach ($pilotos as $piloto)
                        <div class="col-6 col-sm-3 p-2" id="pilotos">
                            <div class="card card-piloto" data-id="{{ $piloto->id }}">
                                <div class="position-relative">
                                    <img class="object-fit-fill border rounded img-fluid m-2" src="/fotos/{{ $piloto->piloto->foto }}" alt="">
                                    <div class="texto-valor texto-foto text-white position-absolute top-0 start-0">
                                        <h4>{{ number_format($piloto->valor, 0, ',', '.') }}€</h4>
                                    </div>
                                    <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                                        <h3>{{ $piloto->piloto->nombre }}</h3>
                                        <h3>{{ $piloto->puntos }}pts</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="historialModal" tabindex="-1" aria-labelledby="historialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historialModalLabel">Historial del Jugador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Número de Jornada</th>
                                <th>Piloto Juego Líder</th>
                                <th>Piloto Juego</th>
                            </tr>
                        </thead>
                        <tbody id="historial-container">
                            <!-- Aquí se cargarán los datos del historial -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para abandonar la liga -->
    <div class="modal fade" id="confirmAbandonModal" tabindex="-1" aria-labelledby="confirmAbandonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmAbandonModalLabel">Confirmar Abandono</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas abandonar la liga?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
                    <form id="abandonForm" method="POST" action="{{ route('mundialito.abandonarliga', ['id' => $jugador->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Abandonar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.8/lib/plugins/auto-scroll.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-historial').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const jugadorId = this.dataset.id;
    
                    axios.get(`/jugador/${jugadorId}/historial`)
                        .then(response => {
                            const historialContainer = document.getElementById('historial-container');
                            historialContainer.innerHTML = '';
    
                            response.data.forEach(historial => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${historial.numero_jornada}</td>
                                    <td>${historial.piloto_juego_lider}</td>
                                    <td>${historial.piloto_juego}</td>
                                `;
                                historialContainer.appendChild(row);
                            });
    
                            const historialModal = new bootstrap.Modal(document.getElementById('historialModal'));
                            historialModal.show();
                        })
                        .catch(error => console.error('Error fetching historial:', error));
                });
            });
    
            let liderContainer = document.querySelector('#lider');
            let normalContainer = document.querySelector('#normal');
            let pilotoContainers = document.querySelectorAll('#pilotos');
    
            let liderCard = liderContainer.querySelector('.card[data-id]');
            let normalCard = normalContainer.querySelector('.card[data-id]');
            let pilotoIdLider = liderCard ? liderCard.getAttribute('data-id') : '';
            let pilotoIdNormal = normalCard ? normalCard.getAttribute('data-id') : '';
            let jugadorId = document.getElementById('jugadorID').value;
    
            const updateHiddenInputs = () => {
                liderCard = liderContainer.querySelector('.card[data-id]');
                normalCard = normalContainer.querySelector('.card[data-id]');
                pilotoIdLider = liderCard ? liderCard.getAttribute('data-id') : '';
                pilotoIdNormal = normalCard ? normalCard.getAttribute('data-id') : '';
                jugadorId = document.getElementById('jugadorID').value;
    
                pilotoIdLider = pilotoIdLider || 0;
                pilotoIdNormal = pilotoIdNormal || 0;
    
                document.getElementById('pilotoIdLider').value = pilotoIdLider;
                document.getElementById('pilotoIdNormal').value = pilotoIdNormal;
            };
    
            const updatePilotos = function() {
                updateHiddenInputs();
                axios.post(`/fantasy/updatepilotos/${pilotoIdLider}/${pilotoIdNormal}/${jugadorId}`)
                    .then(response => {
                        console.log('Piloto líder actualizado correctamente!');
                        updateHiddenInputs();
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error actualizando el piloto lider: ', error);
                        window.location.reload();
                    });
            };
    
            // Asumimos que el valor de fantasy->en_juego se pasa a JavaScript como una variable llamada en_juego.
            var en_juego = <?php echo $fantasy->en_juego; ?>;
    
            var autoScrollOptions = {
                scroll: true, // Enable auto-scroll
                scrollSensitivity: 100, // Sensibilidad del borde para empezar a desplazar
                scrollSpeed: 1000 // Velocidad de desplazamiento
            };

            if (en_juego == 0) {
                new Sortable(liderContainer, {
                    group: 'pilotos',
                    animation: 150,
                    swap: true,
                    onEnd: updatePilotos,
                    ...autoScrollOptions // Aplicar las opciones de auto-scroll
                });

                new Sortable(normalContainer, {
                    group: 'pilotos',
                    animation: 150,
                    swap: true,
                    onEnd: updatePilotos,
                    ...autoScrollOptions // Aplicar las opciones de auto-scroll
                });

                pilotoContainers.forEach(container => {
                    new Sortable(container, {
                        group: 'pilotos',
                        animation: 150,
                        swap: true,
                        onEnd: updatePilotos,
                        ...autoScrollOptions // Aplicar las opciones de auto-scroll
                    });
                });
            }
    
            updateHiddenInputs();
        });
    </script>
    

    <style>
        

        body {
            background-color: #0C005A;
        }

        .container-liga {
            padding-top: 3%;
        }

        /* card piloto */
        .card {
            background: #fff;
        }

        .card-piloto {
            background: #0C005A;
            position: relative;
            display: flex;
            place-content: center;
            place-items: center;
            overflow: hidden;
            border-color: #0C005A;
            border-radius: 20px;
        }

        .card-mejor h2 {
            z-index: 1;
            color: white;
            font-size: 2em;
        }

        .card-mejor::before {
            content: '';
            position: absolute;
            width: 100px;
            background-image: linear-gradient(180deg, #EAEAEA, #FF0000);
            height: 130%;
            animation: rotBGimg 3s linear infinite;
            transition: all 0.2s linear;
        }

        @keyframes rotBGimg {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .card-mejor::after {
            content: '';
            position: absolute;
            inset: 5px;
            border-radius: 15px;
        }

        /*  */

        .card-secundario h2 {
        z-index: 1;
        color: white;
        font-size: 2em;
        }

        .card-secundario::before {
        content: '';
        position: absolute;
        width: 100px;
        background-image: linear-gradient(180deg, #979797, #eeeeef);
        height: 130%;
        animation: rotBGimg 10s linear infinite;
        transition: all 0.2s linear;
        }

        

        .card-secundario::after {
        content: '';
        position: absolute;
        inset: 5px;
        border-radius: 15px;
        } 

        .btn-abandonar {
            background-color: #BC2525;
        }

        .btn {
            padding: 0.9em 1.6em;
            border: none;
            outline: none;
            color: #EAEAEA;
            font-family: inherit;
            font-weight: 500;
            font-size: 17px;
            cursor: pointer;
            position: relative;
            z-index: 0;
            border-radius: 12px;
        }

        .btn::after {
            content: "";
            z-index: -1;
            color: #EAEAEA;
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        /* glow */
        .btn::before {
            content: "";
            background: linear-gradient(45deg, #BC2525, #0C005A, #FF0000, #002BFF, #BC2525, #0C005A, #FF0000, #002BFF);
            position: absolute;
            top: -2px;
            left: -2px;
            background-size: 600%;
            z-index: -1;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            filter: blur(8px);
            animation: glowing 20s linear infinite;
            transition: opacity .3s ease-in-out;
            border-radius: 10px;
            opacity: 0;
        }

        @keyframes glowing {
            0% {
                background-position: 0 0;
            }

            50% {
                background-position: 400% 0;
            }

            100% {
                background-position: 0 0;
            }
        }

        /* hover */
        .btn:hover::before {
            opacity: 1;
        }

        .btn:active:after {
            background: transparent;
        }

        .btn:active {
            color: #EAEAEA;
            font-weight: bold;
        }

        .btn-abandonar {
            background-color: #BC2525;
        }
    </style>
@endsection
