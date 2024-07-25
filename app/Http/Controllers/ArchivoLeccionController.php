<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;

class ArchivoLeccionController extends Controller
{
    public function index()
    {
        if (!AuthHelper::estaAutenticado()) {
            if (!AuthHelper::estaAutenticado()) {
                return redirect()->back()->with('error', 'Debe iniciar sesión');
            }
        }

        return view("archivoLeccion.index");
    }
   
    public function create()
    {
        if (!AuthHelper::estaAutenticado()) {
            if (!AuthHelper::estaAutenticado()) {
                return redirect()->back()->with('error', 'Debe iniciar sesión');
            }
        }

        return view("archivoLeccion.index");
    }
}
