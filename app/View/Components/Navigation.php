<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Helpers\AuthHelper;
use Illuminate\Support\Facades\Auth;

class Navigation extends Component
{
    public $usuario;
    public function __construct()
    {
        $this->usuario = session("usuario");
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navigation', [
            "usuario" => $this->usuario
        ]);
    }
}
