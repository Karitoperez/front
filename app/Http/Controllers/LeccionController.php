<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class LeccionController extends Controller
{
    public $cursos = [];
    public $categorias = [];
    public $usuario;
    public $token;
    public $leccion;


    /*     public function index()
    {
        if (!AuthHelper::estaAutenticado() || AuthHelper::esEstudiante()) { // Check for admin status
            return redirect()->back()->with('error', 'Unauthorized access!'); // Redirect to home or a custom unauthorized view
        }

        $this->usuario = session("usuario");

        $this->mostrarCursos();
        $this->mostrarCategorias();

        return view('lecciones.index', [
            "cursos" => $this->cursos,
            "categorias" => $this->categorias,
            "usuario" => $this->usuario
        ]);
    } */

    /*     public function mostrarCursos()
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
    } */

    public function create($cursoId)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esDocente() && !AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }

        $this->usuario = session("usuario");

        $this->token = session("token");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env("API_URL") . "/cursos/{$cursoId}");

        $curso = $response->json("curso");

        if (!AuthHelper::esDocenteDelCurso($curso["id_docente"])) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }


        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env("API_URL") . "/cursos/{$cursoId}");

        if ($response->successful()) {
            $curso = $response->json("curso");
            // Aquí puedes continuar con el resto de tu lógica
            if (!AuthHelper::esEstudiante()) {
                $this->usuario = session("user");
                return view('lecciones.create', [
                    "curso" => $curso,
                    "user" => $this->usuario
                ]);
            }
            return redirect()->back()->with('error', 'Unauthorized access!');
        } else {
            // Manejar el caso en el que no se pueda obtener el curso
            return redirect()->back()->with('error', 'Error al obtener los detalles del curso.');
        }
    }

    public function store(Request $request)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esDocente() && !AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }

        $this->usuario = session("usuario");
        $this->token = session("token");

        try {
            $request->validate([
                "titulo" => ["required", "string"],
                "estado" => ["required", "boolean"],
                "descripcion" => ["required", "string"],
                "orden" => ["required", "numeric"],
                "imagen" => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                "id_curso" => ["required", "numeric"],
            ]);


            // Obtener la imagen de la solicitud
            $imagen = $request->file('imagen');

            // Generar un nombre único para la imagen
            $nombreImagen = uniqid('imagen_') . '.' . $imagen->getClientOriginalExtension();

            // Guardar la imagen en el sistema de archivos con el nombre único
            $rutaImagen = Storage::putFileAs('public/imagenes', $imagen, $nombreImagen);

            // Obtener la URL pública de la imagen
            $urlImagen = Storage::url($rutaImagen);

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->token
            ])->acceptJson()->post(env("API_URL") . '/lecciones', [
                "titulo" => $request["titulo"],
                "estado" => $request["estado"],
                "imagen" => $urlImagen,
                "descripcion" => $request["descripcion"],
                "orden" => $request["orden"],
                "id_docente" => (int)$this->usuario["id"],
                "id_curso" => (int)$request["id_curso"]
            ]);



            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                return redirect()->route("cursos.show", ["id" => $request["id_curso"]])->with('success', 'Lección creada correctamente');
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
    }

    public function show($id)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        $this->usuario = session("usuario");
        $this->token = session("token");

        $url = env("API_URL") . "/lecciones/{$id}";
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get($url);

        $leccion = $response->json("leccion");

        return view('lecciones.show', [
            "leccion" => $leccion,
            "usuario" => $this->usuario
        ]);
    }

    public function edit($id)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esDocente() && !AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }

        $this->usuario = session("user");
        $this->token = session("token");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->get(env("API_URL") . "/lecciones/{$id}");

        if ($response->successful()) {
            $leccion = $response->json()['leccion'];
            // Aquí puedes continuar con el resto de tu lógica
            if (!AuthHelper::esEstudiante()) {
                return view('lecciones.edit', [
                    "leccion" => $leccion,
                    "user" => $this->usuario
                ]);
            }
            return redirect()->back()->with('error', 'Unauthorized access!');
        } else {
            // Manejar el caso en el que no se pueda obtener la lección
            return redirect()->back()->with('error', 'Error al obtener los detalles de la lección.');
        }
    }

    public function update(Request $request, $id)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esDocente() && !AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }

        $this->usuario = session("usuario");
        $this->token = session("token");

        // Construir la URL para la solicitud a la API de cursos
        $url = "http://localhost:8000/api/lecciones/{$id}";

        // Realizar la solicitud GET a la API de cursos con el token de autenticación
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get($url);

        $leccion = $response->json("leccion");

        try {
            $request->validate([
                "titulo" => ["required", "string"],
                "estado" => ["required", "boolean"],
                "descripcion" => ["required", "string"],
                "orden" => ["required", "numeric"],
                "imagen" => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                "id_curso" => ["required", "numeric"],
            ]);

            // Obtener la imagen de la solicitud
            $imagen = $request->file('imagen');

            // Generar un nombre único para la imagen si se proporciona
            if ($imagen) {
                $nombreImagen = uniqid('imagen_') . '.' . $imagen->getClientOriginalExtension();

                // Guardar la imagen en el sistema de archivos con el nombre único
                $rutaImagen = Storage::putFileAs('public/imagenes', $imagen, $nombreImagen);

                // Obtener la URL pública de la imagen
                $urlImagen = Storage::url($rutaImagen);

                // Eliminar la imagen anterior si existe
                if ($leccion["imagen"]) {
                    Storage::delete(str_replace('storage', 'public', $leccion["imagen"]));
                }
            } else {
                // Si no se proporciona una nueva imagen, mantener la imagen existente del usuario
                $urlImagen = $leccion["imagen"];
            }
            // Enviar la solicitud PUT a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->token
            ])->acceptJson()->put("http://localhost:8000/api/lecciones/{$id}", [
                "titulo" => $request["titulo"],
                "estado" => $request["estado"],
                "imagen" => $urlImagen,
                "descripcion" => $request["descripcion"],
                "orden" => (int)$request["orden"],
                "id_docente" => (int)$this->usuario["id"],
                "id_curso" => (int)$request["id_curso"]
            ]);

            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                return redirect()->route("cursos.show", ["id" => $request["id_curso"]])->with('success', 'Lección actualizada correctamente');
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
                return redirect()->back()->with('error', 'Error al actualizar la lección: ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('error', 'Error al actualizar la lección: ' . $e->getMessage());
            }
        }
    }
}
