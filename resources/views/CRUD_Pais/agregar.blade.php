@extends('layout/plantilla')

@section("tituloPagina", "Crear un nuevo Pais")

@section('contenido')

<div class="card">
    <div class="card-body">
        <div class="card-header"><h5 class="card-title">Crear un Pais</h5></div>

        <p class="card-text">
            <form action="{{ route("paises.store")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
                <br>
                <img id="imagenSeleccionada" alt="">
                <br>
                <input name="bandera" id="bandera" type="file" class="hidden">
                <br>
                <br>
                <button class="btn btn-primary">Crear</button>
                <a href="{{ route("paises.index") }}" class="btn btn-info">Volver</a>
            </form>
        </p>
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function (e) {
        $('#bandera').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagenSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endsection