<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{

    public $categorias = [];
    public $cursos = [];

    public function index()
    {

        if (!AuthHelper::estaAutenticado()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder al dashboard');
        }

        $usuario = session("usuario");
        $this->mostrarCategorias();
        $this->mostrarCursos();

        return view('dashboard', [
            "usuario" => $usuario,
            "categorias" => $this->categorias,
            "cursos" => $this->cursos
        ]);
    }

    public function mostrarCursos()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get(env("API_URL") . "/cursos");

        $data = $response->json();
        $this->cursos = $data['cursos'];
    }

    public function mostrarCategorias()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get(env("API_URL") . "/categorias");

        $data = $response->json();
        $this->categorias = $data['categorias'];
    }
}
