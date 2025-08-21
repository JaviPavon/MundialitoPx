<?php

namespace App\Http\Controllers;

use App\Models\Circuito;
use App\Models\Escuderia;
use App\Models\Noticia;
use App\Models\NoticiaEscuderia;
use App\Models\NoticiaPiloto;
use App\Models\Piloto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NoticiaController extends Controller
{

    public function index()
    {
        $noticias = Noticia::with('usuario')->get();
        return view("CRUD_Noticia/inicio")->with("noticias", $noticias);
    }


    public function create()
    {
        $pilotos = Piloto::all();
        $escuderias = Escuderia::all();
        $circuitos = Circuito::all();
        return view("CRUD_Noticia/agregar", compact('pilotos', 'escuderias', 'circuitos'));
    }

    public function store(Request $request)
    {
        $pilotos = Piloto::all();
        $escuderias = Escuderia::all();
        $noticia = new Noticia();
        $noticia->titulo = $request->post('titulo');
        $noticia->cuerpo = $request->post('cuerpo');
        $noticia->user_id = Auth::id();
        if (is_numeric($request->post('circuito'))) {
            $noticia->id_circuito = $request->post('circuito');
        }

        if($miniatura = $request->file('miniatura')){

            $rutaGuardarImg = 'miniaturas/';
            $miniaturaNoticia = date('YmdHis'). "." . $miniatura->getClientOriginalExtension();
            $miniatura->move($rutaGuardarImg, $miniaturaNoticia);
            $noticia['miniatura'] = "$miniaturaNoticia";
        }

        $noticia->save();

        for ($i = 1; $i <= count($pilotos); $i++) {
            $id_piloto = $request->post('pilotos'.$i);
            if (is_numeric($id_piloto)) {
                $noticia_piloto = new NoticiaPiloto();
                $noticia_piloto->id_noticia = $noticia->id;
                $noticia_piloto->id_piloto = $id_piloto;
                $noticia_piloto->save();
            }
        }
        for ($i = 1; $i <= count($escuderias); $i++) {
            $id_escuderia = $request->post('escuderias'.$i);
            if (is_numeric($id_escuderia)) {
                $noticia_escuderia = new NoticiaEscuderia();
                $noticia_escuderia->id_noticia = $noticia->id;
                $noticia_escuderia->id_escuderia = $id_escuderia;
                $noticia_escuderia->save();
            }
        }
        return redirect()->route("noticias.index")->with("success","Agregado con exito!");
    }

    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);
        
        return view('CRUD_Noticia/eliminar', compact('noticia'));
    }

    public function edit($id)
    {
        $noticia = Noticia::find($id);
        return view("CRUD_Noticia/actualizar")->with("noticia", $noticia);
    }

    public function update(Request $request, $id)
    {
        $noticia = Noticia::find( $id );
        $noticia->titulo = $request->post('titulo');
        $noticia->cuerpo = $request->post('cuerpo');

        if($miniatura = $request->file('miniatura')){

            if($noticia-> miniatura) {
                $rutaImagen = 'miniaturas/' . $noticia->miniatura;
                if(file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }

            $rutaGuardarImg = 'miniaturas/';
            $miniaturaNoticia = date('YmdHis'). "." . $miniatura->getClientOriginalExtension();
            $miniatura->move($rutaGuardarImg, $miniaturaNoticia);
            $noticia['miniatura'] = "$miniaturaNoticia";
        }

        
        $noticia->save();

        return redirect()->route("noticias.index")->with("success","Actualizado con exito!");
    }

    public function destroy($id)
    {
        $noticia = Noticia::find($id);
        $noticia_pilotos = NoticiaPiloto::where('id_noticia', $id)->get();
        $noticia_escuderias = NoticiaEscuderia::where('id_noticia', $id)->get();
        if($noticia-> miniatura) {
            $rutaImagen = 'miniaturas/' . $noticia->miniatura;
            if(file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
        foreach ($noticia_pilotos as $noticia_piloto) {
            $noticia_piloto->delete();
        }
        foreach ($noticia_escuderias as $noticia_escuderia) {
            $noticia_escuderia->delete();
        }
        $noticia->delete();

        return redirect()->route("noticias.index")->with("success","Eliminado con exito!");
    }
}
