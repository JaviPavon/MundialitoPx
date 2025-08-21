@extends('Mundialito/plantilla')

@section('tituloPagina', 'Fantasy Paxangars')

@section('contenido')
    <div class="container-fantasy">
        <div class="row text-white justify-content-center align-items-center text-center">
            <div class="col-12">
                <div class="row pt-4">
                    <div class="col-4">
                        <a class="btn enlace-ligas mb-2" style=" color:#EAEAEA;"  href="{{ route('mundialito.fantasy') }}"><i class="bi bi-arrow-return-left"></i></a>
                        <a class="btn enlace-ligas mb-2" href="{{ route('mundialito.formliga') }}"><span>Crear Liga</span></a>
                    </div>
                    <div class="col-6">
                        <h1>Lista Ligas</h1>
                    </div>
                </div>
                <div class="row pb-3 pt-3 justify-content-center align-items-center text-center">
                    @if (count($ligas) != 0)
                    @foreach ($ligas as $liga )
                        <div class="col-12 col-lg-6 col-xxl-4 text-dark d-flex justify-content-center align-items-center text-center p-2">
                            <div class="card-liga">
                                <div class="position-relative">
                                    <div class="card2">
                                        <div class="card-body">
                                            <div class="texto-valor texto-liga position-absolute top-0 end-0">
                                                <h3>{{ $liga->nombre }}</h3>
                                            </div>
                                            <div class="texto-foto texto-valor position-absolute top-0 start-0">
                                                <h4>{{ $liga->estado }}</h4>
                                            </div>
                                            <div class="texto-foto position-absolute bottom-0 start-0">
                                                <h5>
                                                    @if ($liga->jugador->count() > 1)
                                                        {{ $liga->jugador->count() }} jugadores
                                                    @else
                                                        {{ $liga->jugador->count() }} jugador
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="texto-liga texto-boton position-absolute bottom-0 end-0">
                                                <button class="btn btn-liga" data-id="{{ $liga->id }}" data-bs-toggle="modal" data-bs-target="#f1TvModal">Unirse</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <h2 class="text-white">No hay ligas disponibles</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para unirse a la liga -->
    <div class="modal fade" id="f1TvModal" tabindex="-1" aria-labelledby="f1TvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="f1TvModalLabel">¿Quieres unirte a esta Liga?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body liga-container">
                    <!-- El contenido de la liga se cargará aquí -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unirseButtons = document.querySelectorAll('.btn-liga');
            const ligaContainer = document.querySelector('.liga-container');

            unirseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const ligaId = this.getAttribute('data-id');

                    fetch(`/liga/${ligaId}/detalles`)
                        .then(response => response.json())
                        .then(data => {
                            const jugadoresHtml = data.jugador.map(jugador => `
                                <tr>
                                    <td>${jugador.puesto}º</td>
                                    <td>${jugador.usuario.name}</td>
                                    <td>${jugador.puntos}</td>
                                </tr>
                            `).join('');
                            ligaContainer.innerHTML = `
                                <form action="/fantasy/unirse/liga/${data.id}" method="POST">
                                    @csrf
                                    <h2>${data.nombre}</h2>
                                    ${data.estado === 'privada' ? `
                                    <label for="contraseña">Contraseña</label>
                                    <br>
                                    <input type="password" name="contraseña" class="form-control" id="contraseña" required>
                                    <br>` : ''}
                                    <br>
                                    <div class="table table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <th>Puesto</th>
                                                <th>Nombre Usuario</th>
                                                <th>Puntos</th>
                                            </thead>
                                            <tbody>
                                                ${jugadoresHtml}
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-primary">Unirse</button>
                                </form>
                            `;
                        })
                        .catch(error => console.error('Error fetching league details:', error));
                });
            });
        });
    </script>

    <style>
        /* Estilos personalizados */
        body {
            background-color: #0C005A;
        }

        .card {
            background: #EAEAEA;
        }

        .card-liga {
            width: 100%;
            height: 200px;
            background-image: linear-gradient(163deg, #FF0000 0%, #311ac9 100%);
            border-radius: 20px;
            transition: all .3s;
        }

        .card2 {
            width: 100%;
            height: 200px;
            background-color: #EAEAEA;
            border-radius: 5%;
            transition: all .2s;
        }

        .card2:hover {
            transform: scale(0.98);
            border-radius: 20px;
        }

        .card-liga:hover {
            box-shadow: 0px 0px 30px 1px rgba(0, 255, 117, 0.30);
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
            background-color: rgb(46, 46, 46);
            left: 0;
            top: 0;
            border-radius: 10px;
        }

        .btn::before {
            content: "";
            background: linear-gradient(
                45deg,
                #BC2525, #0C005A, #FF0000, #002BFF,
                #BC2525, #0C005A, #FF0000, #002BFF
            );
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
    </style>
@endsection
