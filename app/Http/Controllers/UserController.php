<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Http\Requests\CrearUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Método para obtener todos los usuarios
    public function index()
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }
        return view('users.index');
    }

    // Método para mostrar el formulario de creación de usuarios
    public function create()
    {
        if (!AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }
        return view('users.create');
    }

    // Método para guardar un nuevo usuario
    public function store(CrearUsuarioRequest $request)
    {
        if (!AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }

        try {
            $request->validated();

            // Obtener la imagen de la solicitud
            $imagen = $request->file('imagen');

            // Generar un nombre único para la imagen
            $nombreImagen = uniqid('imagen_') . '.' . $imagen->getClientOriginalExtension();

            // Guardar la imagen en el sistema de archivos con el nombre único
            $rutaImagen = Storage::putFileAs('public/imagenes', $imagen, $nombreImagen);

            // Obtener la URL pública de la imagen
            $urlImagen = Storage::url($rutaImagen);

            $token = session("token");

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->post(env("API_URL") . "/usuarios", [
                "nombre" => $request["nombre"],
                "apellido" => $request["apellido"],
                "numero_documento" => $request["numero_documento"],
                "usuario" => $request["usuario"],
                "fecha_nacimiento" => $request["fecha_nacimiento"],
                "direccion" => $request["direccion"],
                "id_tipo_documento" =>  (int)($request["id_tipo_documento"]),
                "id_rol" => (int)$request["id_rol"],
                "email" => $request["email"],
                "password" => $request["password"],
                "password_confirmation" => $request["password_confirmation"],
                "imagen" => $urlImagen
            ]);

            if ($response->successful()) {
                return redirect()->route("usuarios.index")->with('success', 'Usuario creado correctamente');
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
                return redirect()->back()->with('error', 'Error al crear el usuario: ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('error', 'Error al crear el usuario: ' . $e->getMessage());
            }
        }
    }

    // Método para mostrar los detalles de un usuario específico
    public function show($id)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión');
        }

        $token = session("token");
        $usuario = session("usuario");

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get(env("API_URL") . "/usuarios/{$id}");

        $data = $response->json();

        $usuario = $data['usuario'];

        return view('users.profile', compact('usuario'));
    }

    // Método para mostrar el formulario de edición de un usuario
    public function edit($id)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión');
        }

        // Verificar si el usuario actual es el mismo que se está editando o si es un administrador
        if (!AuthHelper::esUsuarioActual($id) && !AuthHelper::esAdministrador()) {
            // Si no es el mismo usuario ni un administrador, devolver un error de acceso no autorizado
            return response()->json(['error' => 'Acceso no autorizado'], 403);
        }

        $response = Http::get(env("API_URL") . "/usuarios/{$id}");
        $usuario = $response->json();

        return view('users.edit', compact('usuario'));
    }

    // Método para actualizar un usuario existente
    public function update(Request $request, $id)
    {
        // Verificar si el usuario actual es el mismo que se está editando o si es un administrador
        if (!AuthHelper::esUsuarioActual($id)) {
            // Si no es el mismo usuario ni un administrador, devolver un error de acceso no autorizado
            return response()->json(['error' => 'Acceso no autorizado'], 403);
        }

        try {
            $request->validate([
                "nombre" => ["string"],
                "apellido" => ["string"],
                "numero_documento" => ["string", "regex:/^\d{8}(?:\d{2})?$/"],
                "usuario" => ["string"],
                "fecha_nacimiento" => ["string"],
                "direccion" => ["string"],
                "email" => ["email",],
                "imagen" => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                "id_tipo_documento" => ["numeric"],
            ]);

            $token = session("token");
            $usuario = session("usuario");

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->get(env("API_URL") . "/usuarios/{$id}");

            $usuario = $response->json("usuario");

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
                if ($usuario["imagen"]) {
                    Storage::delete(str_replace('storage', 'public', $usuario["imagen"]));
                }
            } else {
                // Si no se proporciona una nueva imagen, mantener la imagen existente del usuario
                $urlImagen = $usuario["imagen"];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->put(
                env("API_URL") . "/usuarios/{$id}",
                [
                    "nombre" => $request["nombre"] ?? $usuario["nombre"],
                    "apellido" => $request["apellido"] ?? $usuario["apellido"],
                    "numero_documento" => $request["numero_documento"] ?? $usuario["numero_documento"],
                    "usuario" => $request["usuario"] ?? $usuario["usuario"],
                    "fecha_nacimiento" => $request["fecha_nacimiento"] ?? $usuario["fecha_nacimiento"],
                    "direccion" => $request["direccion"] ?? $usuario["direccion"],
                    "id_tipo_documento" => (int)($request["id_tipo_documento"] ?? $usuario["id_tipo_documento"]),
                    "email" => $request["email"] ?? $usuario["email"],
                    "imagen" => $urlImagen
                ]
            );

            $usuario = $response->json('usuario');
            session()->put('usuario', $usuario);

            if ($response->successful()) {
                if (AuthHelper::esAdministrador()) {
                    return redirect()->route("usuarios.index")->with('success', 'Usuario actualizado correctamente');
                }
                return redirect()->back()->with('success', 'Usuario actualizado correctamente');
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
                return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . implode(', ', $validationErrors));
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
            }
        }
    }

    // Método para eliminar un usuario
    public function destroy($id)
    {
        try {
            if (!AuthHelper::estaAutenticado()) {
                return redirect()->back()->with('error', 'Debe iniciar sesión');
            }

            
            if (!AuthHelper::esUsuarioActual($id) && !AuthHelper::esAdministrador()) {
                return redirect()->back()->with('error', 'No tiene permisos');
            }


            $usuario = session("usuario");
            $token = session("token");

            // Realizar la solicitud GET a la API de cursos con el token de autenticación
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->delete(env("API_URL") . "/usuarios/" . $id);

            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                return redirect()->route("cursos.index",  $usuario["usuario"])->with('success', 'Curso eliminado correctamente');
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
