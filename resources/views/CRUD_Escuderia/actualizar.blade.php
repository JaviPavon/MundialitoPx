@extends('layout/plantilla')

@section("tituloPagina", "Actualizar un piloto")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar una escuderia</h5></div>

            <p class="card-text">
                <form action="{{ route("escuderias.update", $escuderias->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <label for="">Posicion</label>
                    <input type="number" name="posicion" class="form-control" required value="{{ $escuderias->posicion }}">
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{ $escuderias->nombre }}">
                    <label for="">Alias</label>
                    <input type="text" name="alias" class="form-control" required value="{{ $escuderias->alias }}">
                    <label for="">Descripción</label>
                    <input type="text" name="descripcion" class="form-control" required value="{{ $escuderias->descripcion }}">
                    <label for="">Puntos</label>
                    <input type="number" name="puntos" class="form-control" required value="{{ $escuderias->puntos }}">
                    <br>
                    <label for="">Pais</label>
                    <select name="pais" id="pais" required>
                        @foreach ($paises as $pais)
                            @if ($pais->id == $escuderias->id_pais)
                                <option value="{{ $pais->id }}" selected>{{ $pais->nombre }}</option>
                            @else
                                <option value="{{ $pais->id }}">{{ $pais->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <img class="img-200" src="/logos/{{ $escuderias->logo}}" id="imagenSeleccionada" alt="">
                    <br>
                    <label for="">Logo</label>
                    <br>
                    <input name="logo" id="logo" type="file" class="hidden">
                    <br>
                    <br>
                    <img class="img-200" src="/monoplazas/{{ $escuderias->monoplaza}}" id="imagenSeleccionada2" alt="">
                    <br>
                    <label for="">Monoplaza</label>
                    <br>
                    <input name="monoplaza" id="monoplaza" type="file" class="hidden">
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("escuderias.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('#logo').change(function(){
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
            $('#monoplaza').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada2').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection