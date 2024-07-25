<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ArchivoLeccionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Registrarse;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas protegidas por autenticación
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/crear-cuenta', [UserController::class, 'create'])->name('usuarios.create');
    Route::get('/usuarios/{id}', [UserController::class, 'show'])->name('usuarios.show');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

    Route::get('/{username}/cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/crear', [CursoController::class, 'create'])->name('cursos.create');
    Route::get('/cursos/mis-cursos', [CursoController::class, 'misCursos'])->name('misCursos');
/*     Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store'); */
    Route::get('/cursos/{id}', [CursoController::class, 'show'])->name('cursos.show');
    Route::get('/cursos/{curso}/editar', [CursoController::class, 'edit'])->name('cursos.edit');
    Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');

    Route::get('/lecciones', [LeccionController::class, 'index'])->name('lecciones.index');
    Route::get('/lecciones/crear/{curso}', [LeccionController::class, 'create'])->name('lecciones.create');
    Route::post('/lecciones', [LeccionController::class, 'store'])->name('lecciones.store');
    Route::get('/lecciones/{id}', [LeccionController::class, 'show'])->name('lecciones.show');
    Route::get('/lecciones/editar/{id}', [LeccionController::class, 'edit'])->name('lecciones.edit');
    Route::put('/lecciones/{leccion}', [LeccionController::class, 'update'])->name('lecciones.update');
    Route::delete('/lecciones/{leccion}', [LeccionController::class, 'destroy'])->name('lecciones.destroy');

    Route::post('/cursos/inscripcion', [InscripcionController::class, 'store'])->name('inscripcion.store');

    Route::get('/archivo-leccion', [ArchivoLeccionController::class, 'create'])->name('archivoLeccion.create');
    Route::post('/archivo-leccion', [ArchivoLeccionController::class, 'store'])->name('archivoLeccion.store'); 
   
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index'); 
});

// Rutas públicas
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/cursos', [HomeController::class, 'cursos'])->name('cursos');
Route::get('/docentes', [HomeController::class, 'docentes'])->name('docentes');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registrarse', [AuthController::class, 'create'])->name('registrarse.create');
/* Route::post('/registrarse', [AuthController::class, 'store'])->name('registrarse.store'); */
