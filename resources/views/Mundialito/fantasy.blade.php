@extends('Mundialito/plantilla')

@section('tituloPagina', 'Fantasy Paxangars')

@section('contenido')
@php
$maxPoints = $pilotos->max('puntos');
@endphp
    <div class="container-fantasy">
        <div class="row text-white justify-content-center align-items-center text-center">
            <div class="col-12">
                <div class="row pt-4">
                    <div class="col-6 col-lg-3">
                        <button>
                            <a class="enlace-ligas" href="{{ route('mundialito.listaligas') }}"><span>Lista Ligas</span></a> 
                        </button>
                    </div>
                    <div class="col-6">
                        <h1>Fantasy</h1>
                    </div>
                </div>
                <div class="row pb-3 pt-3 justify-content-center align-items-center text-center">
                    <h2>Tus Ligas</h2>
                    @foreach ($jugadores as $jugador )
                        <div class="col-10 col-md-6 col-lg-4 text-dark d-flex justify-content-center align-items-center text-center p-2">
                            <div class="card-liga ">
                                <div class="position-relative">
                                <div class="card2">
                                    <div class="card-body">
                                            <div class="texto-valor texto-liga position-absolute top- end-0">
                                                <h4>{{ $jugador->liga->nombre }}</h4>
                                            </div>
                                            <div class="texto-foto texto-valor position-absolute top-0 start-0">
                                                <h3> {{ $jugador->puesto }}º </h3>
                                            </div>
                                            <div class="texto-foto position-absolute bottom-0 start-0">
                                                <h5>{{ number_format($jugador->saldo, 0, ',', '.') }}€</h5>
                                                <h3> {{ $jugador->puntos }}pts </h3>
                                            </div>
                                            <div class="texto-liga texto-boton position-absolute bottom-0 end-0">
                                                <a href="{{ route('mundialito.liga', $jugador->id) }}" class="btn">Entrar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <h2>Pilotos Fantasy</h2>
                <div class="row autoplay ">
                    @foreach ($pilotos as $piloto)
                        @php
                            $cardClass = $piloto->puntos == $maxPoints ? 'card card-piloto card-mejor' : 'card card-piloto';
                        @endphp
                        <div class="col-3 p-2">
                            <div class="{{ $cardClass }}">
                                <div class="position-relative">
                                    <img class="object-fit-fill border rounded img-fluid m-2" src="/fotos/{{ $piloto->piloto->foto }}" alt="" style="width: 95%;">
                                    <div class="texto-valor texto-foto text-white position-absolute top-0 start-0">
                                        <h4>{{ number_format($piloto->valor, 0, ',', '.') }}€</h4>
                                    </div>
                                    <div class="texto-foto text-start text-white position-absolute bottom-0 start-0">
                                        <h3>{{ $piloto->piloto->nombre }}</h3>
                                        <h3>{{ $piloto->puntos }}pts</h3>
                                    </div>
                                    <a href="#" class="texto-liga texto-valor position-absolute top-0 end-0 btn-info-piloto" data-id="{{ $piloto->id }}" style="z-index: 1; color: #EAEAEA;">
                                        <i class="bi bi-info-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="jornadasModal" tabindex="-1" aria-labelledby="jornadasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jornadasModalLabel">Jornadas del Piloto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Jornada</th>
                                <th>Puntos</th>
                                <th>Puesto</th>
                                <th>Adelantamientos</th>
                                <th>Sanción 3 seg</th>
                                <th>Sanción 5 seg</th>
                                <th>Amonestaciones</th>
                                <th>Qually 2</th>
                                <th>Qually 3</th>
                            </tr>
                        </thead>
                        <tbody id="jornadas-container">
                            <!-- Aquí se cargarán las jornadas -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.btn-info-piloto').click(function (e) {
                e.preventDefault();
    
                var pilotoId = $(this).data('id');
                var url = '/piloto/' + pilotoId + '/jornadas';
    
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        let jornadasContainer = $('#jornadas-container');
                        jornadasContainer.empty();
    
                        data.forEach(function (jornada) {
                            let qually2 = jornada.qually2 == 1 ? '✓' : '✗';
                            let qually3 = jornada.qually3 == 1 ? '✓' : '✗';
    
                            let jornadaItem = `
                                <tr>
                                    <td>${jornada.id_circuito}</td>
                                    <td>${jornada.puntos}</td>
                                    <td>${jornada.puesto}</td>
                                    <td>${jornada.adelantamientos}</td>
                                    <td>${jornada.sancion3sec}</td>
                                    <td>${jornada.sancion5sec}</td>
                                    <td>${jornada.amonestaciones}</td>
                                    <td>${qually2}</td>
                                    <td>${qually3}</td>
                                </tr>
                            `;
                            jornadasContainer.append(jornadaItem);
                        });
    
                        $('#jornadasModal').modal('show');
                    },
                    error: function (error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
    
            $('.autoplay').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768, // Pantallas más pequeñas de 768px
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480, // Pantallas más pequeñas de 480px
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
    <style>
        body{
            background-color: #0C005A;
        }

        .card{
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

        /* Botón ligas */
        .enlace-ligas {
        position: relative;
        display: inline-block;
        padding: 15px 30px;
        border: 2px solid #fefefe;
        text-transform: uppercase;
        color: #fefefe;
        text-decoration: none;
        font-weight: 600;
        font-size: 20px;
        }

        .enlace-ligas::before {
        content: '';
        position: absolute;
        top: 6px;
        left: -2px;
        width: calc(100% + 4px);
        height: calc(100% - 12px);
        background-color: #212121;
        transition: 0.3s ease-in-out;
        transform: scaleY(1);
        }

        .enlace-ligas:hover::before {
        transform: scaleY(0);
        }

        .enlace-ligas::after {
        content: '';
        position: absolute;
        left: 6px;
        top: -2px;
        height: calc(100% + 4px);
        width: calc(100% - 12px);
        background-color: #212121;
        transition: 0.3s ease-in-out;
        transform: scaleX(1);
        transition-delay: 0.5s;
        }

        .enlace-ligas:hover::after {
        transform: scaleX(0);
        }

        .enlace-ligas span {
        position: relative;
        z-index: 3;
        }

        button {
        background-color: none;
        text-decoration: none;
        background-color: #212121;
        border: none;
        }

    /* Card Liga */
    .card-liga {
        width: 300px;
        height: 150px;
        background-image: linear-gradient(163deg, #FF0000 0%, #311ac9 100%);
        border-radius: 20px;
        transition: all .3s;
    }

        .card2 {
        width: 300px;
        height: 150px;
        background-color: #EAEAEA;
        border-radius:5%;
        transition: all .2s;
    }

        .card2:hover {
        transform: scale(0.98);
        border-radius: 20px;
    }

        .card-liga:hover {
        box-shadow: 0px 0px 30px 1px rgba(0, 255, 117, 0.30);
    }

    /* Botón entrar liga */
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
    /* glow */
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
    </style>
@endsection