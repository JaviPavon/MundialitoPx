<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jornada;
use App\Models\Piloto;
use Illuminate\Http\Request;

class SortController extends Controller
{
    public function puestos(Request $request){

        $position = 1;
        $sorts = $request->get('sorts');

        foreach ($sorts as $sort) {
            $piloto = Piloto::find($sort);
            $piloto->posicion = $position;
            $piloto->save();
            $position++;
        }

    }

    public function puestosJornada(Request $request){

        $position = 1;
        $sorts = $request->get('sorts');

        foreach ($sorts as $sort) {
            $jornada = Jornada::find($sort);
            $jornada->puesto = $position;
            $jornada->save();
            $position++;
        }

    }
}
