<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Canal;
use App\Models\Carrera;
use App\Models\Circuito;
use App\Models\Comentario;
use App\Models\Escuderia;
use App\Models\Fantasy;
use App\Models\Historial;
use App\Models\Jornada;
use App\Models\Jugador;
use App\Models\Liga;
use App\Models\Noticia;
use App\Models\NoticiaEscuderia;
use App\Models\NoticiaPiloto;
use App\Models\Piloto;
use App\Models\Piloto_Juego;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MundialitoController extends Controller
{
    public function index()
    {
        return view("Mundialito/inicio");
    }



    public function f1tv()
    {
        $canales = Canal::with('video')->get();
        return response()->json($canales);
    }

    public function getJornadasByPiloto($id_piloto)
    {
        $jornadas = Jornada::where('id_piloto_juego', $id_piloto)->get();
        return response()->json($jornadas);
    }

    public function getHistorial($id)
    {
        $historial = Historial::where('id_jugador', $id)
                            ->with(['piloto_juego_lider.piloto', 'piloto_juego.piloto'])
                            ->get();

        $formattedHistorial = $historial->map(function ($item) {
            return [
                'numero_jornada' => $item->numero_jornada,
                'piloto_juego_lider' => $item->piloto_juego_lider ? $item->piloto_juego_lider->piloto->nombre : 'Vacío',
                'piloto_juego' => $item->piloto_juego ? $item->piloto_juego->piloto->nombre : 'Vacío',
            ];
        });

        return response()->json($formattedHistorial);
    }



    public function calendario($circuitoId = null)
{
    $pilotos = Piloto::all();
    $circuitos = Circuito::all();
    $circuito = $circuitoId ? Circuito::find($circuitoId) : $circuitos->first();
    $carreras = Carrera::where('id_circuito', $circuito->id)->get();
    $videos = Video::where('fecha_publicacion', $circuito->fecha_circuito)->get();
    $fantasy = Fantasy::all()->first();

    return view("Mundialito/calendario", compact('circuito', 'circuitos', 'carreras', 'videos', 'pilotos', 'fantasy'));
}


    public function noticias(Request $request)
    {
        $query = Noticia::query();
        $noticias = $query->get()->sortByDesc('id');

        $filtroPiloto = null;
        $filtroEscuderia = null;
        $filtroCircuito = null;
    
        if ($request->filled('piloto')) {
            $filtroPiloto = Piloto::find($request->piloto);
            $query->whereHas('pilotos', function($q) use ($request) {
                $q->where('pilotos.id', $request->piloto);
            });
        }
    
        if ($request->filled('escuderia')) {
            $filtroEscuderia = Escuderia::find($request->escuderia);
            $query->whereHas('escuderias', function($q) use ($request) {
                $q->where('escuderia.id', $request->escuderia);
            });
        }
    
        if ($request->filled('circuito')) {
            $filtroCircuito = Circuito::find($request->circuito);
            $query->where('id_circuito', $request->circuito);
        }
    
        
        
        $noticiasPopulares = $query->withCount('comentarios')
            ->orderBy('comentarios_count', 'desc')
            ->get();
        
        $pilotos = Piloto::all();
        $escuderias = Escuderia::all();
        $circuitos = Circuito::all();
        $fantasy = Fantasy::first();
        
        return view("Mundialito/noticia", compact('noticias', 'noticiasPopulares', 'circuitos','pilotos','escuderias', 'fantasy', 'filtroPiloto', 'filtroEscuderia', 'filtroCircuito'));
    }

    public function detalleNoticia($id)
    {
        $noticia = Noticia::find($id);
        $pilotosRelacionados = NoticiaPiloto::where('id_noticia', $id)->get();
        $escuderiasRelacionadas = NoticiaEscuderia::where('id_noticia', $id)->get();
        $comentarios = Comentario::where('id_noticia', $id)->get();

        return view("Mundialito/detalleNoticia", compact('noticia', 'pilotosRelacionados', 'escuderiasRelacionadas', 'comentarios'));
    }

    public function clasificacion()
    {
        $pilotos = Piloto::all()->sortBy('posicion');
        $escuderias = Escuderia::all()->sortBy('posicion');
        $carreras = Carrera::all();
        $circuitos = Circuito::whereIn('id', Carrera::pluck('id_circuito')->unique())->get();
        return view("Mundialito/clasificacion", compact('pilotos', 'escuderias', 'carreras', 'circuitos'));
    }
    
    public function pilotos()
    {
        $pilotosc = Piloto::all()->sortBy('posicion');
        $pilotos = Piloto::all()->sortBy('id_escuderia');

        $pilotosPorEscuderia = [];
        $pilotosExtra = [];

        foreach ($pilotos->groupBy('id_escuderia') as $escuderiaPilotos) {
            $chunks = $escuderiaPilotos->chunk(2);
            foreach ($chunks as $chunk) {
                if ($chunk->count() == 2) {
                    $pilotosPorEscuderia[] = $chunk;
                } else {
                    $pilotosExtra[] = $chunk->first();
                }
            }
        }

        return view("Mundialito/pilotos", compact('pilotosPorEscuderia', 'pilotosExtra', 'pilotosc'));
    }
    
    public function detallePiloto($id)
    {
        $piloto = Piloto::find($id);
        $carreras = Carrera::where('id_piloto', $id)->get();
        return view("Mundialito/detallePiloto", compact('piloto','carreras'));
    }

    public function escuderias()
    {
        $escuderiasc = Escuderia::all()->sortBy('posicion');
        $escuderias = Escuderia::all();
        return view("Mundialito/escuderias", compact('escuderias','escuderiasc'));
    }

    public function detalleEscuderia($id)
    {
        $escuderia = Escuderia::find($id);
        $pilotos = Piloto::where('id_escuderia', $id)->get();
        $carreras = Carrera::whereIn('id_piloto', $pilotos->pluck('id'))->get();

        return view("Mundialito/detalleEscuderia", compact('escuderia', 'pilotos', 'carreras'));
    }


    public function crearComentario(Request $request, $id)
    {
        $comentario = new Comentario();
        $comentario->comentario = $request->post('comentario');
        $comentario->id_noticia = $id;
        $comentario->user_id = Auth::id();

        $comentario->save();

        return redirect()->back()->with("success","Agregado con exito!");
    }



    public function fantasy()
    {
        $idUsuarioActual = Auth::id();
        $jugadores = Jugador::where('id_usuario', $idUsuarioActual)->get();
        $pilotos = Piloto_Juego::all();
        $circuitos = Circuito::all();
        $fantasy = Fantasy::all()->first();
        
        return view("Mundialito/fantasy", compact('jugadores', 'circuitos', 'pilotos', 'fantasy'));
    }


    public function liga($id)
{
    $jugador = Jugador::find($id);
    $liga = $jugador->liga;
    $jugadores = Jugador::where('id_liga', $liga->id)->get()->sortBy('puesto');
    $pilotoJuego = $jugador->piloto_juego;
    $pilotoJuegoLider = $jugador->piloto_juego_lider;

    $query = Piloto_Juego::query();

    if ($pilotoJuego) {
        $query->where('id', '!=', $pilotoJuego->id);
    }

    if ($pilotoJuegoLider) {
        $query->where('id', '!=', $pilotoJuegoLider->id);
    }

    $pilotos = $query->get();

    $fantasy = Fantasy::all()->first();
    $circuito = Circuito::find($fantasy->siguiente_circuito);
    $historiales = Historial::where('id_jugador', $jugador->id)->get();

    return view('Mundialito/liga', compact('jugador', 'liga', 'pilotos', 'fantasy', 'jugadores', 'historiales', 'circuito'));
}



    public function listaligas()
    {
        $idUsuarioActual = Auth::id();
        
        $jugadoresUsuarioActual = Jugador::where('id_usuario', $idUsuarioActual)->pluck('id_liga')->toArray();
        $ligas = Liga::whereNotIn('id', $jugadoresUsuarioActual)->get();
        $ligas = $ligas->sortByDesc(function ($liga) {
            return $liga->jugador->count();
        });

        return view("Mundialito/lista_ligas")->with('ligas', $ligas);
    }

    public function getLigaDetalles($id)
    {
        $liga = Liga::with('jugador.usuario')->findOrFail($id);
        return response()->json($liga);
    }

    public function formLiga()
    {
        return view("Mundialito/formLiga");
    }

    public function crearLiga(Request $request)
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

        return redirect()->route("mundialito.listaligas");
    }

    public function unirseLiga(Request $request, $id)
    {
        $liga = Liga::where('id', $id)->firstOrFail();
        if ($liga->estado == 'publica') {
            $jugador = new Jugador();
            $jugador->puntos = 0;
            $jugador->puesto = 0;
            $jugador->saldo = 1500000;
            $jugador->id_liga = $liga->id;
            $jugador->id_usuario = Auth::id();
        
            $jugador->save();
        }else{
            $contraseña = $request->post('contraseña');
            if ($contraseña != $liga->contraseña_hash) {
                return redirect()->route("mundialito.fantasy")->with("error","La contraseña no es correcta");
            }else{
                $jugador = new Jugador();
                $jugador->puntos = 0;
                $jugador->puesto = 0;
                $jugador->saldo = 1500000;
                $jugador->id_liga = $liga->id;
                $jugador->id_usuario = Auth::id();
            
                $jugador->save();
            }
        }
        $this->actualizarPuestosJugadores();
        return redirect()->route("mundialito.listaligas");
    }



    public function updatePilotos(Request $request, $pilotoIdLider, $pilotoIdNormal, $jugadorid)
    {
        $jugador = Jugador::find($jugadorid);
        if (!$jugador) {
            return response()->json(['error' => 'Jugador no encontrado'], 404);
        }
        
        $saldoOriginal = $jugador->saldo;

        if ($jugador->piloto_juego_lider) {
            $saldoOriginal += $jugador->piloto_juego_lider->valor;
        }
        if ($pilotoIdLider != 0) {
            $pilotoLider = Piloto_Juego::find($pilotoIdLider);
            if ($pilotoLider) {
                $saldoOriginal -= $pilotoLider->valor;
            }
        }

        if ($jugador->piloto_juego) {
            $saldoOriginal += $jugador->piloto_juego->valor;
        }
        if ($pilotoIdNormal != 0) {
            $pilotoNormal = Piloto_Juego::find($pilotoIdNormal);
            if ($pilotoNormal) {
                $saldoOriginal -= $pilotoNormal->valor;
            }
        }

        // Verificar si el saldo se vuelve negativo
        if ($saldoOriginal < 0) {
            return response()->json(['error' => 'Saldo insuficiente para actualizar pilotos'], 400);
        }

        // Si el saldo es suficiente, realizar las actualizaciones
        if ($jugador->piloto_juego_lider) {
            $jugador->saldo += $jugador->piloto_juego_lider->valor;
        }
        if ($pilotoIdLider != 0) {
            $jugador->id_piloto_juego_lider = $pilotoIdLider;
            if ($pilotoLider) {
                $jugador->saldo -= $pilotoLider->valor;
            }
        }

        if ($jugador->piloto_juego) {
            $jugador->saldo += $jugador->piloto_juego->valor;
        }
        if ($pilotoIdNormal != 0) {
            $jugador->id_piloto_juego = $pilotoIdNormal;
            if ($pilotoNormal) {
                $jugador->saldo -= $pilotoNormal->valor;
            }
        }

        $jugador->save();

        return response()->json(['success' => 'Pilotos actualizado con éxito']);
    }


    public function update(Request $request, $id)
    {
        $jugador = Jugador::find($id);
        if (!$jugador) {
            return response()->json(['error' => 'Jugador no encontrado'], 404);
        }

        $pilotoIdNormal = $request->input('pilotoIdNormal');

        $jugador->id_piloto_juego = $pilotoIdNormal;
        $jugador->save();

        return response()->json(['success' => 'Piloto secundario actualizado con éxito']);
    }

    
    public function abandonarLiga($id)
    {
        $jugador = Jugador::find($id);
        $jugador->delete();
        $this->actualizarPuestosJugadores();
        return redirect()->route("mundialito.fantasy")->with("success","Eliminado con exito!");
    }
}
