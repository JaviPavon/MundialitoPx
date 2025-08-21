<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Circuito;
use App\Models\Fantasy;
use App\Models\Jornada;
use Illuminate\Support\Facades\Auth;
use App\Models\Liga;
use App\Models\Jugador;
use Illuminate\Http\Request;

class FantasyController extends Controller
{
    public function index()
{
    $idUsuarioActual = Auth::id();
    $jugadoresUsuarioActual = Jugador::where('id_usuario', $idUsuarioActual)->get();
    $fantasy = Fantasy::all()->first();

    return view("CRUD_Fantasy.inicio")
            ->with("jugadores", $jugadoresUsuarioActual)
            ->with("fantasy", $fantasy);
}

    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        $fantasy = Fantasy::all()->first();
        $idcircuito = $fantasy->siguiente_circuito;
        $jornadas = Jornada::where('id_circuito', $idcircuito)->orderBy('puesto')->get();
        $circuito = Circuito::find($idcircuito);

        return view("CRUD_Fantasy.sincronizar")
        ->with("jornadas", $jornadas)
        ->with("circuito", $circuito);
    }

    public function edit()
    {
        $circuitos = Circuito::all();
        $fantasy = Fantasy::all()->first();

        return view("CRUD_Fantasy.actualizar")
        ->with("circuitos", $circuitos)
        ->with("fantasy", $fantasy);
    }

    public function update(Request $request)
    {
        $fantasy = Fantasy::all()->first();
        $circuito = $request->post('circuito');

        $fantasy->siguiente_circuito = $circuito;
        $fantasy->save();

        return view("inicio");
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

    public function sincronizarPuntaje(){

        $fantasy = Fantasy::all()->first();
        $idcircuito = $fantasy->siguiente_circuito;
        $jugadores = Jugador::all();
        $jornadas = Jornada::where('id_circuito', $idcircuito)->get();
        foreach ($jugadores as $jugador) {
            
            foreach ($jornadas as $jornada) {
                if ($jornada->piloto_juego == $jugador->piloto_juego_lider) {
                    $puntos = $jornada->puntos;
                    $jugador->puntos += $puntos * 1.5;
                }
                elseif($jornada->piloto_juego == $jugador->piloto_juego){
                    $puntos = $jornada->puntos;
                    $jugador->puntos += $puntos;
                }
            }
            $this->guardarHistorial(
                $jugador->id,
                $jugador->id_piloto_juego_lider,
                $jugador->id_piloto_juego,
                $idcircuito);
            
            $jugador->save();
        
            $this->actualizarPuestosJugadores();
        }

        foreach ($jornadas as $jornada) {
            $puntos = $jornada->puntos;

            $piloto = $jornada->piloto_juego;
            $piloto->puntos += $puntos;
            $piloto->save();
        }
        $this->vaciarCamposGeneral();

        return view("inicio");
    }
}
