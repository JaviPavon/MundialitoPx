<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Piloto;
use App\Models\Circuito;
use App\Models\Escuderia;
use Illuminate\Http\Request;

class CarreraController extends Controller
{

    public function index()
    {
        $pilotos = Piloto::all()->sortBy('posicion');
        $carreras = Carrera::all();
        $circuitos = Circuito::all()->sortBy('id');
        return view("CRUD_Carrera/inicio")
            ->with("carreras", $carreras)
            ->with("pilotos", $pilotos)
            ->with("circuitos", $circuitos);
    }

    public function create()
    {
        $pilotos = Piloto::all();
        $circuitos = Circuito::all();
        return view('CRUD_Carrera/agregar')
            ->with('pilotos', $pilotos)
            ->with('circuitos', $circuitos);
    }

    public function store(Request $request)
    {

        // VALIDACIÓN
        $pilotosSeleccionados = [];
        for ($i = 1; $i < 21; $i++) { 
            $id_piloto = $request->post('piloto' . $i);

            if (in_array($id_piloto, $pilotosSeleccionados)) {
                return redirect()->route("carreras.index")->with("error","Se ha introducido el mismo piloto más de una vez!");
            }

            if ($id_piloto == "-----") {
                return redirect()->route("carreras.index")->with("error","No se ha introducido un piloto en algún puesto!");
            }

            $pilotosSeleccionados[] = $id_piloto;
        }



        for ($i = 1; $i < 21; $i++) {
            $id_piloto = $request->post('piloto' . $i);
            $vuelta_rapida = $request->has('vuelta_rapida' . $i);
            $estado = $request->post('estado' . $i);

            if ($id_piloto !== "-----") {
                $carrera = new Carrera();
                $carrera->puesto = $i;
                $carrera->id_circuito = $request->post('circuito');
                $carrera->id_piloto = $id_piloto;
                $carrera->estado = $estado;
                $carrera->vuelta_rapida = $vuelta_rapida;

                $piloto = Piloto::find($carrera->id_piloto);
                $escuderia = Escuderia::find($piloto->id_escuderia);
                $puesto = $i;

                $puntos = $this->puntosPorPuesto($puesto);

                if ($vuelta_rapida) {
                    $puntos++;
                }

                $carrera->puntos = $puntos;
                $piloto->puntos += $puntos;
                $escuderia->puntos += $puntos;

                $carrera->save();
                $piloto->save();
                $escuderia->save();
            }
        }


        $this->actualizarPuestosEscuderias();
        $this->actualizarPuestosPilotos();


        return redirect()->route("carreras.index");
    }

    public function show($id)
    {
        $circuito = Circuito::find($id);

        return view('CRUD_Carrera/eliminar')
            ->with("circuito", $circuito);
    }

    public function edit($id)
    {
        $pilotos = Piloto::all();
        $circuito = Circuito::find($id);
        $carreras = Carrera::where('id_circuito', $id)->get();
        $circuitos = Circuito::all();
        return view("CRUD_Carrera/actualizar")
            ->with("pilotos", $pilotos)
            ->with("circuito", $circuito)
            ->with("circuitos", $circuitos)
            ->with("carreras", $carreras);
    }


    public function update(Request $request, $id)
    {
        $circuitoAEditar = Circuito::find($id);
        $carreras = Carrera::where('id_circuito', $circuitoAEditar->id)->get();
        $pilotosSeleccionados = [];

        // VALIDACIÓN
        for ($i = 1; $i < 21; $i++) {
            $id_piloto = $request->post('piloto' . $i);

            if (in_array($id_piloto, $pilotosSeleccionados)) {
                return redirect()->route("carreras.index")->with("error", "Se ha introducido el mismo piloto más de una vez!");
            }

            if ($id_piloto == "-----") {
                return redirect()->route("carreras.index")->with("error", "No se ha introducido un piloto en algún puesto!");
            }

            $pilotosSeleccionados[] = $id_piloto;
        }

        for ($i = 1; $i < 21; $i++) {
            $id_piloto = $request->post('piloto' . $i);
            $vuelta_rapida = $request->has('vuelta_rapida' . $i);
            $estado = $request->post('estado' . $i);


            if ($id_piloto !== null) {
                $piloto = Piloto::find($id_piloto);
                $carrera = $carreras->where('id_piloto', $id_piloto)->first();
                $escuderia = Escuderia::find($piloto->id_escuderia);

                $puntos = $carrera->puntos;

                $piloto->puntos -= $puntos;
                $escuderia->puntos -= $puntos;

                $carrera->save();
                $piloto->save();
                $escuderia->save();
                
                $carrera->puesto = $i;
                $carrera->id_circuito = $request->post('circuito');
                $carrera->estado = $estado;
                $carrera->vuelta_rapida = $vuelta_rapida;

                $puesto = $i;
                $puntos = $this->puntosPorPuesto($puesto);

                if ($vuelta_rapida) {
                    $puntos++;
                }

                $carrera->puntos = $puntos;
                $piloto->puntos += $puntos;
                $escuderia->puntos += $puntos;

                $carrera->save();
                $piloto->save();
                $escuderia->save();
            }
        }

        $this->actualizarPuestosEscuderias();
        $this->actualizarPuestosPilotos();

        return redirect()->route("carreras.index")->with("success", "Actualizado con exito!");
    }

    public function destroy($id)
    {
        $circuitoAEditar = Circuito::find($id);
        $carreras = Carrera::where('id_circuito', $circuitoAEditar->id)->get();
        foreach ($carreras as $carrera) {

            $piloto = $carrera->piloto;
            $escuderia = Escuderia::find($piloto->id_escuderia);

            $piloto->puntos -= $carrera->puntos;
            $escuderia->puntos -= $carrera->puntos;

            $piloto->save();
            $escuderia->save();
            $carrera->delete();
        }

        $this->actualizarPuestosEscuderias();
        $this->actualizarPuestosPilotos();


        return redirect()->route("carreras.index")->with("success", "Eliminado con exito!");
    }
}
