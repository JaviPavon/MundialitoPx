<?php

use App\Http\Controllers\Api\SortController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sort/puestos', [SortController::class, 'puestos'])->name('api.sort.puestos');
Route::post('/sort/puestosJornada', [SortController::class, 'puestosJornada'])->name('api.sort.puestosJornada');