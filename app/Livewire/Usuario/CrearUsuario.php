<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;

class CrearUsuario extends Component
{
    use WithFileUploads;

    public $nombre;
    public $apellido;
    public $numero_documento;
    public $usuario;
    public $fecha_nacimiento;
    public $direccion;
    public $id_tipo_documento;
    public $id_rol;
    public $email;
    public $password;
    public $password_confirmation;
    public $imagen;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'numero_documento' => 'required|string|max:255',
        'usuario' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'direccion' => 'required|string|max:255',
        'id_tipo_documento' => 'required|integer|in:1,2,3,4,5',
        'id_rol' => 'required|integer|in:1,2,3',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8|confirmed',
        'imagen' => 'required|image|max:2048',
    ];

    protected $messages = [
        'nombre.required' => 'El campo nombre es obligatorio.',
        'nombre.string' => 'El campo nombre debe ser una cadena de caracteres.',
        'nombre.max' => 'El campo nombre no puede tener más de :max caracteres.',
        'apellido.required' => 'El campo apellido es obligatorio.',
        'apellido.string' => 'El campo apellido debe ser una cadena de caracteres.',
        'apellido.max' => 'El campo apellido no puede tener más de :max caracteres.',
        'numero_documento.required' => 'El campo número de documento es obligatorio.',
        'numero_documento.string' => 'El campo número de documento debe ser una cadena de caracteres.',
        'numero_documento.max' => 'El campo número de documento no puede tener más de :max caracteres.',
        'usuario.required' => 'El campo usuario es obligatorio.',
        'usuario.string' => 'El campo usuario debe ser una cadena de caracteres.',
        'usuario.max' => 'El campo usuario no puede tener más de :max caracteres.',
        'fecha_nacimiento.required' => 'El campo fecha de nacimiento es obligatorio.',
        'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
        'direccion.required' => 'El campo dirección es obligatorio.',
        'direccion.string' => 'El campo dirección debe ser una cadena de caracteres.',
        'direccion.max' => 'El campo dirección no puede tener más de :max caracteres.',
        'id_tipo_documento.required' => 'El campo tipo de documento es obligatorio.',
        'id_tipo_documento.integer' => 'El campo tipo de documento debe ser un número entero.',
        'id_tipo_documento.in' => 'El tipo de documento seleccionado no es válido.',
        'id_rol.required' => 'El campo rol es obligatorio.',
        'id_rol.integer' => 'El campo rol debe ser un número entero.',
        'id_rol.in' => 'El rol seleccionado no es válido.',
        'email.required' => 'El campo correo electrónico es obligatorio.',
        'email.string' => 'El campo correo electrónico debe ser una cadena de caracteres.',
        'email.email' => 'El campo correo electrónico debe ser una dirección de correo electrónico válida.',
        'email.max' => 'El campo correo electrónico no puede tener más de :max caracteres.',
        'password.required' => 'El campo contraseña es obligatorio.',
        'password.string' => 'El campo contraseña debe ser una cadena de caracteres.',
        'password.min' => 'El campo contraseña debe tener al menos :min caracteres.',
        'password.confirmed' => 'La confirmación de contraseña no coincide.',
        'imagen.required' => 'El campo imagen es obligatorio.',
        'imagen.image' => 'El campo imagen debe ser una imagen válida.',
        'imagen.max' => 'El tamaño máximo de la imagen es :max kilobytes.',
    ];

    public function render()
    {
        return view('livewire.usuario.crear-usuario');
    }

    public function crearUsuario()
    {
        $this->validate();

        try {
            // Guardar la imagen en el sistema de archivos
            $rutaImagen = $this->imagen->store('public/imagenes');
            $urlImagen = Storage::url($rutaImagen);

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . session('token')
            ])->acceptJson()->post(env('API_URL') . '/usuarios', [
                "nombre" => $this->nombre,
                "apellido" => $this->apellido,
                "numero_documento" => $this->numero_documento,
                "usuario" => $this->usuario,
                "fecha_nacimiento" => $this->fecha_nacimiento,
                "direccion" => $this->direccion,
                "id_tipo_documento" => (int) $this->id_tipo_documento,
                "id_rol" => (int) $this->id_rol,
                "email" => $this->email,
                "password" => $this->password,
                "password_confirmation" => $this->password_confirmation,
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
}
