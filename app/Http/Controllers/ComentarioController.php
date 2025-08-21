<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ComentarioController extends Controller
{
    public function index()
    {
        $comentarios = Comentario::all();
        return view("CRUD_Comentario/inicio")
                ->with('comentarios',$comentarios);
    }

    public function create()
    {
        $noticias = Noticia::all();
        return view('CRUD_Comentario/agregar')
                ->with('noticias', $noticias);
    }

    public function store(Request $request)
    {
        $comentario = new Comentario();
        $comentario->comentario = $request->post('comentario');
        $id = $request->post('noticia');
        $comentario->id_noticia = $id;
        $comentario->user_id = Auth::id();

        $comentario->save();

        return redirect()->back()->with("success","Agregado con exito!");
    }

    public function show($id)
    {
        $comentario = Comentario::find($id);
        return view('CRUD_Comentario/eliminar')->with('comentario', $comentario);
    }

    public function edit($id)
    {
        $comentario = Comentario::find($id);
        $noticias = Noticia::all();
        return view("CRUD_Comentario/actualizar", compact('comentario', 'noticias'));
    }


    public function update(Request $request, $id)
    {
        $comentario = Comentario::find( $id);
        $comentario->comentario = $request->post('comentario');
        $id = $request->post('noticia');
        $comentario->id_noticia = $id;

        $comentario->save();

        return redirect()->route("comentario.index")->with("success","Actualizado con exito!");
    }

    public function destroy( $id)
    {
        $comentario = Comentario::find($id);
        $comentario->delete();
        return redirect()->route("comentario.index")->with("success","Eliminado con exito!");
    }
}
