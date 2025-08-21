<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\Piloto;
use Illuminate\Http\Request;

class CanalController extends Controller
{

    public function index()
    {
        $canales = Canal::all();
        return view('CRUD_Canal/inicio', compact('canales'));
    }


    public function create()
    {
        $pilotos = Piloto::all();
        return view('CRUD_Canal/agregar', compact('pilotos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'enlace' => 'required',
        ]);

        $canal = Canal::create($request->all());
        $canal->id_piloto = $request->post('piloto');
        $canal->save();
        $canales = Canal::all();

        return redirect()->route("canal.index")
            ->with("canales",$canales)
            ->with('success', 'Canal creado correctamente.');
    }

    public function show($id)
    {
        $canal = Canal::findOrFail($id);
        return view('CRUD_Canal/eliminar', compact('canal'));
    }


    public function edit($id)
    {
        $pilotos = Piloto::all();
        $canal = Canal::findOrFail($id);
        return view('CRUD_Canal/actualizar', compact('canal', 'pilotos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'enlace' => 'required',
            'piloto' => 'required',
        ]);

        $canal = Canal::findOrFail($id);
        $canal->update($request->all());
        $canal->id_piloto = $request->post('piloto');
        $canal->save();
        $canales = Canal::all();

        return redirect()->route("canal.index")
            ->with("canales",$canales)
            ->with('success', 'Canal actualizado correctamente.');
    }

    public function destroy($id)
    {
        $canal = Canal::findOrFail($id);
        $canal->delete();
        $canales = Canal::all();

        return redirect()->route("canal.index")
            ->with("canales",$canales)
            ->with('success', 'Canal eliminado correctamente.');
    }
}
