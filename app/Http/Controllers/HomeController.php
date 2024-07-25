<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public $cursos;
    public $categorias;

    // Vista de bienvenida
    public function welcome()
    {
        return view('home.welcome');
    }
    public function cursos()
    {
        $this->mostrarCursos();
        $this->mostrarCategorias();
        return view('home.cursos', [
            "cursos" => $this->cursos,
            "categorias" => $this->categorias
        ]);
    }
    public function docentes()
    {
        return view('home.docentes');
    }

    public function mostrarCursos()
    {
        $response = Http::get(env("API_URL") . "/cursos");

        $this->cursos = $response->json("cursos");
    }

    public function mostrarCategorias()
    {
        $response = Http::get(env('API_URL') . '/categorias');

        $this->categorias = $response->json("categorias");
    }
}
