<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fantasy;
use App\Models\Historial;
use App\Models\Jugador;
use App\Models\Liga;
use App\Models\Piloto_Juego;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JugadorController extends Controller
{
    public function index($id)
    {
        $jugador = Jugador::find($id);
        $liga = $jugador->liga;
        $jugadores = Jugador::where('id_liga', $liga->id)->get();
        $pilotos = Piloto_Juego::all();
        $fantasy = Fantasy::all()->first();
        $historiales = Historial::where('id_jugador', $jugador->id)->get();

        return view('CRUD_Jugador.inicio', compact('jugador', 'liga', 'pilotos', 'fantasy', 'jugadores', 'historiales'));
    }


    public function create($id)
    {
        $liga = Liga::where('id', $id)->firstOrFail();
        $jugadores = Jugador::where('id_liga', $id)->get();
        return view('CRUD_Jugador.agregar', compact('liga', 'jugadores'));
    }


    public function store(Request $request, $id)
    {
        $liga = Liga::where('id', $id)->firstOrFail();
        if ($liga->estado == 'publica') {
            $jugador = new Jugador();
            $jugador->puntos = 0;
            $jugador->puesto = 0;
            $jugador->saldo = 1500000;
            $jugador->id_liga = $liga->id;
            $jugador->id_usuario = Auth::id();
        
            $jugador->save();
        }else{
            $contraseña = $request->post('contraseña');
            if ($contraseña != $liga->contraseña_hash) {
                return redirect()->route("jugador.create", $liga->id)->with("error","La contraseña no es correcta");
            }else{
                $jugador = new Jugador();
                $jugador->puntos = 0;
                $jugador->puesto = 0;
                $jugador->saldo = 1500000;
                $jugador->id_liga = $liga->id;
                $jugador->id_usuario = Auth::id();
            
                $jugador->save();
            }
        }
        $this->actualizarPuestosJugadores();
        return redirect()->route("fantasy.index");
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function updatelider(Request $request, $id)
    {
        $jugador = Jugador::find($id);
        if ($jugador->piloto_juego_lider) {
            $jugador->saldo += $jugador->piloto_juego_lider->valor;
        }
        $id_piloto = $request->post('idpiloto');
        $jugador->id_piloto_juego_lider = $id_piloto;
        $piloto = Piloto_Juego::find($id_piloto);
        if ($piloto) {
            $jugador->saldo -= $piloto->valor;        
        }


        if ($request->post('idpiloto') == $jugador->id_piloto_juego) {
            $jugador->id_piloto_juego = null;
            if ($piloto) {
                $jugador->saldo += $piloto->valor;        
            }
        }

        $jugador->save();

        return redirect()->route("jugador.index", $id)->with("success","Piloto lider actualizado con éxito!");

    }
    public function update(Request $request, $id)
    {
        $jugador = Jugador::find($id);
        if ($jugador->piloto_juego) {
            $jugador->saldo += $jugador->piloto_juego->valor;
        }
        $id_piloto = $request->post('idpiloto');
        $jugador->id_piloto_juego = $id_piloto;
        $piloto = Piloto_Juego::find($id_piloto);
        if ($piloto) {
            $jugador->saldo -= $piloto->valor;        
        }


        if ($request->post('idpiloto') == $jugador->id_piloto_juego_lider) {
            $jugador->id_piloto_juego_lider = null;
            if ($piloto) {
                $jugador->saldo += $piloto->valor;        
            }
        }

        $jugador->save();

        return redirect()->route("jugador.index", $id)->with("success","Piloto secundario actualizado con éxito!");
    }

    public function destroy($id)
    {
        $jugador = Jugador::find($id);
        $jugador->delete();
        $this->actualizarPuestosJugadores();
        return redirect()->route("fantasy.index")->with("success","Eliminado con exito!");
    }

}
