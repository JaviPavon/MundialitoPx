<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Canal;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    
    public function index()
    {
        $videos = Video::all();
        return view('CRUD_Video/inicio', compact('videos'));
    }


    public function create()
    {
        $canales = Canal::all();
        return view('CRUD_Video/agregar', compact('canales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'enlace' => 'required',
            'fecha_publicacion' => 'required',
        ]);
        $video = new Video();
        $video->nombre = $request->post('nombre');
        $video->enlace = $request->post('enlace');
        $video->fecha_publicacion = $request->post('fecha_publicacion');
        $video->id_canal = $request->post('canal');
        $video->save();
        $videos = Video::all();

        return redirect()->route("video.index")
            ->with("videos",$videos)
            ->with('success', 'Video creado correctamente.');
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('CRUD_Video/eliminar', compact('video'));
    }


    public function edit($id)
    {
        $canales = Canal::all();
        $video = Video::findOrFail($id);
        return view('CRUD_Video/actualizar', compact('video', 'canales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'enlace' => 'required',
            'fecha_publicacion' => 'required',
        ]);

        $video = Video::findOrFail($id);
        $video->nombre = $request->post('nombre');
        $video->enlace = $request->post('enlace');
        $video->fecha_publicacion = $request->post('fecha_publicacion');
        $video->id_canal = $request->post('canal');
        $video->save();
        $videos = Video::all();

        return redirect()->route("video.index")
            ->with("videos",$videos)
            ->with('success', 'Video actualizado correctamente.');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        $videos = Video::all();

        return redirect()->route("video.index")
            ->with("videos",$videos)
            ->with('success', 'Video eliminado correctamente.');
    }
}
