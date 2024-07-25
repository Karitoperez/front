<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\WithFileUploads;

class Registrarse extends Component
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

    public function mount(){
        $this->nombre = null;
        $this->apellido = null;
        $this->numero_documento = null;
        $this->usuario = null;
        $this->fecha_nacimiento = null;
        $this->direccion = null;
        $this->id_tipo_documento = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->imagen = null;

    }
    
    protected $rules = [
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'numero_documento' => 'required|string|max:255',
        'usuario' => 'required|string|max:255',
        'fecha_nacimiento' => 'required|date',
        'direccion' => 'required|string|max:255',
        'id_tipo_documento' => 'required|in:1,2,3,4,5',
        'id_rol' => 'required|in:1,2',
        'email' => 'required|string|email|max:255|unique:users',
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
        'id_rol.required' => 'El campo rol es obligatorio.',
        'id_rol.integer' => 'El campo rol debe ser un número entero.',
        'email.required' => 'El campo correo electrónico es obligatorio.',
        'email.string' => 'El campo correo electrónico debe ser una cadena de caracteres.',
        'email.email' => 'El campo correo electrónico debe ser una dirección de correo electrónico válida.',
        'email.max' => 'El campo correo electrónico no puede tener más de :max caracteres.',
        'email.unique' => 'El correo electrónico ya está siendo utilizado por otro usuario.',
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
        return view('livewire.auth.registrarse');
    }
    
    public function registro()
    {
        $validatedData = $this->validate();

        try {
            // Guardar la imagen en el sistema de archivos
            $rutaImagen = $this->imagen->store('public/imagenes');
            $urlImagen = Storage::url($rutaImagen);

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::acceptJson()->post(env('API_URL') . '/registrarse', [
                "nombre" => $this->nombre,
                "apellido" => $this->apellido,
                "numero_documento" => $this->numero_documento,
                "usuario" => $this->usuario,
                "fecha_nacimiento" => $this->fecha_nacimiento,
                "direccion" => $this->direccion,
                "id_tipo_documento" => $this->id_tipo_documento,
                "id_rol" => $this->id_rol,
                "email" => $this->email,
                "password" => $this->password,
                "password_confirmation" => $this->password_confirmation,
                "imagen" => $urlImagen
            ]);

            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                $token = $response->json('token');
                $usuario = $response->json('usuario');
                session()->put('token', $token);
                session()->put('usuario', $usuario);

                $this->reset();
                return redirect()->route("dashboard.index");
            } else {
                // Si la solicitud no fue exitosa, arroja una excepción con el mensaje de error de la API
                throw ValidationException::withMessages([$response->json()]);
            }
        } catch (\Illuminate\Http\Client\RequestException $e) {
            // Si la solicitud falla, capturamos la excepción y manejamos los errores
            $errorResponse = $e->response->json();

            // Si la respuesta contiene errores de validación (código de estado 422)
            if ($e->response->status() == 422 && isset($errorResponse['message'])) {
                $validationErrors = $errorResponse['message'];
                // Aquí puedes imprimir los errores o manejarlos de alguna otra manera
                throw ValidationException::withMessages($validationErrors);
            } else {
                // Manejar otros tipos de errores de solicitud HTTP
                throw ValidationException::withMessages([$e->getMessage()]);
            }
        }
    }
}
