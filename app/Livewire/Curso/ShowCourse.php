<?php

namespace App\Livewire\Curso;

use App\Helpers\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowCourse extends Component
{
    public $curso;
    public $id;
    public $usuario;
    public $comentario = "Excelente curso!.";
    public $comentarioModelo;
    public $comentarioId;
    public $calificacion = 5;
    public $mostrarFormEditar = false;

    protected $rules = [
        'comentario' => 'required|string',
        'calificacion' => 'required|numeric|min:1|max:5',
    ];

    public function render()
    {
        $this->usuario = session("usuario");
        return view('livewire.curso.show-course');
    }

    public function abrirModalEditar($comentario)
    {
        $this->comentarioModelo = $comentario;
        $this->calificacion = $comentario["calificacion"];
        $this->comentario = $comentario["comentario"];
        $this->mostrarFormEditar = true;
    }

    public function cerrarModalEditar()
    {
        $this->mostrarFormEditar = false;
        $this->comentarioModelo = null;
        $this->calificacion = 5;
        $this->comentario = "Excelente curso!.";
    }

    public function agregarComentario()
    {
        $this->validate();

        try {
            // Determina el tipo de comentario (curso o lección) y obtén el ID correspondiente
            $commentableType = isset($this->curso['id']) ? 'App\Models\Curso' : 'App\Models\Curso';
            $commentableId = isset($this->curso['id']) ? $this->curso['id'] : null;

            // Obtén el token y el usuario de la sesión
            $token = session('token');

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->post(env("API_URL") . '/comentarios', [
                'id_usuario' => $this->usuario['id'],
                'comentario' => $this->comentario,
                'calificacion' => $this->calificacion,
                'commentable_type' => $commentableType,
                'commentable_id' => $commentableId
            ]);

            if ($response->successful()) {
                session(['usuario' => $response->json()['usuario']]);
                $this->comentario = $response->json()['comentario'];
                $this->curso = $response->json()['curso'];

                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                session()->flash('success', 'Comentario creado correctamente!');

                // Resetea los campos del formulario
                $this->comentario = '';
                $this->calificacion = 5;

                return redirect()->back();
            } else {
                // Si la solicitud no fue exitosa, adjunta un mensaje de error a la redirección
                $error = $response->json();
                session()->flash('error', 'Error al agregar el comentario: ' . $error['message']);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // En caso de error, adjunta un mensaje de error a la redirección
            session()->flash('error', 'Error al agregar el comentario: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    // Método para actualizar un comentario
    public function actualizarComentario()
    {
        $this->validate();
        try {
            // Obtén el token de la sesión
            $token = session('token');

            // Enviar la solicitud PUT a la API para actualizar el comentario
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->put(env("API_URL") . '/comentarios/' . $this->comentarioModelo["id"], [
                'comentario' => $this->comentario,
                'calificacion' => (int)$this->calificacion,
            ]);

            if ($response->successful()) {
                // Actualiza el estado del componente con los datos recibidos
                session(['usuario' => $response->json('usuario')]);
                $this->curso = $response->json('curso');

                $this->cerrarModalEditar();

                // Mensaje de éxito
                session()->flash('success', 'Comentario actualizado correctamente!');

                return redirect()->back();
            } else {
                // Si la solicitud no fue exitosa, muestra un mensaje de error
                $error = $response->json();
                session()->flash('error', 'Error al actualizar el comentario: ' . $error['message']);
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Si ocurre un error, muestra un mensaje de error
            session()->flash('error', 'Error al actualizar el comentario: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
