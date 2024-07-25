@extends('layouts.app')

@section('content')
{{--     @if (session('success'))
        <div class="alerta alerta-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alerta alerta-error">
            {{ session('error') }}
        </div>
    @endif --}}

    <form class="formulario shadow-md" action="{{ route('lecciones.update', $leccion['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <p class="formulario__titulo">Editar Lección</p>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="titulo" class="">Título</label>
                <input type="text" name="titulo" id="titulo" class="" placeholder=" " value="{{ old('titulo', $leccion['titulo']) }}" />
                @error('titulo')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="estado" class="">Estado</label>
                <select id="estado" name="estado" class="">
                    <option class="" value="1" {{ $leccion['estado'] ? 'selected' : '' }}>Activo</option>
                    <option class="" value="0" {{ !$leccion['estado'] ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="id_curso" class="">Curso</label>
                <input type="text" value="{{ $leccion['curso']['titulo'] }}" readonly>
                <input type="hidden" name="id_curso" value="{{ $leccion['curso']['id'] }}">
                @error('id_curso')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__contenido">
            <label for="descripcion" class="">Descripción</label>
            <textarea type="text" name="descripcion" id="descripcion" class="textarea" placeholder="">{{ old('descripcion', $leccion['descripcion']) }}</textarea>
            @error('descripcion')
                <p class="formulario__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <img class="w-44 mx-auto" src="{{ $leccion['imagen'] }}" alt="Imagen lección {{ $leccion['titulo'] }}">
            </div>
            <div class="formulario__contenido">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen">
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="orden">Orden</label>
                <input type="number" name="orden" id="orden" placeholder="Agregue el orden de la lección" value="{{ old('orden', $leccion['orden']) }}">  
            </div>
        </div>

        <button type="submit" class="formulario__boton">Actualizar Lección</button>
    </form>
@endsection
