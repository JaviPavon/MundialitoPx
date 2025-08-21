    @extends('layout/plantilla')

    @section("tituloPagina", "Crear una nueva carrera")

    @section('contenido')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h5 class="card-title">Crear una Carrera</h5>
            </div>

            <p class="card-text">
                <form action="{{ route("carreras.store")}}" method="POST">
                    @csrf
                    <div class="row text-center justify-content-center">
                        <div class="col-4">
                            <label for="">Circuito</label>
                            <select class="form-select" name="circuito" id="circuito" required>
                                @foreach ($circuitos as $circuito)
                                <option value="{{ $circuito->id }}">{{ $circuito->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>

                    @for ($i = 1; $i <= 20; $i++)
                    <div class="row justify-content-center">
                        <div class="col-1 offset-1">
                            <label>{{ $i }}º</label>
                        </div>
                        <div class="col-2">
                            <select class="form-select" name="piloto{{$i}}" id="piloto{{$i}}" required>
                                <option value="-----">-----</option>
                                @foreach ($pilotos as $piloto)
                                <option value="{{ $piloto->id }}">{{ $piloto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <input type="checkbox" name="vuelta_rapida{{$i}}" id="vuelta_rapida{{$i}}" class="vuelta_rapida_checkbox"> Vuelta Rápida
                        </div>
                        <div class="col-2">
                            <select class="form-select" name="estado{{$i}}" id="estado{{$i}}">
                                <option value="">-- Estado --</option>
                                <option value="DNF">DNF</option>
                                <option value="DSQ">DSQ</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    @endfor

                    <div class="text-center">
                        <div class="col">
                            <button class="btn btn-primary">Crear</button>
                            <a href="{{ route("carreras.index") }}" class="btn btn-info">Volver</a>
                        </div>
                    </div>
                </form>
            </p>

        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.vuelta_rapida_checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        checkboxes.forEach(cb => {
                            if (cb !== this) {
                                cb.disabled = true;
                            }
                        });
                    } else {
                        checkboxes.forEach(cb => {
                            cb.disabled = false;
                        });
                    }
                });
            });
        });
    </script>
    @endpush
