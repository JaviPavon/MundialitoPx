<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Models\Escuderia;
use Illuminate\Http\Request;

class EscuderiaController extends Controller
{
    public function index()
    {
        $escuderias = Escuderia::all()->sortBy('posicion');
        return view('CRUD_Escuderia/inicio', compact('escuderias'));
    }

    public function create()
    {
        //crear
        $paises = Pais::all();
        return view('CRUD_Escuderia/agregar')->with('paises', $paises);
    }

    public function store(Request $request)
    {
        $request->validate([
            'posicion'=> 'required', 
            'nombre'=> 'required', 
            'alias'=> 'required', 
            'descripcion'=> 'required', 
            'pais'=> 'required', 
            'logo' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'monoplaza' => 'required|image|mimes:jpeg,png,svg|max:1024',
        ]);

        //para guardar datos en la BBDD
        $escuderia = new Escuderia();
        $escuderia->posicion = $request->post('posicion');
        $escuderia->nombre = $request->post('nombre');
        $escuderia->alias = $request->post('alias');
        $escuderia->descripcion = $request->post('descripcion');
        $escuderia->puntos = $request->post('puntos');
        $escuderia->id_pais = $request->post('pais');

        if($logo = $request->file('logo')){

            $rutaGuardarImg = 'logos/';
            $imagenlogo = date('YmdHis'). "." . $logo->getClientOriginalExtension();
            $logo->move($rutaGuardarImg, $imagenlogo);
            $escuderia['logo'] = "$imagenlogo";
        }

        if($monoplaza = $request->file('monoplaza')){

            $rutaGuardarImg = 'monoplazas/';
            $imagenMonoplaza = date('YmdHis'). "." . $monoplaza->getClientOriginalExtension();
            $monoplaza->move($rutaGuardarImg, $imagenMonoplaza);
            $escuderia['monoplaza'] = "$imagenMonoplaza";
        }
        
        $escuderia->save();

        $this -> actualizarPuestosEscuderias();

        return redirect()->route("escuderias.index")->with("success","Agregado con exito!");
    }

    public function show($id)
    {
        //para obtener un registro de nuestra tabla
        
        $escuderias = Escuderia::find($id);
        return view('CRUD_Escuderia/eliminar', compact('escuderias'));
    
    }

    public function edit($id)
    {
        //Para traer los datos que se van a editar y rellena el formulario
        $paises = Pais::all();
        $escuderias = Escuderia::find($id);
        return view("CRUD_Escuderia/actualizar")->with("paises", $paises)->with("escuderias", $escuderias);

    }

  
    public function update(Request $request, $id)
    {

        $request->validate([
            'posicion'=> 'required', 
            'nombre'=> 'required', 
            'alias'=> 'required', 
            'descripcion'=> 'required', 
            'pais'=> 'required', 
            'logo' => 'image|mimes:jpeg,png,svg|max:1024',
            'monoplaza' => 'image|mimes:jpeg,png,svg|max:1024',
        ]);

        //Actualiza los datos en la BBDD
        $escuderia = Escuderia::find($id);
        $escuderia->posicion = $request->post('posicion');
        $escuderia->nombre = $request->post('nombre');
        $escuderia->alias = $request->post('alias');
        $escuderia->descripcion = $request->post('descripcion');
        $escuderia->puntos = $request->post('puntos');
        $escuderia->id_pais = $request->post('pais');

        if($logo = $request->file('logo')){

            if($escuderia-> logo) {
                $rutaImagen = 'logos/' . $escuderia->logo;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'logos/';
            $imagenlogo = date('YmdHis'). "." . $logo->getClientOriginalExtension();
            $logo->move($rutaGuardarImg, $imagenlogo);
            $escuderia['logo'] = "$imagenlogo";
        }

        if($monoplaza = $request->file('monoplaza')){

            if($escuderia-> monoplaza) {
                $rutaImagen = 'monoplazas/' . $escuderia->monoplaza;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'monoplazas/';
            $imagenMonoplaza = date('YmdHis'). "." . $monoplaza->getClientOriginalExtension();
            $monoplaza->move($rutaGuardarImg, $imagenMonoplaza);
            $escuderia['monoplaza'] = "$imagenMonoplaza";
        }


        $escuderia->save();

        $this -> actualizarPuestosEscuderias();

        return redirect()->route("escuderias.index")->with("success","Actualizado con exito!");
    }

  
    public function destroy($id)
    {
        //Elimina un registro
        $escuderia = Escuderia::find($id);

        if($escuderia-> logo) {
            $rutaImagen = 'logos/' . $escuderia->logo;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        if($escuderia-> monoplaza) {
            $rutaImagen = 'monoplazas/' . $escuderia->monoplaza;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        $escuderia->delete();
        return redirect()->route("escuderias.index")->with("success","Eliminado con exito!");
    }


}
