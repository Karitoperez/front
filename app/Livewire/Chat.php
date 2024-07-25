<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Chat extends Component
{
    public $conversaciones;
    public $conversacionSeleccionada;
    public $mensajes = [];
    public $mensaje;
    public $usuarios;
    public $modalConversacion = false;
    public $conversacionActual;
    public $token;
    public $usuarioAuth;
    public $usuarioSeleccionadoId;
    public $busqueda;

    protected $rules = [
        'mensaje' => 'required|string',
    ];

    public function mount()
    {
        $this->token = session("token");
        $this->usuarioAuth = session("usuario");
        $this->mostrarConversaciones();
        $this->cargarUsuarios();
    }

    public function mostrarConversaciones()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/chat");

        $this->conversaciones = $response->json("conversaciones");
    }

    public function abrirModalMensajes($conversacionId = null)
    {
        $this->resetValidation();
        $this->reset("mensaje");
        $this->modalConversacion = true;
        $this->conversacionActual = null;
        $this->cargarMensajes($conversacionId);
    }
    public function abrirModalConversacion($usuarioId = null)
    {
        $this->resetValidation();
        $this->reset("mensaje");
        $this->modalConversacion = true;
        $this->conversacionActual = null;
        $this->usuarioSeleccionadoId = $usuarioId;
    }

    public function cerrarModalConversacion()
    {
        $this->modalConversacion = false;
    }

    public function cargarUsuarios()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/usuarios");

        $this->usuarios = $response->json("usuarios");
    }

    public function cargarMensajes($conversacionId = null)
    {
        if ($conversacionId == null) {
            return;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->get(env("API_URL") . "/chat/{$conversacionId}");

        $this->conversacionActual = $response->json("conversacion");
        $this->mensajes = $this->conversacionActual['mensajes'];

    }

    public function enviarMensaje()
    {
        $this->validate();

        if ($this->conversacionActual === null) {
            $this->crearConversacion();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post(env("API_URL") . "/chat/{$this->conversacionActual["id"]}/enviar-mensaje", [
            "mensaje" => $this->mensaje,
            "estado" => 1
        ]);

        $this->conversacionActual = $response->json("conversacion");

        $this->cargarMensajes($this->conversacionActual["id"]);

        $this->reset('mensaje');
    }

    public function crearConversacion()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->acceptJson()->post(env("API_URL") . "/chat/conversaciones/crear", [
            "usuarios" => [$this->usuarioAuth["id"], $this->usuarioSeleccionadoId]
        ]);

        $this->conversacionActual = $response->json("conversacion");
        $this->usuarioAuth = session(["usuario" => $response->json("usuario")]);
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
