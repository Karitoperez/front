<?php

// app/Helpers/AuthHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class AuthHelper
{
    /**
     * Verifica si hay un usuario autenticado en sesión.
     *
     * @return bool
     */
    public static function estaAutenticado()
    {
        $token = session('token');
        $usuario = session('usuario');

        // Verificar si el token y el usuario no son nulos
        if ($token !== null && $usuario !== null) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario es el docente del curso.
     *
     * @param int $idDocenteCurso
     * @return bool
     */
    public static function esDocenteDelCurso($idDocenteCurso)
    {
        $usuario = session('usuario');

        if ($usuario['id'] === $idDocenteCurso) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario es el usuario actual.
     *
     * @param int $idUsuario
     * @return bool
     */
    public static function esUsuarioActual($idUsuario)
    {
        $usuario = session('usuario');

        if ($usuario['id'] == $idUsuario) {
            return true;
        }

        return false;
    }


    /**
     * Verifica si el usuario es administrador.
     *
     * @return bool
     */
    public static function esAdministrador()
    {
        $usuario = session('usuario');

        if ($usuario && $usuario['id_rol'] === 1) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario está inscrito en el curso.
     *
     * @param int $idCurso
     * @return bool
     */
    public static function inscritoEnCurso($idCurso)
    {
        $usuario = session('usuario');
        // Verificar si hay un usuario en sesión y si tiene cursos inscritos
        if ($usuario && isset($usuario['cursos_estudiante'])) {
            // Verificar si el usuario está inscrito en el curso
            foreach ($usuario['cursos_estudiante'] as $curso) {
                if ($curso['id'] == $idCurso) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Verifica si el usuario es estudiante.
     *
     * @return bool
     */
    public static function esEstudiante()
    {
        $usuario = session('usuario');

        if ($usuario && $usuario['id_rol'] === 2) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario es docente.
     *
     * @return bool
     */
    public static function esDocente()
    {
        $usuario = session('usuario');

        if ($usuario && $usuario['id_rol'] === 3) {
            return true;
        }

        return false;
    }

    /**
     * Verifica si el usuario ha comentado en el curso.
     *
     * @param int $idCurso
     * @return bool
     */
    public static function cursoComentado($idCurso)
    {
        $usuario = session('usuario');

        if ($usuario && isset($usuario['comentarios'])) {
            foreach ($usuario['comentarios'] as $comentario) {
                if ($comentario['commentable_id'] == $idCurso && $comentario['commentable_type'] === 'App\Models\Curso') {
                    return true;
                }
            }
        }

        return false;
    }




    public static function comentarioUsuario($idUsuario)
    {
        $usuario = session('usuario');

        if ($usuario && isset($usuario['comentarios'])) {
            if ($usuario['id'] === $idUsuario) {
                return true;
            }
        }

        return false;
    }
}
