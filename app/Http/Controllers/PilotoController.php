<?php

namespace App\Http\Controllers;

use App\Models\Escuderia;
use App\Models\Piloto;
use App\Models\Pais;
use Illuminate\Http\Request;

class PilotoController extends Controller
{

    public function index()
    {
        $pilotos = Piloto::all()->sortBy('posicion');
        return view('CRUD_piloto/inicio')->with('pilotos',$pilotos);
    }

    public function create()
    {
        //crear
        $escuderias = Escuderia::all();
        $paises = Pais::all();
        return view('CRUD_piloto/agregar')->with('escuderias',$escuderias)->with('paises',$paises);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre'=> 'required',
            'biografia'=> 'required',
            'puntos'=> 'required',
            'posicion'=> 'required',
            'foto' => 'required|image|mimes:jpeg,png,svg|max:1024'
        ]);

        //para guardar datos en la BBDD
        $piloto = new Piloto();
        $piloto->posicion = $request->post('posicion');
        $piloto->nombre = $request->post('nombre');
        $piloto->dorsal = $request->post('dorsal');
        $piloto->biografia = $request->post('biografia');
        $piloto->puntos = $request->post('puntos');
        $piloto->id_escuderia = $request->post('escuderia');
        $piloto->id_pais = $request->post('pais');

        if($foto = $request->file('foto')){

            $rutaGuardarImg = 'fotos/';
            $fotoPiloto = date('YmdHis'). "." . $foto->getClientOriginalExtension();
            $foto->move($rutaGuardarImg, $fotoPiloto);
            $piloto['foto'] = "$fotoPiloto";
        }

        $piloto->save();

        //Actualiza los puntos de la escuderia
        $escuderias = Escuderia::all();
        foreach ($escuderias as $escuderia) {
            if ($escuderia->id == $piloto->id_escuderia){
                $escuderia->puntos += $request->post('puntos');
                $escuderia->save();
            }
        }


        $this -> actualizarPuestosPilotos();

        return redirect()->route("pilotos.index")->with("success","Agregado con exito!");
    }

    public function show($id)
    {
        //para obtener un registro de nuestra tabla
        $pilotos = Piloto::find($id);
        return view('CRUD_piloto/eliminar', compact('pilotos'));
    
    }

    public function edit($id)
    {
        //Para traer los datos que se van a editar y rellena el formulario
        $escuderias = Escuderia::all();
        $paises = Pais::all();
        $pilotos = Piloto::find($id);
        return view("CRUD_piloto/actualizar")
               ->with("escuderias",$escuderias)
               ->with("paises",$paises)
               ->with("pilotos",$pilotos);

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nombre'=> 'required',
            'biografia'=> 'required',
            'puntos'=> 'required',
            'posicion'=> 'required',
            'foto' => 'image|mimes:jpeg,png,svg|max:1024'
        ]);

        $piloto = Piloto::find($id);
        $escuderias = Escuderia::all();
        // dd($escuderias); Para probar las cosas
        //Quita los puntos de la escuderia del piloto que se actualiza

        foreach ($escuderias as $escuderia) {
            if ($escuderia->id == $piloto->id_escuderia){
                $escuderia->puntos -= $piloto->puntos;
                $escuderia->save();
            }
        }

        //Actualiza los datos en la BBDD
        
        $piloto->posicion = $request->post('posicion');
        $piloto->nombre = $request->post('nombre');
        $piloto->dorsal = $request->post('dorsal');
        $piloto->biografia = $request->post('biografia');
        $piloto->puntos = $request->post('puntos');
        $piloto->id_escuderia = $request->post('escuderia');
        $piloto->id_pais = $request->post('pais');
        if($foto = $request->file('foto')){

            if($piloto-> foto) {
                $rutaImagen = 'fotos/' . $piloto->foto;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'fotos/';
            $fotoPiloto = date('YmdHis'). "." . $foto->getClientOriginalExtension();
            $foto->move($rutaGuardarImg, $fotoPiloto);
            $piloto['foto'] = "$fotoPiloto";
        }
        $piloto->save();

        //Introduze los puntos a la escuderia del piloto que se actualiza (se hace después del cambio de piloto por si cambia de escuderia)
        
        foreach ($escuderias as $escuderia) {
            if ($escuderia->id == $piloto->id_escuderia){
                $escuderia->puntos += $request->post('puntos');
                $escuderia->save();
            }
        }
        

        $this -> actualizarPuestosPilotos();

        return redirect()->route("pilotos.index")->with("success","Actualizado con exito!");
    }

    public function destroy($id)
    {
        //Elimina un registro
        $piloto = Piloto::find($id);
        if($piloto-> foto) {
            $rutaImagen = 'fotos/' . $piloto->foto;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        $piloto->delete();
        return redirect()->route("pilotos.index")->with("success","Eliminado con exito!");
    }

}
