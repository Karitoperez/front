<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateUserForm extends Component
{
    public $usuarios;

    public function mount()
    {
        $response = Http::get('http://localhost:8000/api/usuarios');

        $this->usuarios = $response->json();

    }

    public function render()
    {
        return view('livewire.create-user-form');
    }
}
