<?php

namespace App\Livewire\Teacher;

use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Dashboard extends Component
{
    public $categorias;
    public $cursos;
    public $usuario;
    public $usuarios;
    private $token;
    public $cursosPopulares;
    public $administradoresCantidad;
    public $docentesCantidad;
    public $estudiantesCantidad;
    public $totalCursos;

    public function render()
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->with('error', 'Debes iniciar sesión para acceder al dashboard');
        };
        $this->token = session('token');

        $this->cursosMasPopulares();
        $this->mostrarCursos();
        $this->obtenerUsuarios();
        return view('livewire.teacher.dashboard');
    }

    public function mostrarCursos()
    {
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get(env("API_URL") . "/cursos");

        $data = $response->json();
        $this->cursos = $data['cursos'];
        $this->totalCursos = count($this->cursos);
    }

    public function cursosMasPopulares()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/cursos-populares");

        $this->cursosPopulares = $response->json("cursosPopulares");
    }

    public function obtenerUsuarios()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/usuarios");

        $this->usuarios = $response->json("usuarios");

        // Convertir el array de usuarios en una colección de Laravel
        $usuariosColeccion = collect($this->usuarios);

        // Agrupar los usuarios por el campo "id_rol" y contar la cantidad de usuarios en cada grupo
        $usuariosPorRol = $usuariosColeccion->groupBy('id_rol')->map->count();

        // Obtener la cantidad de estudiantes, administradores y docentes
        $this->administradoresCantidad = $usuariosPorRol->get(1, 0); // Si no hay administradores, el valor predeterminado es 0
        $this->estudiantesCantidad = $usuariosPorRol->get(2, 0); // Si no hay estudiantes, el valor predeterminado es 0
        $this->docentesCantidad = $usuariosPorRol->get(3, 0); // Si no hay docentes, el valor predeterminado es 0

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
