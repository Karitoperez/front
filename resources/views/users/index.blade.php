@extends('layouts.app')

@section('content')
    <div class="usuarios contenedor">
        @if (session('error'))
            <div class="alerta alerta-error">
                <div class="alerta__contenido shadow-md min-w-2xl">
                    <h2 class="subtitulo text-red-600 my-4">Error</h2>
                    <p class="text-center">
                        {{ session('error') }}
                    </p>
                    <button class="btnCerrarAlerta"><i class="fa-solid fa-x"></i></button>
                </div>
            </div>
        @elseif (session('success'))
            <div class="alerta alerta-success">
                <div class="alerta__contenido shadow-md min-w-2xl">
                    <h2 class="subtitulo text-green-600 my-4">Éxito</h2>
                    <p class="text-center">
                        {{ session('success') }}
                    </p>
                    <button class="btnCerrarAlerta"><i class="fa-solid fa-x"></i></button>
                </div>
            </div>
        @endif

        <h1 class="usuarios__titulo">Listado de Usuarios</h1>

        <livewire:listar-usuarios />
    </div>
@endsection
