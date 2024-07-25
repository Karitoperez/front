@extends('layouts.app')

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

    @if (AuthHelper::esAdministrador())
        <div class="contenedor">
            <a class="curso__volver" href="{{ route('usuarios.index') }}">Volver</a>
        </div>
    @endif
    @if (AuthHelper::esUsuarioActual($usuario['id']))
        <form class="formulario shadow-md my-2" action="{{ route('usuarios.update', ['id' => $usuario['id']]) }}"
            method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <p class="formulario__titulo">Perfil</p>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" placeholder=" "
                        value="{{ old('nombre', $usuario['name']) }}" />
                    @error('nombre')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="formulario__contenido">
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" placeholder=" "
                        value="{{ old('apellido', $usuario['apellido']) }}" />
                    @error('apellido')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="id_tipo_documento">Tipo de documento</label>
                    <select id="id_tipo_documento" name="id_tipo_documento">
                        <option disabled selected>--Seleccione--</option>
                        <option value="1"
                            {{ old('id_tipo_documento', $usuario['id_tipo_documento']) == 1 ? 'selected' : '' }}>TI</option>
                        <option value="2"
                            {{ old('id_tipo_documento', $usuario['id_tipo_documento']) == 2 ? 'selected' : '' }}>CC</option>
                    </select>
                    @error('id_tipo_documento')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="numero_documento">No. de documento</label>
                    <input type="text" name="numero_documento" id="numero_documento" placeholder=" "
                        value="{{ old('numero_documento', $usuario['numero_documento']) }}" />
                    @error('numero_documento')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" placeholder=""
                        value="{{ old('fecha_nacimiento', $usuario['fecha_nacimiento']) }}" />
                    @error('fecha_nacimiento')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" placeholder=" "
                        value="{{ old('direccion', $usuario['direccion']) }}" />
                    @error('direccion')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email" placeholder=""
                        value="{{ old('email', $usuario['email']) }}" />
                    @error('email')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" placeholder=""
                        value="{{ old('usuario', $usuario['usuario']) }}" />
                    @error('usuario')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <img class="w-44 mx-auto" src="{{ $usuario['imagen'] }}" alt="Imagen usuario {{ $usuario['name'] }}">
                </div>
                <div class="formulario__contenido">
                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" id="imagen">
                </div>
            </div>
            <button type="submit" class="formulario__boton">Guardar</button>
        </form>
    @else
        <section class="flex items-center justify-center my-10">
            <div class="w-full lg:w-1/3 px-6 p-2 shadow-lg rounded-md shadow-indigo-200">
                <div class="flex flex-wrap justify-center my-10">
                    <div class="px-4 flex justify-center">
                        <img class="drop-shadow-sm" src="{{ $usuario['imagen'] }}" alt="Imagen">
                    </div>
                </div>
                <div class="text-center mt-12">
                    <h3 class=" font-semibold leading-normal text-indigo-700 mb-2">
                        {{ $usuario['name'] . ' ' . $usuario['apellido'] }}
                    </h3>
                    <div class=" leading-normal mt-0 mb-2 text-indigo-400 font-bold uppercase">
                        {{ $usuario['name'] }} | {{ $usuario['id_rol'] }}
                    </div>
                    <div class="mb-2 text-indigo-600 mt-10">
                        <p><i class="fas fa-university mr-2 text-lg text-indigo-400"></i>Ingeniero en Sistenas y
                            Computación</p>
                    </div>
                    <div class="mb-2 text-indigo-600">

                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis maxime accusantium fuga temporibus
                            impedit modi!</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
