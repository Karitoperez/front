<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CourseList extends Component
{
    public $cursos;
    public $categorias;
    public $usuario;

    public function render()
    {
        $this->usuario = session("usuario");
        $this->mostrarCursos();
        $this->mostrarCategorias();

        return view('livewire.course-list');
    }

    public function mostrarCursos()
    {
        $url = "http://localhost:8000/api/cursos";
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get($url);

        $data = $response->json();
        $this->cursos = $data['cursos'];
    }

    public function mostrarCategorias()
    {
        $url = "http://localhost:8000/api/categorias";
        $token = session('token');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get($url);

        $data = $response->json();
        $this->categorias = $data['categorias'];
    }
}
