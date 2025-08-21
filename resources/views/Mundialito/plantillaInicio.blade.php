<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('tituloPagina')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/mundialito.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/splide.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Splide/3.2.1/splide.min.css">
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script charset="utf-8" type="text/javascript" src="https://kenwheeler.github.io/slick/slick/slick.min.js"></script>
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Splide/3.2.1/splide.min.js"></script>
    <style>
      .splide__slide {
        opacity: 0.6;
      }

      .splide__slide.is-active {
        opacity: 1;
      }

      .splide__slide img {
        width: 20%;
        height: 20%;
        object-fit: cover;
      }

      .btn-login {
        background-color: #dc0500;
        color: #EAEAEA
      }

      .btn-register {
        background-color: #1e1e23;
        color: #EAEAEA;
      }
      .botonmenu{
        background-color: #f7f4f1;
        font-size: 25px;
        color: #ef302d;
      }
    </style>
</head>
<body>
    <header class="sticky-top">
        <nav class="menu px-3 py-2 border-bottom">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <div class="row">
                    <div class="col-3 offset-1 offset-sm-0 d-flex align-items-center justify-content-left">
                        <a href="{{ route('index') }}" class="logo-banner d-flex align-middle align-items-left justify-content-left my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                            <img src="{{ asset('recursos-PI/Logo_mundialito_rojo3.webp') }}" style="width:60%; min-width: 120px;" alt="">
                        </a>
                    </div>
                    <div class="d-flex offset-sm-1 d-xl-none col-8 justify-content-end">
                        <button class="border-0 botonmenu" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-list"></i></button>
                    </div>
                    <div class="d-none d-xl-flex col-9 justify-content-end fixed">
                        <ul class="nav col-12 col-lg-auto my-2 my-md-0 text-small">
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.noticias') }}" class="a-banner nav-link">Noticias</a>
                            </li>
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.clasificacion') }}" class="a-banner nav-link">Clasificación</a>
                            </li>
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.calendario') }}" class="a-banner nav-link">Calendario</a>
                            </li>
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.pilotos') }}" class="a-banner nav-link">Pilotos</a>
                            </li>
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.escuderias') }}" class="a-banner nav-link">Escuderias</a>
                            </li>
                            @if (Auth::check())
                                <li class="align-items-center d-flex">
                                    <a href="{{ route('mundialito.fantasy') }}" class="fantasy-enlace a-banner nav-link car-link">
                                        <button class="carbutton">
                                            <div class="caption">Fantasy</div>
                                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car">
                                                <path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"/>
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            @endif
                            <li class="align-items-center d-flex">
                                <a href="#" class="btn-f1-tv a-banner nav-link">
                                    <img class="f1tv" src="{{ asset('recursos-PI/f1-tv.svg') }}" alt="f1-tv" style="width: 60px;">
                                </a>
                            </li>
                            <li class="align-items-center d-flex">
                                <div class="dropdown text-end">
                                    @if (Auth::check())
                                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if (Auth::user()->profile_image)
                                            <img src="/profile_image/{{ Auth::user()->profile_image}}" alt="foto-perfil" style="width: 32px; height: 32px;" class="border border-1 rounded-circle">
                                        @else
                                            <img src="{{ asset('recursos-PI/driver.png') }}" alt="foto-perfil" style="width: 32px; height: 32px;" class="border border-1 rounded-circle">
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg-end">
                                        @if (Auth::user()->role == 'admin')
                                            <li><a class="a-banner dropdown-item" href="{{ route('admin') }}">Admin</a></li>
                                        <li><hr class="a-banner dropdown-divider"></li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                {{ __('Editar Perfil') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="post" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="a-banner dropdown-item" style="background: none; border: none; padding-left: 10%; cursor: pointer;">
                                                    Cerrar Sesión
                                                </button>
                                            </form>   
                                        </li>
                                    @else
                                        <li class="align-items-center d-flex" ><a class="btn btn-login" href="{{ route('login') }}">Iniciar Sesión</a></li>
                                        <li class="align-items-center d-flex" ><a class="btn btn-register" href="{{ route('register') }}">Registrarse</a></li>
                                    </ul>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">Mundialito Paxangars</h5>
                    <button type="button botonmenu" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="row g-3 align-items-center justify-content-center text-align-center">

                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.noticias') }}" class="a-banner nav-link">Noticias</a>
                            </li>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.clasificacion') }}" class="a-banner nav-link">Clasificación</a>
                            </li>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.calendario') }}" class="a-banner nav-link">Calendario</a>
                            </li>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.pilotos') }}" class="a-banner nav-link">Pilotos</a>
                            </li>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <a href="{{ route('mundialito.escuderias') }}" class="a-banner nav-link">Escuderias</a>
                            </li>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            @if (Auth::check())
                                <li class="align-items-center d-flex">
                                    <a href="{{ route('mundialito.fantasy') }}" class="fantasy-enlace a-banner nav-link car-link">
                                        <button class="carbutton">
                                            <div class="caption">Fantasy</div>
                                            <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="car">
                                                <path d="M355.975 292.25a24.82 24.82 0 1 0 24.82-24.81 24.84 24.84 0 0 0-24.82 24.81zm-253-24.81a24.81 24.81 0 1 1-24.82 24.81 24.84 24.84 0 0 1 24.81-24.81zm-76.67-71.52h67.25l-13.61 49.28 92-50.28h57.36l1.26 34.68 32 14.76 11.74-14.44h15.62l3.16 16c137.56-13 192.61 29.17 192.61 29.17s-7.52 5-25.93 8.39c-3.88 3.31-3.66 14.44-3.66 14.44h24.2v16h-52v-27.48c-1.84.07-4.45.41-7.06.47a40.81 40.81 0 1 0-77.25 23h-204.24a40.81 40.81 0 1 0-77.61-17.67c0 1.24.06 2.46.17 3.67h-36z"/>
                                            </svg>
                                        </button>
                                    </a>
                                </li>
                            @endif
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <a href="#" class="btn-f1-tv a-banner nav-link">
                                    <img class="f1tv" src="{{ asset('recursos-PI/f1-tv.svg') }}" alt="f1-tv" style="width: 60px;">
                                </a>
                            </li>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <li class="align-items-center d-flex">
                                <div class="dropdown text-end">
                                    @if (Auth::check())
                                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if (Auth::user()->profile_image)
                                            <img src="/profile_image/{{ Auth::user()->profile_image}}" alt="foto-perfil" width="32" height="32" class="border border-1 rounded-circle">
                                        @else
                                            <img src="{{ asset('recursos-PI/driver.png') }}" alt="foto-perfil" width="32" height="32" class="border border-1 rounded-circle">
                                        @endif
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg-end">
                                        @if (Auth::user()->role == 'admin')
                                            <li><a class="a-banner dropdown-item" href="{{ route('admin') }}">Admin</a></li>
                                            <li><hr class="a-banner dropdown-divider"></li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                {{ __('Editar Perfil') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="post" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="a-banner dropdown-item" style="background: none; border: none; padding-left: 10%; cursor: pointer;">
                                                    Cerrar Sesión
                                                </button>
                                            </form>   
                                        </li>
                                    </ul>
                                    @else
                                    <div class="col-12 d-flex justify-content-center">
                                        <li class="align-items-center d-flex"><a class="btn btn-login" href="{{ route('login') }}">Iniciar Sesión</a></li>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <li class="align-items-center d-flex"><a class="btn btn-register" href="{{ route('register') }}">Registrarse</a></li>
                                    </div>
                                    @endif
                                </div>
                            </li>
                        </div>
                    </div>
                </div>



            </div>
        </nav>
    </header>
    <div class="container-fluid">
        @yield('contenido')
    </div>

    <div class="modal fade" id="f1TvModal" tabindex="-1" aria-labelledby="f1TvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="f1TvModalLabel">F1 TV Channels</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="channels-container" class="accordion" id="channelsAccordion">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    @stack('scripts')

    <script>
        $(document).ready(function () {
            $('.btn-f1-tv').click(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('f1tv.show') }}',
                    type: 'GET',
                    success: function (data) {
                        let channelsContainer = $('#channels-container');
                        channelsContainer.empty();

                        data.forEach(function (canal, index) {
                            let channelItem = `
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading${index}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="false" aria-controls="collapse${index}">
                                            ${canal.nombre}
                                        </button>
                                    </h2>
                                    <div id="collapse${index}" class="accordion-collapse collapse" aria-labelledby="heading${index}" data-bs-parent="#channelsAccordion">
                                        <div class="accordion-body">
                                            <div class="iframe-container">
                                                <iframe src="https://player.twitch.tv/?channel=${canal.nombre}&parent=127.0.0.1" frameborder="0" allowfullscreen="true" scrolling="no"></iframe>
                                            </div>
                                            <div class="mt-3">
                                                <a href="${canal.enlace}" target="_blank" class="btn btn-primary">Ir al canal</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            channelsContainer.append(channelItem);
                        });

                        $('#f1TvModal').modal('show');
                    },
                    error: function (error) {
                        console.error('Error fetching data:', error);
                    }
                });
            });
        });
    </script>

    <style>
        .iframe-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* Relación de aspecto 16:9 */
            height: 0;
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>

    
    
    
</body>
</html>
