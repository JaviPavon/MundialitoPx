<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrera;
use App\Models\Circuito;
use App\Models\Fantasy;
use App\Models\Jornada;
use App\Models\Piloto_Juego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JornadaController extends Controller
{
    public function index()
    {
        $fantasy = Fantasy::all()->first();
        $circuitos = Circuito::all();
        $jornadas = Jornada::all()->sortBy('puesto');
    
        return view("CRUD_Jornada.inicio", compact('jornadas', 'circuitos', 'fantasy'));
    }


    public function create(Request $request)
    {

    }


    public function store(Request $request)
    {
        $circuito = $request->post('circuito');
        $pilotos = Piloto_Juego::all();
        $jornadas = Jornada::where('id_circuito', $circuito)->get();

        // Eliminar las jornadas existentes para el circuito especificado
        foreach ($jornadas as $jornada) {
            $jornada->delete();
        }

        // Iterar sobre los pilotos y verificar si tienen al menos una carrera en el circuito especificado
        foreach ($pilotos as $piloto) {
            $carrerasEnCircuito = Carrera::where('id_piloto', $piloto->piloto->id)
                                        ->where('id_circuito', $circuito)
                                        ->exists();

            if ($carrerasEnCircuito) {
                $jornada = new Jornada();
                $jornada->puesto = $piloto->piloto->posicion;
                $jornada->adelantamientos = 0;
                $jornada->sancion3sec = 0;
                $jornada->sancion5sec = 0;
                $jornada->amonestaciones = 0;
                $jornada->id_piloto_juego = $piloto->id;
                $jornada->id_circuito = $circuito;

                $jornada->save();
                $this->actualizarPuntosJornada($jornada->id);
            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Request $request)
{
    $idcircuito = $request->post('circuito_id');
    $circuito = Circuito::where('id', $idcircuito)->first();
    $jornadas = Jornada::where('id_circuito', $idcircuito)->orderBy('puesto')->get();

    // Otra forma de obtener la misma información es utilizando el método encuentraJornada
    // $data = $this->encuentraJornada($idcircuito);
    // extract($data);

    return view("CRUD_Jornada.actualizar", compact('jornadas', 'circuito'));
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function jornadasPorCircuito(Request $request)
    {
        $circuitoId = $request->get('circuitoId');

        // Cargar las jornadas con las relaciones necesarias
        $jornadas = Jornada::with('piloto_juego.piloto')
                            ->where('id_circuito', $circuitoId)
                            ->orderBy('puesto')
                            ->get();

        return response()->json(['jornadas' => $jornadas]);
    }

    
    public function pasoAQ2($id) {
        $jornada = Jornada::find($id);
        if ($jornada->qually2 == 1) {
            $jornada->qually2 = false;
        }else {
            $jornada->qually2 = true;
        }
        $jornada->save();

        $this->actualizarPuntosJornada($id);
    
        return redirect()->back();
    }

    public function pasoAQ3($id) {
        $jornada = Jornada::find($id);
        if ($jornada->qually3 == 1) {
            $jornada->qually3 = false;
        }else {
            $jornada->qually3 = true;
        }
        $jornada->save();

        $this->actualizarPuntosJornada($id);
    
        return redirect()->back();
    }
    public function masAdelantamiento($id) {
        $jornada = Jornada::find($id);
        $jornada->adelantamientos++;
        $jornada->save();

        $this->actualizarPuntosJornada($id);
    
        return redirect()->back();
    }
    
    public function menosAdelantamiento($id) {
        $jornada = Jornada::find($id);
        $jornada->adelantamientos--;
        $jornada->save();

        $this->actualizarPuntosJornada($id);
    
        return redirect()->back();
    }

    public function masAmonestacion($id){
        $jornada = Jornada::find($id);
        $jornada->amonestaciones++;
        $jornada->save();

        $this->actualizarPuntosJornada($id);

        return redirect()->back();
    }

    public function menosAmonestacion($id){
        $jornada = Jornada::find($id);
        $jornada->amonestaciones--;
        $jornada->save();

        $this->actualizarPuntosJornada($id);

        return redirect()->back();
    }

    public function masSancion3($id){
        $jornada = Jornada::find($id);
        $jornada->sancion3sec++;
        $jornada->save();

        $this->actualizarPuntosJornada($id);

        return redirect()->back();
    }

    public function menosSancion3($id){
        $jornada = Jornada::find($id);
        $jornada->sancion3sec--;
        $jornada->save();

        $this->actualizarPuntosJornada($id);

        return redirect()->back();
    }
    public function masSancion5($id){
        $jornada = Jornada::find($id);
        $jornada->sancion5sec++;
        $jornada->save();

        $this->actualizarPuntosJornada($id);

        return redirect()->back();
    }

    public function menosSancion5($id){
        $jornada = Jornada::find($id);
        $jornada->sancion5sec--;
        $jornada->save();

        $this->actualizarPuntosJornada($id);

        return redirect()->back();
    }

}
