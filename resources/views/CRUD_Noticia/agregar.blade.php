@extends('layout/plantilla')

@section("tituloPagina", "Crear una nueva Noticia")

@section('contenido')

<div class="card">
        <div class="card-body">
            <div class="card-header"><h5 class="card-title">Crear una Noticia</h5></div>

            <p class="card-text">
                <form action="{{ route("noticias.store")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for=""><h4>Título</h4></label>
                    <input type="text" name="titulo" class="form-control" required>
                    <br>
                    <label for=""><h4>Cuerpo</h4></label>
                    <br>
                    <textarea name="cuerpo" id="cuerpo" cols="30" rows="10" required></textarea>
                    <br>
                    <br>
                    <div id="pilotos-container">
                        <h4>Pilotos</h4>
                        <select id="pilotos1" class="form-select form-select-lg mb-3" aria-label="Large select example" name="pilotos1">
                            <option selected>Selección de pilotos relacionados</option>
                            @foreach ($pilotos as $piloto)
                                <option value="{{ $piloto->id }}">{{ $piloto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div id="escuderias-container">
                        <h4>Escuderias</h4>
                        <select id="escuderias1" name="escuderias1"  class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option selected>Selección de escuderias relacionados</option>
                            @foreach ($escuderias as $escuderia )
                                <option value="{{ $escuderia->id }}">{{ $escuderia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <h4>Circuito</h4>
                    <select name="circuito" id="circuito" class="form-select form-select-lg mb-3" aria-label="Large select example">
                        <option selected>Selección de circuito relacionado</option>
                        @foreach ($circuitos as $circuito )
                            <option value="{{ $circuito->id }}">{{ $circuito->nombre }}</option>
                        @endforeach
                    </select>
                    <br>
                    <br>
                    <img id="imagenSeleccionada" alt="">
                    <br>
                    <input name="miniatura" id="miniatura" type="file" class="hidden">
                    <br>
                    <br>
                    <button class="btn btn-primary">Crear</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let selectCounter = 1;
    
            document.getElementById('pilotos1').addEventListener('change', function() {
                // Crear una copia del select
                const newSelect = this.cloneNode(true);
    
                // Incrementar el contador y actualizar el atributo name
                selectCounter++;
                newSelect.name = 'pilotos' + selectCounter;
                newSelect.id = 'pilotos' + selectCounter;
    
                // Limpiar la selección del nuevo select
                newSelect.selectedIndex = 0;
    
                // Agregar el nuevo select al DOM
                document.getElementById('pilotos-container').appendChild(newSelect);
    
                // Agregar un event listener al nuevo select para que también pueda duplicarse
                newSelect.addEventListener('change', function() {
                    const newerSelect = this.cloneNode(true);
                    selectCounter++;
                    newerSelect.name = 'pilotos' + selectCounter;
                    newerSelect.id = 'pilotos' + selectCounter;
                    newerSelect.selectedIndex = 0;
                    document.getElementById('pilotos-container').appendChild(newerSelect);
                    newerSelect.addEventListener('change', arguments.callee);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let selectCounter = 1;
    
            document.getElementById('escuderias1').addEventListener('change', function() {
                // Crear una copia del select
                const newSelect = this.cloneNode(true);
    
                // Incrementar el contador y actualizar el atributo name
                selectCounter++;
                newSelect.name = 'escuderias' + selectCounter;
                newSelect.id = 'escuderias' + selectCounter;
    
                // Limpiar la selección del nuevo select
                newSelect.selectedIndex = 0;
    
                // Agregar el nuevo select al DOM
                document.getElementById('escuderias-container').appendChild(newSelect);
    
                // Agregar un event listener al nuevo select para que también pueda duplicarse
                newSelect.addEventListener('change', function() {
                    const newerSelect = this.cloneNode(true);
                    selectCounter++;
                    newerSelect.name = 'escuderias' + selectCounter;
                    newerSelect.id = 'escuderias' + selectCounter;
                    newerSelect.selectedIndex = 0;
                    document.getElementById('escuderias-container').appendChild(newerSelect);
                    newerSelect.addEventListener('change', arguments.callee);
                });
            });
        });
    </script>
@endsection