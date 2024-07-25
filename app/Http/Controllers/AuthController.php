<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrarseRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Vista para mostrar el formulario de inicio de sesión
    public function index()
    {   
        return view('auth.login');
    }

    // Vista para mostrar el formulario de registro
    public function create()
    {
        return view('auth.registrarse');
    }

    // Método para registrar un nuevo usuario
    public function store(RegistrarseRequest $request)
    {
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

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::acceptJson()->post(env('API_URL') . '/registro', [
                "name" => $request["nombre"],
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
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                $token = $response->json('token');
                $usuario = $response->json('usuario');
                session()->put('token', $token);
                session()->put('usuario', $usuario);
                return redirect()->route("dashboard.index");
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

    // Método para manejar el inicio de sesión
    public function login(LoginRequest $request)
    {
        try {
            $request->validated();

            
            $response = Http::acceptJson()->post(env('API_URL') . '/login', [
                "email" => $request["email"],
                "password" => $request["password"],
            ]);
            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                $token = $response->json('token');
                $usuario = $response->json('usuario');
                session()->put('usuario', $usuario);
                session()->put('token', $token);
                
                return redirect()->route("dashboard.index");
            } else {
                // Si la solicitud no fue exitosa, adjunta un mensaje de error a la redirección
                return redirect()->back()->with('error', 'Credenciales Incorrectas');
            }
        } catch (\Illuminate\Http\Client\RequestException $e) { // Si la solicitud falla, capturamos la excepción y manejamos los errores
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

    // Método para cerrar sesión
    public function logout()
    {
        try {
            $response = Http::withToken(session('token'))->post(env('API_URL') . '/logout');

            if ($response->successful()) {
                // Logout exitoso
                session()->forget('token'); // Eliminar el token de la sesión
                return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
            } else {
                // Manejar el caso en el que la solicitud de logout no sea exitosa
                return redirect()->route('login')->with('error', 'Error al cerrar sesión. Por favor, inténtalo de nuevo.');
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Manejar errores de solicitud HTTP
            return redirect()->route('login')->with('error', 'Error al cerrar sesión: ' . $e->getMessage());
        }
    }
}
