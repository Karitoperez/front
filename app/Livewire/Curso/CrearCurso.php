<?php

namespace App\Livewire\Curso;

use Livewire\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class CrearCurso extends Component
{

    use WithFileUploads;

    public $categorias;
    public $token;
    public $usuario;
    public $titulo;
    public $estado;
    public $fecha_inicio;
    public $fecha_fin;
    public $descripcion;
    public $duracion;
    public $imagen;
    public $id_categoria;

    public $rules = [
        "titulo" => ["required", "string"],
        "estado" => ["required", "boolean"],
        "fecha_inicio" => ["required", "string"],
        "fecha_fin" => ["required", "string"],
        "descripcion" => ["required", "string"],
        "duracion" => ["required", "numeric"],
        "imagen" => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        "id_categoria" => ["required", "numeric"],
    ];

    public $messages = [
        'titulo.required' => 'El campo título es obligatorio.',
        'titulo.string' => 'El campo título debe ser una cadena de texto.',
        'estado.required' => 'El campo estado es obligatorio.',
        'estado.boolean' => 'El campo estado debe ser verdadero o falso.',
        'fecha_inicio.required' => 'El campo fecha de inicio es obligatorio.',
        'fecha_inicio.string' => 'El campo fecha de inicio debe ser una cadena de texto.',
        'fecha_fin.required' => 'El campo fecha de fin es obligatorio.',
        'fecha_fin.string' => 'El campo fecha de fin debe ser una cadena de texto.',
        'descripcion.required' => 'El campo descripción es obligatorio.',
        'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
        'duracion.required' => 'El campo duración es obligatorio.',
        'duracion.numeric' => 'El campo duración debe ser un valor numérico.',
        'imagen.image' => 'El archivo debe ser una imagen.',
        'imagen.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg, o gif.',
        'imagen.max' => 'La imagen no debe exceder los 2MB.',
        'id_categoria.required' => 'El campo categoría es obligatorio.',
        'id_categoria.numeric' => 'El campo categoría debe ser un valor numérico.',
    ];

    public function render()
    {
        if (!AuthHelper::esEstudiante()) {
            $this->usuario = session("usuario");
            $this->token = session("token");
            $this->mostrarCategorias();
            return view('livewire.curso.crear-curso');
        }
        return redirect()->back()->with('error', 'Unauthorized access!');
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

    public function crearCurso()
    {
        $this->validate();

        try {
            if ($this->imagen) {
                // Generar un nombre único para la imagen
                $nombreImagen = uniqid('imagen_') . '.' . $this->imagen->getClientOriginalExtension();

                // Guardar la imagen en el sistema de archivos con el nombre único
                $rutaImagen = Storage::putFileAs('public/imagenes', $this->imagen, $nombreImagen);

                // Obtener la URL pública de la imagen
                $urlImagen = Storage::url($rutaImagen);
            } else {
                $urlImagen = "curso.jpg";
            }

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                "Authorization" => "Bearer " . $this->token
            ])->acceptJson()->post(env("API_URL") . '/cursos', [
                "titulo" => $this->titulo,
                "fecha_inicio" => $this->fecha_inicio,
                "fecha_fin" => $this->fecha_fin,
                "estado" => (int)$this->estado,
                "imagen" => "$urlImagen",
                "descripcion" => $this->descripcion,
                "duracion" =>  (int)$this->duracion,
                "id_docente" => (int)$this->usuario["id"],
                "id_categoria" => (int)$this->id_categoria
            ]);

            if ($response->successful()) {
                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                return redirect()->route("misCursos")->with('success', '¡Curso creado correctamente!');
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
    }
}
