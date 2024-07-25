<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class AdminCursos extends Component
{

    public $cursos;
    public $categorias;
    public $id_categoria;
    public $usuario;
    public $cursosFiltrados;
    public $titulo = "Todos";
    public $cursosPopulares;

    public function render()
    {
        $this->cursosPopulares();
        return view('livewire.admin.admin-cursos');
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

        // Filtrar los cursos por la categoría seleccionada
        $this->cursosFiltrados = collect($this->cursos)->filter(function ($curso) use ($id_categoria) {
            return $curso['id_categoria'] === $id_categoria;
        })->all();

        $this->titulo = $nombre_categoria;

        return $this->cursosFiltrados;
    }

    public function cursosPopulares()
    {
        $url = env("API_URL") . "/cursos";
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get($url);

        $data = $response->json();
        $this->cursosPopulares = $data['cursos'];
    }
}
