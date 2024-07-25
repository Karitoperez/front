<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavigationAuth extends Component
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
        return view('components.navigation-auth', [
            "usuario" => $this->usuario
        ]);
    }
}
