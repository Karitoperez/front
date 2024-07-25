<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class CursoController extends Controller
{
    public $cursos = [];
    public $categorias = [];
    public $categoria;
    protected $usuario;
    protected $token;
    public $curso;

    public function index()
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }
        $this->usuario = session("usuario");
        $this->token = session("token");

        $this->mostrarCategorias();
        $this->mostrarCursos();

        return view('cursos.index', [
            "cursos" => $this->cursos,
            "categorias" => $this->categorias,
            "usuario" => $this->usuario
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
        ])->acceptJson()->get(env('API_URL') . '/categorias');

        $data = $response->json();
        $this->categorias = $data["categorias"];
    }

    public function create()
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esDocente() && !AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos.');
        }
        $this->usuario = session("usuario");
        $this->token = session("token");

        $this->mostrarCategorias();
        return view('cursos.create', [
            "categorias" => $this->categorias
        ]);
        return redirect()->back()->with('error', 'No tiene permisos.'); // Redirect to home or a custom unauthorized view
    }

    /*     public function store(Request $request)
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
                "fecha_inicio" => ["required", "string"],
                "fecha_fin" => ["required", "string"],
                "descripcion" => ["required", "string"],
                "duracion" => ["required", "numeric"],
                "imagen" => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                "id_categoria" => ["required", "numeric"],
            ]);

            $imagen = $request->file('imagen');
            if ($imagen) {

                // Obtener la imagen de la solicitud

                // Generar un nombre único para la imagen
                $nombreImagen = uniqid('imagen_') . '.' . $imagen->getClientOriginalExtension();

                // Guardar la imagen en el sistema de archivos con el nombre único
                $rutaImagen = Storage::putFileAs('public/imagenes', $imagen, $nombreImagen);

                // Obtener la URL pública de la imagen
                $urlImagen = Storage::url($rutaImagen);
            } else {
                $urlImagen = "usuario.jpg";
            }

            $token = session('token');
            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $token
            ])->acceptJson()->post(env("API_URL") . '/cursos', [
                "titulo" => $request["titulo"],
                "fecha_inicio" => $request["fecha_inicio"],
                "fecha_fin" => $request["fecha_fin"],
                "estado" => (int)$request["estado"],
                "imagen" => "$urlImagen",
                "descripcion" => $request["descripcion"],
                "duracion" =>  (int)$request["duracion"],
                "id_docente" => (int)$this->usuario["id"],
                "id_categoria" => (int)$request["id_categoria"]
            ]);

            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                return redirect()->route("cursos.index", $this->usuario['usuario'])->with('alert', 'success', '¡Curso creado correctamente!');
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
                return redirect()->back()->with('error', '¡Error al crear el curso! ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('alert', 'error', '¡Error al crear el curso! ' . $e->getMessage());
            }
        }
    } */

    public function show($id)
    {
        $response = Http::get(env('API_URL') . '/cursos/' . $id);

        $curso = $response->json("curso");

        return view('cursos.show', [
            "curso" => $curso,
            "usuario" => $this->usuario
        ]);
    }

    public function misCursos()
    {
        return view("cursos.mis-cursos");
    }

    public function edit($id)
    {
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
        ])->acceptJson()->get(env("API_URL") . "/cursos/" . $id);

        // Obtener los datos de cursos de la respuesta JSON
        $curso = $response->json();
        $this->categoria = $curso["curso"]["categoria"];
        $this->mostrarCategorias();

        // Retornar la vista de edición de cursos con los datos obtenidos
        return view('cursos.edit', [
            "curso" => $curso["curso"],
            "categorias" => $this->categorias,
            "categoria" => $this->categoria,
            "usuario" => $this->usuario
        ]);
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

        // Realizar la solicitud GET a la API de cursos con el token de autenticación
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/cursos/" . $id);

        $curso = $response->json("curso");


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
                if ($curso["imagen"]) {
                    Storage::delete(str_replace('storage', 'public', $curso["imagen"]));
                }
            } else {
                // Si no se proporciona una nueva imagen, mantener la imagen existente del usuario
                $urlImagen = $curso["imagen"];
            }

            // Enviar la solicitud PUT a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->token
            ])->acceptJson()->put(env("API_URL") . "/cursos/" . $id, [
                "titulo" => $request["titulo"],
                "fecha_inicio" => $request["fecha_inicio"],
                "fecha_fin" => $request["fecha_fin"],
                "estado" => (int)$request["estado"],
                "descripcion" => $request["descripcion"],
                "duracion" => (int)$request["duracion"],
                "id_docente" => (int)$this->usuario["id"],
                "id_categoria" => (int)$request["id_categoria"],
                "imagen" => $urlImagen
            ]);

            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                return redirect()->route("cursos.index", $this->usuario["usuario"])->with('alert', 'success', '¡Curso actualizado correctamente!');
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
                return redirect()->back()->with('error', '¡Error al actualizar el curso! ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('alert', 'error', '¡Error al actualizar el curso! ' . $e->getMessage());
            }
        }
    }

    public function destroy($id)
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
                return redirect()->route("cursos.index",  $this->usuario["usuario"])->with('success', 'Curso eliminado correctamente');
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
