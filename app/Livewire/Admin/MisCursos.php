<?php

namespace App\Livewire\Admin;

use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
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
        $this->token = session('token');
        $this->obtenerMisCursos();

        return view('livewire.admin.mis-cursos');
    }

    public function obtenerMisCursos()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/cursos/docente/" . $this->usuario["id"]);

        $data = $response->json();
        $this->misCursos = $data['cursos'];

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

    #[On('eliminarCurso')]
    public function eliminarCurso($id)
    {
        try {
            if (!AuthHelper::estaAutenticado()) {
                return redirect()->back()->with('error', 'Debe iniciar sesión');
            }

            if (!AuthHelper::esDocente() && !AuthHelper::esAdministrador()) {
                return redirect()->back()->with('error', 'No tiene permisos');
            }

            $this->usuario = session("usuario");
            $this->token = session("token");

            // Realizar la solicitud GET a la API de cursos con el token de autenticación
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token
            ])->acceptJson()->delete(env("API_URL") . "/cursos/" . $id);

            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                return redirect()->back()->with('success', 'Curso eliminado correctamente');
            } else {
                // Si la solicitud no fue exitosa, devolver una respuesta JSON con un mensaje de error
                return response()->json([
                    'message' => 'Error al eliminar el curso: ' . $response->status(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            // En caso de error, devolver una respuesta JSON con un mensaje de error
            return response()->json([
                'message' => 'Error al eliminar el curso: ' . $e->getMessage()
            ], 500); // Código de estado HTTP 500 para indicar un error del servidor
        }
    }
}
