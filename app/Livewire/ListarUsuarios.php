<?php

namespace App\Livewire;

use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListarUsuarios extends Component
{
    use WithPagination, WithFileUploads;

    public $usuarios;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $numero_identificacion;
    public $rol = 0;
    public $usuario;
    public $id_usuario;
    public $estado = 1;
    public $imagen;
    public $imagen_nueva;

    public $busqueda;

    public $modalAgregar = false;
    public $modalEditar = false;

    protected $listeners = ["confirmarEliminarUsuario"];

    public function render()
    {
        $this->mostrarUsuarios();
        return view('livewire.usuario.listar-usuarios');
    }

    public function mostrarUsuarios()
    {
        $token = session('token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get(env("API_URL") . "/usuarios");

        $this->usuarios = $response->json("usuarios");

        if ($this->busqueda != null) {
            $this->buscarUsuarios();
        }
    }

    public function buscarUsuarios()
    {
        $token = session("token");
        $url = env("API_URL") . "/usuarios/buscar";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->post($url, [
            "busqueda" => $this->busqueda
        ]);

        $this->usuarios = $response->json("usuarios");
    }



    // Métodos para abrir y cerrar modales
    public function abrirModalAgregar()
    {
        $this->resetForm();
        $this->modalAgregar = true;
    }

    public function cerrarModalAgregar()
    {
        $this->modalAgregar = false;
    }

    public function abrirModalEditar($id)
    {
        $this->reset();

        $token = session("token");
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->get(env("API_URL") . "/usuarios/" . $id);
        $usuario = $response->json("usuario");

        // Llenar los campos del formulario con los detalles del usuario
        $this->id_usuario = $usuario["id"];
        $this->name = $usuario["name"];
        $this->rol = $usuario["id_rol"];
        $this->modalEditar = true;
    }

    public function cerrarModalEditar()
    {
        $this->modalEditar = false;
    }

    #[On('eliminarUsuario')]
    public function eliminarUsuario($id)
    {
        if (!AuthHelper::estaAutenticado()) {
            return redirect()->back()->with('error', 'Debe iniciar sesión');
        }

        if (!AuthHelper::esUsuarioActual($id) && !AuthHelper::esAdministrador()) {
            return redirect()->back()->with('error', 'No tiene permisos');
        }

        $token = session("token");

        // Realizar la solicitud GET a la API de cursos con el token de autenticación
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->acceptJson()->delete(env("API_URL") . "/usuarios/" . $id);

        if ($response->successful()) {
            // Obtiene los datos de la respuesta JSON
            $data = $response->json();
            // Extrae el mensaje de la respuesta
            $mensaje = $data['message'];
            // Muestra el mensaje en la pantalla
            session()->flash('success', $mensaje);
            // Despacha un evento indicando que el usuario fue eliminado
            $this->dispatch('usuarioEliminado');
        } else {
            // En caso de que la solicitud no sea exitosa, muestra un mensaje de error
            session()->flash('error', 'Error al eliminar el usuario: ' . $response->status());
        }
    }
}
