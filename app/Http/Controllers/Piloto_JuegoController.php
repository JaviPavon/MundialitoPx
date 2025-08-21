<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Piloto;
use App\Models\Piloto_Juego;
use Illuminate\Http\Request;

class Piloto_JuegoController extends Controller
{
    public function index()
    {
        $pilotos = Piloto_Juego::with('jugador')->get();
        return view("CRUD_Piloto_J/inicio")->with("pilotos", $pilotos);
    }


    public function create()
{
    $pilotos = Piloto::all();
    $pilotos_Juego = Piloto_Juego::all();

    // Filtrar pilotos que no están en los pilotos de juego
    $pilotosSeCrean = $pilotos->reject(function ($piloto) use ($pilotos_Juego) {
        return $pilotos_Juego->contains('id_piloto', $piloto->id);
    });

    // Filtrar pilotos de juego que no están en los pilotos
    $pilotosSeBorran = $pilotos_Juego->reject(function ($pilotoJ) use ($pilotos) {
        return $pilotos->contains('id', $pilotoJ->id_piloto);
    });

    return view("CRUD_Piloto_J/agregar", compact('pilotosSeCrean', 'pilotosSeBorran'));
}


public function store(Request $request)
{
    // Obtener los ids de los pilotos que se van a borrar
    $pilotos_ids_borrar = $request->input('pilotos_ids_borrar');
    // Verificar si hay pilotos para borrar antes de ejecutar la consulta
    if (!empty($pilotos_ids_borrar)) {
        // Eliminar los pilotos de juego que corresponden a los ids recibidos
        Piloto_Juego::whereIn('id', $pilotos_ids_borrar)->delete();
    }

    // Crear nuevos pilotos de juego
    $pilotos_ids = $request->input('pilotos_ids');

    if (!empty($pilotos_ids)) {
        foreach ($pilotos_ids as $piloto_id) {
            $piloto_juego = new Piloto_Juego();
            $piloto_juego->puntos = 0;
            $piloto_juego->valor = 0;
            $piloto_juego->id_piloto = $piloto_id;
            $piloto_juego->save();
        }
    }

    return redirect()->route("pilotos_juego.index")->with("success", "¡Pilotos Juego sincronizados con éxito!");
}


    public function show($id)
    {
    }

    public function edit($id)
    {
        $piloto = Piloto_Juego::find($id);
        return view("CRUD_Piloto_J/actualizar")->with('piloto', $piloto);
    }

    public function update(Request $request, $id)
    {
        
        $piloto = Piloto_Juego::find($id);
        $valor_anterior = $piloto->valor;
        $piloto->valor = $request->post('valor');
        
        $piloto->save();

        $mensaje = "Actualizado de " . $valor_anterior ."€ a " . $piloto->valor . "€ el valor de " . $piloto->piloto->nombre . " con éxito!";

        return redirect()->route("pilotos_juego.index")->with("success",$mensaje);
    }

    public function destroy($id)
    {
    }

}
