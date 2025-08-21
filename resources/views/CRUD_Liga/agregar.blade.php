@extends('layout/plantilla')

@section("tituloPagina", "Crear una nueva Liga")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear una Liga</h5></div>

            <form action="{{ route("liga.store") }}" method="POST">
                @csrf
                <label for="estado">Estado</label>
                <select class="form-select" name="estado" id="estado" required>
                    <option value="publica">Pública</option>
                    <option value="privada">Privada</option>
                </select>
            
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
                <br>
            
                <label for="contraseña">Contraseña</label>
                <br>
                <input type="password" name="contraseña" class="form-control" id="contraseña" required>
                <br>
                <br>
            
                <button class="btn btn-primary">Crear</button>
                <a href="{{ route("fantasy.index") }}" class="btn btn-info">Volver</a>
            </form>
            </p>
           
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var estadoSelect = document.getElementById("estado");
            var contraseñaInput = document.getElementById("contraseña");
    
            estadoSelect.addEventListener("change", function() {
                if (estadoSelect.value === "privada") {
                    contraseñaInput.disabled = false;
                } else {
                    contraseñaInput.disabled = true;
                    contraseñaInput.value = ''; // Limpiar el campo de contraseña
                }
            });
    
            // Al cargar la página, verifica el estado inicial
            if (estadoSelect.value === "privada") {
                contraseñaInput.disabled = false;
            } else {
                contraseñaInput.disabled = true;
                contraseñaInput.value = ''; // Limpiar el campo de contraseña
            }
        });
    </script>
@endsection