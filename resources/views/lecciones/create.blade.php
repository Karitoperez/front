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

    <form class="formulario shadow-md" action="{{ route('lecciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p class="formulario__titulo">Nueva Lección</p>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="titulo" class="">Título</label>
                <input type="text" name="titulo" id="titulo" class="" placeholder=" "
                    value="{{ old('titulo') }}" />
                @error('titulo')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="estado" class="">Estado</label>
                <select id="estado" name="estado" class="">
                    <option class="" disabled selected>--Seleccione--</option>
                    <option class="" value="1">Activo</option>
                    <option class="" value="0">Inactivo</option>
                </select>
                @error('estado')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="id_curso" class="">Curso</label>
                <input type="text" value="{{ $curso['titulo'] }}" readonly>
                <input type="hidden" name="id_curso" value="{{ $curso['id'] }}">
                @error('id_curso')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__contenido">
            <label for="descripcion" class="">Descripción</label>
            <textarea type="text" name="descripcion" id="descripcion" class="textarea" placeholder="">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="formulario__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" id="imagen">
            </div>
            <div class="formulario__contenido">
                <label for="orden">Orden</label>
                <input type="number" name="orden" id="orden" placeholder="Agregue el orden de la lección" min="1">  
            </div>
        </div>

        <button type="submit" class="formulario__boton">Agregar Lección</button>
    </form>
@endsection
