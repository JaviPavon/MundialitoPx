@extends('layout/plantilla')

@section("tituloPagina", "Actualizar un piloto")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar un piloto</h5></div>

            <p class="card-text">
                <form action="{{ route("pilotos.update", $pilotos->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <label for="">Posicion</label>
                    <input type="number" name="posicion" class="form-control" required value="{{$pilotos -> posicion}}">
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{$pilotos ->  nombre}}">
                    <label for="">Dorsal</label>
                    <input type="number" name="dorsal" class="form-control" required value="{{$pilotos ->  dorsal}}">
                    <label for="">Biografía</label>
                    <input type="text" name="biografia" class="form-control" required value="{{$pilotos ->  biografia}}">
                    <label for="">Puntos</label>
                    <input type="number" name="puntos" class="form-control" required value="{{$pilotos ->  puntos}}">
                    <br>
                    <label for="">Escuderia</label>
                    <select name="escuderia" id="escuderia" class="selectpicker" required>
                        @foreach ($escuderias as $escuderia)
                            @if ($escuderia->id == $pilotos->id_escuderia)
                                <option value="{{ $escuderia->id }}" selected>{{ $escuderia->nombre }}</option>
                            @else
                                <option value="{{ $escuderia->id }}">{{ $escuderia->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br><br>
                    <label for="">Pais</label>
                    <select name="pais" id="pais" required>
                        @foreach ($paises as $pais)
                            @if ($pais->id == $pilotos->id_pais)
                                <option value="{{ $pais->id }}" selected>{{ $pais->nombre }}</option>
                            @else
                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <img class="img-200" src="/fotos/{{ $pilotos->foto}}" id="imagenSeleccionada" alt="">
                    <br>
                    <input name="foto" id="foto" type="file" class="hidden">
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
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