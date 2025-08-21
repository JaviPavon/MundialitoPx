<?php

use App\Http\Controllers\PilotoController;
use App\Http\Controllers\EscuderiaController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\CircuitoController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\NoticiaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CanalController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FantasyController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\MundialitoController;
use App\Http\Controllers\Piloto_JuegoController;
use App\Http\Controllers\VideoController;

// Rutas para el registro y el inicio de sesión

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas para usuarios no autenticados
Route::get('/admin', function () {
    return view('inicio');
})->name('admin');

Auth::routes();

Route::get('registro', [RegisterController::class, 'showRegistrationForm'])->name('registro');
Route::post('registro', [RegisterController::class, 'register']);
Route::get('inicio-sesion', [LoginController::class, 'showLoginForm'])->name('inicio-sesion');
Route::post('inicio-sesion', [LoginController::class, 'login']);

// Rutas para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    Route::middleware(['admin'])->group(function () {
        // Rutas para Pilotos
        Route::get('/piloto', [PilotoController::class, 'index'])->name('pilotos.index');
        Route::get('/piloto/create', [PilotoController::class, 'create'])->name('pilotos.create');
        Route::get('/piloto/edit/{id}', [PilotoController::class, 'edit'])->name('pilotos.edit');
        Route::get('/piloto/show/{id}', [PilotoController::class, 'show'])->name('pilotos.show');
        Route::put('/piloto/update/{id}', [PilotoController::class, 'update'])->name('pilotos.update');
        Route::delete('/piloto/destroy/{id}', [PilotoController::class, 'destroy'])->name('pilotos.destroy');
        Route::post('/piloto/store', [PilotoController::class, 'store'])->name('pilotos.store');

        // Rutas para Escuderias
        Route::get('/escuderia', [EscuderiaController::class, 'index'])->name('escuderias.index');
        Route::get('/escuderia/create', [EscuderiaController::class, 'create'])->name('escuderias.create');
        Route::get('/escuderia/edit/{id}', [EscuderiaController::class, 'edit'])->name('escuderias.edit');
        Route::get('/escuderia/show/{id}', [EscuderiaController::class, 'show'])->name('escuderias.show');
        Route::put('/escuderia/update/{id}', [EscuderiaController::class, 'update'])->name('escuderias.update');
        Route::delete('/escuderia/destroy/{id}', [EscuderiaController::class, 'destroy'])->name('escuderias.destroy');
        Route::post('/escuderia/store', [EscuderiaController::class, 'store'])->name('escuderias.store');

        // Rutas para Paises
        Route::get('/pais', [PaisController::class, 'index'])->name('paises.index');
        Route::get('/pais/create', [PaisController::class, 'create'])->name('paises.create');
        Route::get('/pais/edit/{id}', [PaisController::class, 'edit'])->name('paises.edit');
        Route::get('/pais/show/{id}', [PaisController::class, 'show'])->name('paises.show');
        Route::put('/pais/update/{id}', [PaisController::class, 'update'])->name('paises.update');
        Route::delete('/pais/destroy/{id}', [PaisController::class, 'destroy'])->name('paises.destroy');
        Route::post('/pais/store', [PaisController::class, 'store'])->name('paises.store');

        // Rutas para Circuitos
        Route::get('/circuito', [CircuitoController::class, 'index'])->name('circuitos.index');
        Route::get('/circuito/create', [CircuitoController::class, 'create'])->name('circuitos.create');
        Route::get('/circuito/edit/{id}', [CircuitoController::class, 'edit'])->name('circuitos.edit');
        Route::get('/circuito/show/{id}', [CircuitoController::class, 'show'])->name('circuitos.show');
        Route::put('/circuito/update/{id}', [CircuitoController::class, 'update'])->name('circuitos.update');
        Route::delete('/circuito/destroy/{id}', [CircuitoController::class, 'destroy'])->name('circuitos.destroy');
        Route::post('/circuito/store', [CircuitoController::class, 'store'])->name('circuitos.store');

        // Rutas para Carreras
        Route::get('/carrera', [CarreraController::class, 'index'])->name('carreras.index');
        Route::get('/carrera/create', [CarreraController::class, 'create'])->name('carreras.create');
        Route::get('/carrera/edit/{id}', [CarreraController::class, 'edit'])->name('carreras.edit');
        Route::get('/carrera/show/{id}', [CarreraController::class, 'show'])->name('carreras.show');
        Route::put('/carrera/update/{id}', [CarreraController::class, 'update'])->name('carreras.update');
        Route::delete('/carrera/destroy/{id}', [CarreraController::class, 'destroy'])->name('carreras.destroy');
        Route::post('/carrera/store', [CarreraController::class, 'store'])->name('carreras.store');

        // Rutas para Noticias
        Route::get('/noticia', [NoticiaController::class, 'index'])->name('noticias.index');
        Route::get('/noticia/create', [NoticiaController::class, 'create'])->name('noticias.create');
        Route::get('/noticia/edit/{id}', [NoticiaController::class, 'edit'])->name('noticias.edit');
        Route::get('/noticia/show/{id}', [NoticiaController::class, 'show'])->name('noticias.show');
        Route::put('/noticia/update/{id}', [NoticiaController::class, 'update'])->name('noticias.update');
        Route::delete('/noticia/destroy/{id}', [NoticiaController::class, 'destroy'])->name('noticias.destroy');
        Route::post('/noticia/store', [NoticiaController::class, 'store'])->name('noticias.store');

        // Rutas para Canal
        Route::get('/canal', [CanalController::class, 'index'])->name('canal.index');
        Route::get('/canal/create', [CanalController::class, 'create'])->name('canal.create');
        Route::get('/canal/edit/{id}', [CanalController::class, 'edit'])->name('canal.edit');
        Route::get('/canal/show/{id}', [CanalController::class, 'show'])->name('canal.show');
        Route::put('/canal/update/{id}', [CanalController::class, 'update'])->name('canal.update');
        Route::delete('/canal/destroy/{id}', [CanalController::class, 'destroy'])->name('canal.destroy');
        Route::post('/canal/store', [CanalController::class, 'store'])->name('canal.store');

        // Rutas para Comentario
        Route::get('/comentario', [ComentarioController::class, 'index'])->name('comentario.index');
        Route::get('/comentario/create', [ComentarioController::class, 'create'])->name('comentario.create');
        Route::get('/comentario/edit/{id}', [ComentarioController::class, 'edit'])->name('comentario.edit');
        Route::get('/comentario/show/{id}', [ComentarioController::class, 'show'])->name('comentario.show');
        Route::put('/comentario/update/{id}', [ComentarioController::class, 'update'])->name('comentario.update');
        Route::delete('/comentario/destroy/{id}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');
        Route::post('/comentario/store', [ComentarioController::class, 'store'])->name('comentario.store');

        // Rutas para Video
        Route::get('/video', [VideoController::class, 'index'])->name('video.index');
        Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
        Route::get('/video/edit/{id}', [VideoController::class, 'edit'])->name('video.edit');
        Route::get('/video/show/{id}', [VideoController::class, 'show'])->name('video.show');
        Route::put('/video/update/{id}', [VideoController::class, 'update'])->name('video.update');
        Route::delete('/video/destroy/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
        Route::post('/video/store', [VideoController::class, 'store'])->name('video.store');

        // Rutas para Fantasy
        Route::get('/admin/fantasy', [FantasyController::class, 'index'])->name('fantasy.index');
        Route::put('/admin/fantasy/editar', [FantasyController::class, 'edit'])->name('fantasy.editar');
        Route::put('/admin/fantasy/update', [FantasyController::class, 'update'])->name('fantasy.update');
        Route::get('/admin/fantasy/liga', [LigaController::class, 'index'])->name('liga.index');
        Route::get('/admin/fantasy/jugador/{id}', [JugadorController::class, 'index'])->name('jugador.index');
        Route::get('/admin/fantasy/liga/create', [LigaController::class, 'create'])->name('liga.create');
        Route::post('/admin/fantasy/liga/store', [LigaController::class, 'store'])->name('liga.store');
        Route::get('/admin/fantasy/liga/jugador/{id}', [JugadorController::class, 'create'])->name('jugador.create');
        Route::post('/admin/fantasy/liga/jugador/join/{id}', [JugadorController::class, 'store'])->name('jugador.store');
        Route::delete('/admin/fantasy/jugador/destroy/{id}', [JugadorController::class, 'destroy'])->name('jugador.destroy');
        Route::put('/admin/fantasy/jugador/update/lider/{id}', [JugadorController::class, 'updatelider'])->name('jugador.updatelider');
        Route::put('/admin/fantasy/jugador/update/{id}', [JugadorController::class, 'update'])->name('jugador.update');
        Route::put('/admin/fantasy/jugador/vaciarCampos/{id}', [Controller::class, 'vaciarCampos'])->name('jugador.vaciarCampos');
        Route::put('/admin/fantasy/jugador/enJuego', [Controller::class, 'enJuego'])->name('fantasy.enJuego');

        // Rutas para los pilotos del Fantasy
        Route::get('/fantasy/pilotos', [Piloto_JuegoController::class, 'index'])->name('pilotos_juego.index');
        Route::get('/fantasy/pilotos/sincronizar', [Piloto_JuegoController::class, 'create'])->name('pilotos_juego.create');
        Route::post('/fantasy/pilotos/sincronizar/store', [Piloto_JuegoController::class, 'store'])->name('pilotos_juego.store');
        Route::get('/fantasy/pilotos/edit/{id}', [Piloto_JuegoController::class, 'edit'])->name('pilotos_juego.edit');
        Route::put('/fantasy/pilotos/update/{id}', [Piloto_JuegoController::class, 'update'])->name('pilotos_juego.update');

        // Rutas para las jornadas del fantasy
        Route::get('/fantasy/jornadas', [JornadaController::class, 'index'])->name('jornada.index');
        Route::post('/fantasy/jornadas/store', [JornadaController::class, 'store'])->name('jornada.store');
        Route::get('/fantasy/jornadas/edit', [JornadaController::class, 'edit'])->name('jornada.edit');
        // Route::delete('/fantasy/jornadas/delete/{id}', [JornadaController::class, 'delete'])->name('jornada.delete');
        Route::get('/jornadas_por_circuito', [JornadaController::class, 'jornadasPorCircuito'])->name('jornada.jornadas_por_circuito');

        Route::put('/sumar/adelantamiento/{id}', [JornadaController::class, 'masAdelantamiento'])->name('jornada.masAdelantamiento');
        Route::put('/restar/adelantamiento/{id}', [JornadaController::class, 'menosAdelantamiento'])->name('jornada.menosAdelantamiento');
        Route::put('/pasoAQ2/{id}', [JornadaController::class, 'pasoAQ2'])->name('jornada.pasoAQ2');
        Route::put('/pasoAQ3/{id}', [JornadaController::class, 'pasoAQ3'])->name('jornada.pasoAQ3');
        Route::put('/sumar/amonestacion/{id}', [JornadaController::class, 'masAmonestacion'])->name('jornada.masAmonestacion');
        Route::put('/restar/amonestacion/{id}', [JornadaController::class, 'menosAmonestacion'])->name('jornada.menosAmonestacion');
        Route::put('/sumar/sancion3/{id}', [JornadaController::class, 'masSancion3'])->name('jornada.masSancion3');
        Route::put('/restar/sancion3/{id}', [JornadaController::class, 'menosSancion3'])->name('jornada.menosSancion3');
        Route::put('/sumar/sancion5/{id}', [JornadaController::class, 'masSancion5'])->name('jornada.masSancion5');
        Route::put('/restar/sancion5/{id}', [JornadaController::class, 'menosSancion5'])->name('jornada.menosSancion5');

        Route::get('/fantasy/sincronizarPuntaje', [FantasyController::class, 'show'])->name('fantasy.show');
        Route::put('/fantasy/sincronizarPuntaje/loading', [FantasyController::class, 'sincronizarPuntaje'])->name('fantasy.sincronizarPuntaje');

    });
    // Fantasy
    Route::get('/fantasy', [MundialitoController::class, 'fantasy'])->name('mundialito.fantasy');
    Route::get('/fantasy/liga/{id}', [MundialitoController::class, 'liga'])->name('mundialito.liga');
    Route::post('/fantasy/updatepilotos/{pilotoIdLider}/{pilotoIdNormal}/{jugadorId}', [MundialitoController::class, 'updatePilotos'])->name('mundialito.updatelider');
    Route::post('/fantasy/update/{id}', [MundialitoController::class, 'update'])->name('mundialito.update');
    Route::get('/fantasy/listaligas', [MundialitoController::class, 'listaligas'])->name('mundialito.listaligas');
    Route::post('/fantasy/crear/liga', [MundialitoController::class, 'crearLiga'])->name('mundialito.crearliga');
    Route::get('/fantasy/form/liga', [MundialitoController::class, 'formLiga'])->name('mundialito.formliga');
    Route::post('/fantasy/unirse/liga/{id}', [MundialitoController::class, 'unirseLiga'])->name('mundialito.unirseliga');
    Route::post('/fantasy/abandonar/liga/{id}', [MundialitoController::class, 'abandonarLiga'])->name('mundialito.abandonarliga');
    Route::put('/fantasy/jugador/vaciarCampos/{id}', [Controller::class, 'vaciarCampos'])->name('jugador.vaciarCampos');

    // Perfil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
});

// Rutas página web
Route::get('/', [MundialitoController::class, 'index'])->name('index');
Route::get('/calendario/{circuitoId?}', [MundialitoController::class, 'calendario'])->name('mundialito.calendario');
Route::get('/noticias', [MundialitoController::class, 'noticias'])->name('mundialito.noticias');
Route::get('/noticia/{id}', [MundialitoController::class, 'detalleNoticia'])->name('mundialito.noticia');
Route::post('/comentario/{id}', [MundialitoController::class, 'crearComentario'])->name('mundialito.comentario');
Route::get('/clasificacion', [MundialitoController::class, 'clasificacion'])->name('mundialito.clasificacion');
Route::get('/pilotos', [MundialitoController::class, 'pilotos'])->name('mundialito.pilotos');
Route::get('/piloto/{id}', [MundialitoController::class, 'detallePiloto'])->name('mundialito.piloto');
Route::get('/escuderias', [MundialitoController::class, 'escuderias'])->name('mundialito.escuderias');
Route::get('/escuderia/{id}', [MundialitoController::class, 'detalleEscuderia'])->name('mundialito.escuderia');
Route::get('/f1tv', [MundialitoController::class, 'f1tv'])->name('f1tv.show');
Route::get('/piloto/{id}/jornadas', [MundialitoController::class, 'getJornadasByPiloto'])->name('piloto.jornadas');
Route::get('/jugador/{id}/historial', [MundialitoController::class, 'getHistorial']);
Route::get('/liga/{id}/detalles', [MundialitoController::class, 'getLigaDetalles']);



// Rutas para cerrar sesión
Route::post('cerrar-sesion', [LoginController::class, 'logout'])->name('cerrar-sesion');

// Ruta de inicio para usuarios autenticados
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
