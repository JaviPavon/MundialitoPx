@extends('Mundialito/plantilla')

@section("tituloPagina", "Crear una nueva Liga")

@section('contenido')
<br>
<br>
<br>
<div class="card ">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear una Liga</h5></div>

            <form action="{{ route("mundialito.crearliga") }}" method="POST">
                @csrf
                <label for="estado">Estado</label>
                <select class="form-select" name="estado" id="estado" required>
                    <option value="publica">Pública</option>
                    <option value="privada">Privada</option>
                </select>
            
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" maxlength="20" required>
                <span id="mensajeAlerta" class="alerta">Máximo 20 caracteres permitidos</span>
                <br>
            
                <label for="contraseña">Contraseña</label>
                <br>
                <input type="password" name="contraseña" class="form-control" id="contraseña" required>
                <br>
                <br>
            
                <button class="btn btn-primary">Crear</button>
                <a href="{{ route("mundialito.listaligas") }}" class="btn btn-info">Volver</a>
            </form>
            </p>
           
        </div>
    </div>

    <script>
        const inputNombre = document.getElementById('nombre');
        const mensajeAlerta = document.getElementById('mensajeAlerta');

        inputNombre.addEventListener('input', function() {
            if (inputNombre.value.length > 20) {
                mensajeAlerta.style.display = 'inline';
            } else {
                mensajeAlerta.style.display = 'none';
            }
        });

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
    <style>
        body {
            background-color: #0C005A;
        }
        .alerta {
            color: red;
            display: none;
        }
    </style>
@endsection