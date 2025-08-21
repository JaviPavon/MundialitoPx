@extends('layout/plantilla')

@section("tituloPagina", "Actualizar una Carrera")

@section('contenido')

<div class="card">
    <div class="card-body">
        <div class="card-header">
            <h5 class="card-title">Actualizar una carrera</h5>
        </div>

        <p class="card-text">
            <form action="{{ route("carreras.update", $circuito->id)}}" method="POST">
                @csrf
                @method("PUT")
                <div class="row text-center justify-content-center">
                    <div class="col-4">
                        <label for="">Circuito</label>
                        <select class="form-select" name="circuito" id="circuito" required>
                            @foreach ($circuitos as $c)
                            <option value="{{ $c->id }}" {{ $circuito->id == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <br>

                @foreach ($carreras as $carrera)
                <div class="row">
                    <div class="col-1 offset-1">
                        <label>{{ $carrera->puesto }}º</label>
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="piloto{{$carrera->puesto}}" id="piloto{{$carrera->puesto}}" required>
                            <option value="-----">-----</option>
                            @foreach ($pilotos as $piloto)
                            <option value="{{ $piloto->id }}" {{ $carrera->piloto ? ($carrera->piloto->id == $piloto->id ? 'selected' : '') : '' }}>{{ $piloto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="checkbox" name="vuelta_rapida{{$carrera->puesto}}" id="vuelta_rapida{{$carrera->puesto}}" class="vuelta_rapida_checkbox" {{ $carrera->vuelta_rapida ? 'checked' : '' }}> Vuelta Rápida
                    </div>
                    <div class="col-2">
                        <select class="form-select" name="estado{{$carrera->puesto}}" id="estado{{$carrera->puesto}}">
                            <option value="">-- Estado --</option>
                            <option value="DNF" {{ $carrera->estado == 'DNF' ? 'selected' : '' }}>DNF</option>
                            <option value="DSQ" {{ $carrera->estado == 'DSQ' ? 'selected' : '' }}>DSQ</option>
                        </select>
                    </div>
                </div>
                <br>
                @endforeach

                <div class="text-center">
                    <div class="col">
                        <button class="btn btn-primary">Actualizar</button>
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
