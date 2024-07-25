<?php

namespace App\Livewire\Student;

use Livewire\Component;

class StudentCourses extends Component
{

    public $cursos;
    public $categorias;
    public $cursosFiltrados;
    public $titulo = "Todos";

    public function render()
    {
        return view('livewire.student.student-courses');
    }

    public function mostrarCursos()
    {
        $this->titulo = "Todos";
        $this->cursosFiltrados = null;
    }

    public function filtrarPorCategoria($id_categoria, $nombre_categoria)
    {
        // Si no se proporciona una categoría, mostrar todos los cursos
        if ($id_categoria === null) {
            // No se aplica ningún filtro, se devuelven todos los cursos
            return $this->cursos;
        }

        // Filtrar los cursos por la categoría seleccionada
        $this->cursosFiltrados = collect($this->cursos)->filter(function ($curso) use ($id_categoria) {
            return $curso['id_categoria'] === $id_categoria;
        })->all();

        $this->titulo = $nombre_categoria;

        return $this->cursosFiltrados;
    }
}
