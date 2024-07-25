<?php

namespace App\Livewire\Teacher;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class TeacherCourses extends Component
{

    public $cursos;
    public $cursosUsuario;
    public $categorias;
    public $usuario;
    public $cursosFiltrados;
    public $titulo = "Todos";

    protected $listeners = ["confirmarEliminarCurso"];

    public function render()
    {
        // Asigna los cursos del usuario y todos los cursos a la propiedad $cursos
        $this->mostrarCursos();
        return view('livewire.teacher.teacher-courses');
    }

    public function mostrarCursos()
    {
        $this->titulo = "Todos";
        $this->cursosFiltrados = null;

        // Almacena todos los cursos del usuario en $this->cursosUsuario
        $this->cursosUsuario = collect($this->cursos)->filter(function ($curso) {
            return $curso["id_docente"] === $this->usuario["id"];
        })->all();

        // Asigna los cursos del usuario a la propiedad $cursos
        $this->cursos = $this->cursosUsuario;
    }

    public function filtrarPorCategoria($id_categoria, $nombre_categoria)
    {
        // Si no se proporciona una categoría, mostrar todos los cursos del usuario
        /*         if ($id_categoria === null) {
            $this->cursos = $this->cursosUsuario;
            return;
        } */

        // Filtra todos los cursos del usuario original por la categoría seleccionada
        $this->cursosFiltrados = collect($this->cursosUsuario)->filter(function ($curso) use ($id_categoria) {
            return $curso['id_categoria'] === $id_categoria;
        })->all();

        $this->titulo = $nombre_categoria;

        // Asigna los cursos filtrados a la propiedad $cursos
        $this->cursos = $this->cursosFiltrados;
    }

    #[On('eliminarCurso')]
    public function eliminarCurso($id)
    {
        try {
            // Obtener el token de la sesión
            $token = session('token');
            $usuario = session('usuario');

            // Enviar la solicitud DELETE a la API para eliminar el curso
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->delete('http://localhost:8000/api/cursos/' . $id);

            if ($response->successful()) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->delete('http://localhost:8000/api/cursos');

                if ($response->successful()) {

                    // Mensaje de éxito
                    session()->flash('success', 'Curso eliminado correctamente!');
                    // Despacha un evento indicando que el usuario fue eliminado
                    $this->dispatch('CursoEliminado');
                    $this->cursos = $response->json("cursos");

                    $this->mostrarCursos();

                    return redirect()->back();
                }
            } else {
                // Si la solicitud no fue exitosa, mostrar un mensaje de error
                return redirect()->route('cursos.index', $usuario["usuario"])->with('error', 'Error al eliminar el curso');
            }
        } catch (\Exception $e) {
            // Si ocurre un error, mostrar un mensaje de error
            return redirect()->route('cursos.index', $usuario["usuario"])->with('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }
}
