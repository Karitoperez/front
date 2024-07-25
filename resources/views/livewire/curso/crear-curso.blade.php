<div>
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

    <div class="contenedor">
        <a class="curso__volver" href="{{ route('misCursos') }}">Volver</a>
    </div>

    <form class="formulario shadow-md" wire:submit.prevent="crearCurso" enctype="multipart/form-data">
        @csrf
        <p class="formulario__titulo">Nuevo Curso</p>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="titulo" class="">Título</label>
                <input type="text" wire:model="titulo" id="titulo" class="" placeholder=" "
                    value="{{ old('titulo') }}" />
                @error('titulo')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="formulario__contenido">
                <label for="duracion" class="">Duración</label>
                <input type="number" wire:model="duracion" id="duracion" class="" placeholder=" "
                    value="{{ old('duracion') }}" />
                @error('duracion')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="estado" class="">Estado</label>
                <select id="estado" wire:model="estado">
                    <option selected>--Seleccione--</option>
                    <option value="1" {{ old('estado') == 1 ? 'selected' : '' }}>Activo </option>
                    <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="id_categoria" class="">Categoria</label>
                <select id="id_categoria" wire:model="id_categoria">
                    <option selected>--Seleccione--</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria['id'] }}"
                            {{ old('id_categoria') == $categoria['id'] ? 'selected' : '' }}>{{ $categoria['nombre'] }}
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
                <label for="fecha_inicio">Fecha
                    Inicio</label>
                <input type="date" wire:model="fecha_inicio" id="fecha_inicio" class="" placeholder=""
                    value="{{ old('fecha_inicio') }}" />
                @error('fecha_inicio')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="fecha_fin">Fecha
                    Fin</label>
                <input type="date" wire:model="fecha_fin" id="fecha_fin" class="" placeholder=""
                    value="{{ old('fecha_fin') }}" />
                @error('fecha_fin')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="imagen">Imagen</label>
                <input type="file" wire:model="imagen" id="imagen">
                @error('imagen')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__contenido">
            <label for="descripcion" class="">Descripción</label>
            <textarea type="text" wire:model="descripcion" id="descripcion" class="textarea" placeholder="">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="formulario__error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="formulario__boton">Crear Curso</button>
    </form>
</div>
