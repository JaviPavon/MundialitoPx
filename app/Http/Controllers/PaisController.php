<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        $paises = Pais::all();
        return view('CRUD_Pais/inicio')->with('paises',$paises);
    }


    public function create()
    {
        return view('CRUD_Pais/agregar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=> 'required', 'bandera' => 'required|image|mimes:jpeg,png,svg|max:1024'
        ]);

        $pais = $request->all();

        if($bandera = $request->file('bandera')){
            $rutaGuardarImg = 'banderas/';
            $banderaPais = date('YmdHis'). "." . $bandera->getClientOriginalExtension();
            $bandera->move($rutaGuardarImg, $banderaPais);
            $pais['bandera'] = "$banderaPais";
        }
        
        Pais::create($pais);

        return redirect()->route("paises.index")->with("success","Agregado con exito!");
    }

    public function show($id)
    {
        $pais = Pais::find($id);
        return view('CRUD_Pais/eliminar', compact('pais'));
    }

    public function edit($id)
    {
        $pais = Pais::find($id);
        return view('CRUD_Pais/actualizar', compact('pais'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=> 'required',
            'bandera' => 'image|mimes:jpeg,png,svg|max:1024'
        ]);

        $pais = Pais::find($id);

        $pais->nombre = $request->nombre;


        if($bandera = $request->file('bandera')){

            if($pais-> bandera) {
                $rutaImagen = 'banderas/' . $pais->bandera;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'banderas/';
            $banderaPais = date('YmdHis'). "." . $bandera->getClientOriginalExtension();
            $bandera->move($rutaGuardarImg, $banderaPais);
            $pais['bandera'] = "$banderaPais";
        }
        $pais->save();
        return redirect()->route('paises.index')->with('success','Actualizado con exito!');
    }

    public function destroy($id)
    {
        $pais = Pais::find($id);
        if($pais-> bandera) {
            $rutaImagen = 'banderas/' . $pais->bandera;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        $pais->delete();

        return redirect()->route('paises.index')->with('success','Eliminado con exito!');
    }
}
