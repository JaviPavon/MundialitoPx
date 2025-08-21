<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jugador;
use App\Models\Liga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LigaController extends Controller
{
    public function index()
    {
        $idUsuarioActual = Auth::id();
        
        $jugadoresUsuarioActual = Jugador::where('id_usuario', $idUsuarioActual)->pluck('id_liga')->toArray();
        $ligas = Liga::whereNotIn('id', $jugadoresUsuarioActual)->get();
        $ligas = $ligas->sortByDesc(function ($liga) {
            return $liga->jugador->count();
        });
    
        return view("CRUD_Liga.inicio")->with('ligas', $ligas);
    }
    public function create()
    {
        return view("CRUD_Liga/agregar");
    }

    public function store(Request $request)
{
    $liga = new Liga();
    $estado = $request->post('estado');
    $nombre = $request->post('nombre');
    $liga->nombre = $nombre;
    $liga->estado = $estado;


    if ($estado == 'privada') {
        $contraseña = $request->post('contraseña');
        $liga->contraseña_hash = $contraseña;
    }
    $liga->save();

    $jugador = new Jugador();
    $jugador->puntos = 0;
    $jugador->puesto = 0;
    $jugador->saldo = 1500000;
    $jugador->id_liga = $liga->id;
    $jugador->id_usuario = Auth::id();

    $jugador->save();

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
}
