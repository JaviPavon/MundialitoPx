<?php

namespace App\Http\Controllers;

use App\Models\Piloto;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(){
        $pilotos = Piloto::with('escuderia')->with('pais')->get();
        return view('CRUD_Piloto/index')->with('pilotos', $pilotos);
    }
}
