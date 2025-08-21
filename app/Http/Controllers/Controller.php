<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Circuito;
use App\Models\Piloto;
use App\Models\Escuderia;
use App\Models\Fantasy;
use App\Models\Historial;
use App\Models\Jornada;
use App\Models\Jugador;
use App\Models\Liga;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function puntosPorPuesto($puesto){
        switch ($puesto) {
            case 1:
                $puntos = 25;
                break;
            
            case 2:
                $puntos = 18;
                break;
            
            case 3:
                $puntos = 15;
                break;

            case 4:
                $puntos = 10;
                break;

            case 5:
                $puntos = 8;
                break;

            case 6:
                $puntos = 6;
                break;
            
            case 7:
                $puntos = 5;
                break;

            case 8:
                $puntos = 3;
                break;

            case 9:
                $puntos = 2;
                break;

            case 10:
                $puntos = 1;
                break;

            default:
                $puntos = 0;
                break;
        }
        return $puntos;
    }

    public function actualizarPuestosPilotos()
    {
        $pilotos = Piloto::all()->sortByDesc('puntos');
        $puesto = 1;
        foreach ($pilotos as $piloto) {
            $piloto->posicion = $puesto;
            $puesto++;
            $piloto->save();
        }
    }

    public function actualizarPuestosEscuderias()
    {
        $escuderias = Escuderia::all()->sortByDesc('puntos');
        $puesto = 1;
        foreach ($escuderias as $escuderia) {
            $escuderia->posicion = $puesto;
            $puesto++;
            $escuderia->save();
        }
    }

    public function actualizarPuestosJugadores()
    {
        $ligas = Liga::all();
        foreach ($ligas as $liga) {
            $jugadores = Jugador::where('id_liga', $liga->id)->get()->sortByDesc('puntos');
            $puesto = 1;
            foreach ($jugadores as $jugador) {
                $jugador->puesto = $puesto;
                $puesto++;
                $jugador->save();
            }
        }
    }

    public function actualizarPuestosJornadas()
    {
        $circuitos = Circuito::all();
        foreach ($circuitos as $circuito) {
            $jornadas = Jornada::where('id_circuito', $circuito->id)->get()->sortByDesc('puntos');
            $puesto = 1;
            foreach ($jornadas as $jornada) {
                $jornada->puesto = $puesto;
                $puesto++;
                $jornada->save();
            }
        }
    }

    public function vaciarCampos($id)
    {
        $jugador = Jugador::find($id);
        if ($jugador->piloto_juego_lider) {
            $jugador->saldo += $jugador->piloto_juego_lider->valor;
        }
        if ($jugador->piloto_juego) {
            $jugador->saldo += $jugador->piloto_juego->valor;
        }
        $jugador->id_piloto_juego_lider = null;
        $jugador->id_piloto_juego = null;

        $jugador->save();

        $this->actualizarPuestosJugadores();
        return redirect()->back()->with("success","Vaciado con exito!");
    }


    public function vaciarCamposGeneral()
    {
        $jugadores = Jugador::all();
        foreach ($jugadores as $jugador) {
            if ($jugador->piloto_juego_lider) {
                $jugador->saldo += $jugador->piloto_juego_lider->valor;
            }
            if ($jugador->piloto_juego) {
                $jugador->saldo += $jugador->piloto_juego->valor;
            }
            $jugador->id_piloto_juego_lider = null;
            $jugador->id_piloto_juego = null;
    
            $jugador->save();
        }

        $this->actualizarPuestosJugadores();
        return redirect()->route("fantasy.index")->with("success","Vaciado con exito!");
    }

    public function enJuego()
    {
        $fantasy = Fantasy::all()->first();
        if ($fantasy->en_juego == 0) {
            $fantasy->en_juego = true;
        }elseif ($fantasy->en_juego == 1) {
            $fantasy->en_juego = false;
        }

        $fantasy->save();

        return redirect()->back()->with("success","Cambiado con exito!");
    }

    public function actualizarPuntosJornada($id)
    {
        $jornada = Jornada::find($id);
        $carrera = Carrera::where('id_piloto', $jornada->piloto_juego->id_piloto)
                    ->where('id_circuito', $jornada->id_circuito)
                    ->first();
        $puntos = 0;

        if ($jornada->qually2 == 1) {
            $puntos += 3;
        }
        if ($jornada->qually3 == 1) {
            $puntos += 5;
        }
        if ($carrera) {

            switch ($carrera->puesto) {
                case 1:
                    $puntos += 10;
                    break;
                
                case 2:
                    $puntos += 9;
                    break;
                
                case 3:
                    $puntos += 8;
                    break;
    
                case 4:
                    $puntos += 7;
                    break;
    
                case 5:
                    $puntos += 6;
                    break;
    
                case 6:
                    $puntos += 5;
                    break;
                
                case 7:
                    $puntos += 4;
                    break;
    
                case 8:
                    $puntos += 3;
                    break;
    
                case 9:
                    $puntos += 2;
                    break;
    
                case 10:
                    $puntos += 1;
                    break;
    
                default:
                    $puntos += 0;
                    break;
            }

            if ($carrera->vuelta_rapida == 1) {
                $puntos+= 3;
            }
    
            if ($carrera->estado == null) {
                $puntos+=4;
            }
            if ($carrera->estado == "DNF") {
                $puntos-=25;
            }
            if ($carrera->estado == "DSQ") {
                $puntos-=15;
            }
        }

        // Adelantamientos
        $puntos += $jornada->adelantamientos;

        // Amonestaciones
        if ($jornada->amonestaciones == 0) {
            $puntos += 5;
        }elseif ($jornada->amonestaciones % 2 == 0) {
            $puntos -= $jornada->amonestaciones / 2;
        }

        // Sación de 3 segundos
        $puntos -= $jornada->sancion3sec * 4;

        // Sanción de 5 segundos
        $puntos -= $jornada->sancion5sec * 7;

        $jornada->puntos = $puntos;
        $jornada->save();

    }

    public function guardarHistorial($id_jugador, $id_piloto_juego_lider, $id_piloto_juego, $id_circuito)
    {
        $historial = new Historial();

        $historial->numero_jornada = $id_circuito;
        $historial->id_jugador = $id_jugador;
        $historial->id_piloto_juego_lider = $id_piloto_juego_lider;
        $historial->id_piloto_juego = $id_piloto_juego;

        $historial->save();
    }
}
