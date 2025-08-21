@extends('layout/plantilla')

@section("tituloPagina", "Actualizar una Noticia")

@section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Actualizar una Noticia</h5></div>

            <p class="card-text">
                <form action="{{ route("noticias.update", $noticia->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <label for="">Título</label>
                    <input type="text" name="titulo" class="form-control" required value="{{ $noticia->titulo }}">
                    <label for="">Cuerpo</label>
                    <br>
                    <textarea name="cuerpo" id="cuerpo" cols="30" rows="10" required>{{ $noticia->cuerpo }}</textarea>
                    <br>
                    <img src="/miniaturas/{{ $noticia->miniatura}}" id="imagenSeleccionada" alt="">
                    <br>
                    <input name="miniatura" id="miniatura" type="file" class="hidden">
                    <br>
                    <br>
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route("noticias.index") }}" class="btn btn-info">Volver</a>
                </form>
            </p>
           
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function (e) {
            $('#miniatura').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagenSeleccionada').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection