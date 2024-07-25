<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InscripcionController extends Controller
{

    protected $listeners = ["inscribirme" => "store"];

    public $id_curso;
    public $usuario;

    /*     public function create($id_curso)
    {
        $this->id_curso = $id_curso;
        if (!AuthHelper::estaAutenticado() || !AuthHelper::esEstudiante()) { // Check for admin status
            return redirect()->back()->with('error', 'Unauthorized access!'); // Redirect to home or a custom unauthorized view
        }
        if (AuthHelper::esEstudiante()) {
            $this->usuario = session("usuario");
            return view('inscripcion.create', [
                "id_curso" => $this->id_curso,
                "usuario" => $this->usuario
            ]);
        }
        return redirect()->back()->with('error', 'Unauthorized access!');
    } */

    public function store(Request $request)
    {
        try {
            $request->validate([
                "id_curso" => ["required", "numeric"],
                "id_estudiante" => ["required", "numeric"]
            ]);

            $this->id_curso = (int)$request["id_curso"];

            $token = session('token');
            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $token
            ])->acceptJson()->post(env("API_URL") . "/inscripcion/", [
                "id_curso" => $this->id_curso,
                "id_estudiante" => (int)$request["id_estudiante"],
                "estado" => (int)$request["estado"] ?? 1,
            ]);

            if ($response->successful()) {
                session(['usuario' => $response->json()['usuario']]);
                return redirect()->route("cursos.show", ["id" => $request["id_curso"]])->with('success', "Inscrito Correctamente!");
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
                return redirect()->back()->with('alert', 'error', '¡Error al realizar la inscripción.! ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('alert', 'error', '¡Error al realizar la inscripción.! ' . $e->getMessage());
            }
        }
    }
}
