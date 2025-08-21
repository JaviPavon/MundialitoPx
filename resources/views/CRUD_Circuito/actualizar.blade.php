@extends('layout/plantilla')

@section("tituloPagina", "Actualizar un Circuito")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar un circuito</h5></div>

            <p class="card-text">
                <form action="{{ route("circuitos.update", $circuitos->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{ $circuitos->nombre }}">
                    <label for="">Alias</label>
                    <input type="text" name="alias" class="form-control" required value="{{ $circuitos->alias }}">
                    <label for="">Fecha del circuito</label>
                    <input type="date" name="fecha_circuito" class="form-control" value="{{ $circuitos->fecha_circuito }}">
                    <br>
                    <label for="">Pais</label>
                    <select name="pais" id="pais" required>
                        @foreach ($paises as $pais)
                            @if ($pais->id == $circuitos->id_pais)
                                <option value="{{ $pais->id }}" selected>{{ $pais->nombre }}</option>
                            @else
                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <img class="img-200" src="/circuitos/{{ $circuitos->circuito}}" id="imagenSeleccionada" alt="">
                    <br>
                    <input name="circuito" id="circuito" type="file" class="hidden">
                    <br>
                    <br>
                    <img class="img-200" src="/siluetas/{{ $circuitos->silueta}}" id="imagenSeleccionada2" alt="">
                    <br>
                    <input name="silueta" id="silueta" type="file" class="hidden">
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("circuitos.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('#circuito').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
    <script>
        $(document).ready(function (e) {
            $('#silueta').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada2').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection