<?php

namespace App\Http\Controllers;

use App\Models\Circuito;
use App\Models\Pais;
use Illuminate\Http\Request;

class CircuitoController extends Controller
{
    public function index()
    {
        $circuitos = Circuito::all();
        return view('CRUD_Circuito/inicio', compact('circuitos'));
    }
    public function create()
    {
        $paises = Pais::all();
        return view('CRUD_Circuito/agregar')->with('paises', $paises);
    }

    public function store(Request $request)
    {


        $circuito = new Circuito();
        $circuito->nombre = $request->post('nombre');
        $circuito->alias = $request->post('alias');
        $circuito->fecha_circuito = $request->post('fecha_circuito');
        $circuito->id_pais = $request->post('pais');

        if($imgCircuito = $request->file('circuito')){
            $rutaGuardarImg = 'circuitos/';
            $imagenCircuito = date('YmdHis'). "." . $imgCircuito->getClientOriginalExtension();
            $imgCircuito->move($rutaGuardarImg, $imagenCircuito);
            $circuito['circuito'] = "$imagenCircuito";
        }

        if($imgSilueta = $request->file('silueta')){
            $rutaGuardarImg = 'siluetas/';
            $imagenSilueta = date('YmdHis'). "." . $imgSilueta->getClientOriginalExtension();
            $imgSilueta->move($rutaGuardarImg, $imagenSilueta);
            $circuito['silueta'] = "$imagenSilueta";
        }
        
        $circuito->save();

        return redirect()->route("circuitos.index")->with("success","Agregado con exito!");
    }

    public function show($id)
    {
        $circuitos = Circuito::find($id);
        return view('CRUD_Circuito/eliminar', compact('circuitos'));
    }

    public function edit($id)
    {
        $paises = Pais::all();
        $circuitos = Circuito::find($id);
        return view("CRUD_Circuito/actualizar")->with("paises", $paises)->with("circuitos", $circuitos);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'=> 'required', 
            'alias'=> 'required', 
            'pais'=> 'required', 
            'circuito' => 'image|mimes:jpeg,png,svg|max:1024',
            'silueta' => 'image|mimes:jpeg,png,svg|max:1024',
        ]);

        $circuito = Circuito::find($id);
        $circuito->nombre = $request->post('nombre');
        $circuito->alias = $request->post('alias');
        $circuito->fecha_circuito = $request->post('fecha_circuito');
        $circuito->id_pais = $request->post('pais');

        if($imgCircuito = $request->file('circuito')){

            if($circuito-> circuito) {
                $rutaImagen = 'circuitos/' . $circuito->circuito;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'circuitos/';
            $imagenCircuito = date('YmdHis'). "." . $imgCircuito->getClientOriginalExtension();
            $imgCircuito->move($rutaGuardarImg, $imagenCircuito);
            $circuito['circuito'] = "$imagenCircuito";
        }

        if($imgSilueta = $request->file('silueta')){

            if($circuito-> silueta) {
                $rutaImagen = 'siluetas/' . $circuito->silueta;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'siluetas/';
            $imagenSilueta = date('YmdHis'). "." . $imgSilueta->getClientOriginalExtension();
            $imgSilueta->move($rutaGuardarImg, $imagenSilueta);
            $circuito['silueta'] = "$imagenSilueta";
        }

        $circuito->save();

        return redirect()->route("circuitos.index")->with("success","Actualizado con exito!");
    }

    public function destroy($id)
    {
        $circuito = Circuito::find($id);
        
        if($circuito-> circuito) {
            $rutaImagen = 'circuitos/' . $circuito->circuito;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

        if($circuito-> silueta) {
            $rutaImagen = 'siluetas/' . $circuito->silueta;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        $circuito->delete();
        return redirect()->route("circuitos.index")->with("success","Eliminado con exito!");
    }
}
