<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CreateUserForm extends Component
{
    public $users;

    public function mount()
    {
        $response = Http::get('http://localhost:8000/api/usuarios');

        $this->users = $response->json();

        dd($users);
    }

    public function render()
    {
        return view('livewire.create-user-form');
    }
}
