<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class Comentario extends Component
{
    public $curso;
    public $id;
    public $comentario;
    public $calificacion = 4;

    protected $rules = [
        'comentario' => 'required|string',
        'calificacion' => 'required|numeric|min:1|max:5',
    ];

    public function render()
    {
        $this->id = $this->curso["id"];
        return view('livewire.curso.show-course');
    }

    #[On('cursoActualizado')]
    public function agregarComentario()
    {
        $this->validate();
        try {
            // Determina el tipo de comentario (curso o lección) y obtén el ID correspondiente
            $commentableType = isset($this->curso['id']) ? 'App\\Models\\Curso' : 'App\\Models\\Leccion';
            $commentableId = isset($this->curso['id']) ? $this->curso['id'] : null;

            // Obtén el token y el usuario de la sesión
            $token = session('token');
            $usuario = session('usuario');

            // Enviar la solicitud POST a la API con los datos del formulario
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->acceptJson()->post('http://localhost:8000/api/comentarios', [
                'id_usuario' => $usuario['id'],
                'comentario' => $this->comentario,
                'calificacion' => $this->calificacion,
                'commentable_type' => $commentableType,
                'commentable_id' => $commentableId
            ]);

            if ($response->successful()) {
                session(['usuario' => $response->json()['usuario']]);

                $this->curso = $response->json()['curso'];

                $this->dispatch('cursoActualizado', curso: $this->curso);

                // Si la solicitud fue exitosa, adjunta un mensaje de éxito a la redirección
                session()->flash('success', 'Comentario creado correctamente!');

                // Resetea los campos del formulario
                $this->comentario = '';
                $this->calificacion = 4;

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
}
