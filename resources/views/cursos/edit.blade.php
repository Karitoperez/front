@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alerta alerta-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alerta alerta-error">
            {{ session('error') }}
        </div>
    @endif

    <form class="formulario shadow-md" action="{{ route('cursos.update', ['curso' => $curso['id']]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Usamos el método PUT para enviar la solicitud de actualización --}}
        <p class="formulario__titulo">Editar Curso</p>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="titulo" class="">Título</label>
                <input type="text" name="titulo" id="titulo" class="" placeholder=" "
                    value="{{ $curso['titulo'] }}" />
                @error('titulo')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="formulario__contenido">
                <label for="duracion" class="">Duración</label>
                <input type="number" name="duracion" id="duracion" class="" placeholder=" "
                    value="{{ $curso['duracion'] }}" />
                @error('duracion')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="estado" class="">Estado</label>
                <select id="estado" name="estado" class="">
                    <option class="" value="1" {{ $curso['estado'] == 1 ? 'selected' : '' }}>Activo</option>
                    <option class="" value="0" {{ $curso['estado'] == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="id_categoria" class="">Categoria</label>
                <select id="id_categoria" name="id_categoria">
                    <option disabled selected>--Seleccione--</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria['id'] }}"
                            {{ $curso['id_categoria'] == $categoria['id'] ? 'selected' : '' }}>{{ $categoria['nombre'] }}
                        </option>
                    @endforeach
                </select>
                @error('id_categoria')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="" placeholder=""
                    value="{{ $curso['fecha_inicio'] }}" />
                @error('fecha_inicio')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="fecha_fin">Fecha Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="" placeholder=""
                    value="{{ $curso['fecha_fin'] }}" />
                @error('fecha_fin')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__contenido">
            <label for="descripcion" class="">Descripción</label>
            <textarea type="text" name="descripcion" id="descripcion" class="textarea" placeholder="">{{ $curso['descripcion'] }}</textarea>
            @error('descripcion')
                <p class="formulario__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <img class="w-44 mx-auto" src="{{ $curso['imagen'] }}" alt="Imagen usuario {{ $curso['titulo'] }}">
            </div>
            <div class="formulario__contenido">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen">
            </div>
        </div>

        <button type="submit" class="formulario__boton">Actualizar Curso</button>
    </form>
@endsection
