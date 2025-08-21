@extends('layout/plantilla')

@section("tituloPagina", "Crear un nuevo piloto")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear un piloto</h5></div>

            <p class="card-text">
                <form action="{{ route("pilotos.store")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">Posicion</label>
                    <input type="number" name="posicion" class="form-control" required>
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                    <label for="">Dorsal</label>
                    <input type="number" name="dorsal" class="form-control" required>
                    <label for="">Biografía</label>
                    <input type="text" name="biografia" class="form-control" required>
                    <label for="">Puntos</label>
                    <input type="number" name="puntos" class="form-control" required>
                    <br>
                    <label for="">Escuderia</label>
                    <select name="escuderia" id="escuderia" required>
                        @foreach ($escuderias as $escuderia)
                            <option value="{{ $escuderia->id }}">{{ $escuderia->nombre }}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <label for="">Pais</label>
                    <select name="pais" id="pais" required>
                        @foreach ($paises as $pais)
                            <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <img class="img-200" id="imagenSeleccionada" alt="">
                    <br>
                    <input name="foto" id="foto" type="file" class="hidden">
                    <br>
                    <br>
                    <button class="btn btn-primary">Crear</button>
                    <a href="{{ route("pilotos.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('#foto').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection