@extends('Mundialito/plantillaInicio')

@section('tituloPagina', 'Mundialito Paxangars')

@section('contenido')
    <div class="home row justify-content-center align-items-center text-center">
        <div class="position-relative">
            <img class="position-absolute top-50 start-50 translate-middle img-fluid" src="../../../public/recursos-PI/Escudo_Paxangars_rojo.png" alt="Formula 1 Car">
        </div>
    </div>
    <style>
        .img-fluid {
            -webkit-filter: drop-shadow(15px 15px 15px #222);
            filter: drop-shadow(15px 15px 15px #222);
            width: 35%;
            min-width: 200px;
        }
        body, html {
            background: linear-gradient(to right, #ef302d 50%, #1e1e23 50%);
            height: 80vh;
            margin: 0;
            padding: 0;
        }
        .container-fluid {
            height: 100%;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
        }
        .home {
            height: 100%;
        }
    </style>
@endsection