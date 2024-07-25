@extends('layouts.guest')

@section('content')
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
    @endif

    <div class="min-h-screen flex justify-center items-center">
        <form class="formulario max-w-2xl shadow-md" action="{{ route('login') }}" method="POST">
            @csrf
            <p class="formulario__titulo">Login</p>

            <div class="formulario__contenido">

                <label for="email">Correo</label>
                <input type="text" name="email" id="email" placeholder="Correo Electrónico"
                    value="{{ old('email') }}" />
                @error('email')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="formulario__contenido">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" class="" placeholder="Contraseña"/>
                @error('password')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="formulario__boton">Iniciar Sesión</button>
        </form>
    </div>
@endsection
