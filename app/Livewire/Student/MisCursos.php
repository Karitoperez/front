<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MisCursos extends Component
{
    public $usuario;
    public $misCursos;
    public $cursosFiltrados;
    public $id_categoria;
    public $categorias = [];
    public $titulo = 'Todos';
    public $token;

    public function render()
    {
        $this->usuario = session("usuario");
        $this->obtenerCursos();
        return view('livewire.student.mis-cursos');
    }

    public function obtenerCursos()
    {
        $this->token = session("token");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/cursos/estudiante/" . $this->usuario["id"]);

        $this->misCursos = $response->json('cursos');

        // Extraer categorías de los cursos
        $this->categorias = collect($this->misCursos)->pluck('categoria')->unique()->toArray();
    }

    public function mostrarCursos()
    {
        $this->titulo = "Todos";
        $this->cursosFiltrados = null;
    }

    public function filtrarPorCategoria($id_categoria, $nombre_categoria)
    {
        // Si no se proporciona una categoría, mostrar todos los cursos
        if ($id_categoria === null) {
            // No se aplica ningún filtro, se devuelven todos los cursos
            return $this->cursos;
        }
        $this->cursosFiltrados = collect($this->misCursos)->filter(function ($curso) use ($id_categoria) {
            return $curso['categoria']['id'] === $id_categoria;
        })->all();

        $this->titulo = $nombre_categoria;

        return $this->cursosFiltrados;
    }
}
