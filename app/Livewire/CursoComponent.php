<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password as PasswordRules;

class CursoComponent extends Component
{

    public $cursos = [];
    public $categorias = [];
    public $usuario;

    public function render()
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        $this->usuario = session("usuario");
        $this->mostrarCategorias();
        $this->mostrarCursos();

        return view('livewire.curso.curso-component')->layout("layouts.app");
    }

/*     public function store(Request $request)
    {

        $usuario = session('usuario');
        try {
            $request->validate([
                "titulo" => ["required", "string"],
                "estado" => ["required", "boolean"],
                "fecha_inicio" => ["required", "string"],
                "fecha_fin" => ["required", "string"],
                "descripcion" => ["required", "string"],
                "duracion" => ["required", "numeric"],
                "id_categoria" => ["required", "numeric"],
            ]);



            $token = session('token');
            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $token
            ])->acceptJson()->post('http://localhost:8000/api/cursos', [
                "titulo" => $request["titulo"],
                "fecha_inicio" => $request["fecha_inicio"],
                "fecha_fin" => $request["fecha_fin"],
                "estado" => $request["estado"],
                "imagen" => "1sfdgsdf.jpg",
                "descripcion" => $request["descripcion"],
                "duracion" =>  $request["duracion"],
                "id_docente" => $usuario["id"],
                "id_categoria" => $request["id_categoria"]
            ]);

            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                return redirect()->route("dashboard.index")->with('success', 'Curso creado correctamente');
            } else {
                // Si la solicitud no fue exitosa, adjunta un mensaje de error a la redirección
                return $response->json();
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Si la solicitud falla, capturamos la excepción y manejamos los errores
            $errorResponse = $e->response->json();

            // Si la respuesta contiene errores de validación (código de estado 422)
            if ($e->response->status() == 422 && isset($errorResponse['message'])) {
                $validationErrors = $errorResponse['message'];
                // Aquí puedes imprimir los errores o manejarlos de alguna otra manera
                return redirect()->back()->with('error', 'Error al crear el curso: ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('error', 'Error al crear el curso: ' . $e->getMessage());
            }
        }
    } */

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
