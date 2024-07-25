<div class="relative">

    {{--     @if (session('error'))
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
    @endif --}}

    @if ($leccion)
        <div class="contenedor">
            <a class="curso__volver" href="{{ route('cursos.index', $usuario['usuario']) }}">Volver</a>
        </div>
        <div class="curso contenedor">
            <div class="curso__imagen">
                <img src="{{ $leccion['imagen'] }}" alt="{{ $leccion['titulo'] }}" class="curso__imagen">
            </div>
            <div class="curso__info">
                <h2 class="curso__titulo">{{ $leccion['titulo'] }}</h2>
                <p class="curso__descripcion">{{ $leccion['descripcion'] }}</p>
            </div>
        </div>

        @if (AuthHelper::esDocenteDelCurso($leccion['id_docente']))
            <button wire:click.prevent="abrirModalCrear({{ $leccion['id'] }})" class="p-2 bg-green-600 text-white"><i
                    class="text-[16px] p-2 transition-all hover:text-[18px] fa-regular fa-pen-to-square"></i>Agregar
                Archivo</button>
        @endif

    @empty($leccion['archivos'])
        <p>Aún no has agregado archivos</p>
    @endempty

    <h2 class="contenedor subtitulo text-indigo-600">Archivos de apoyo</h2>

    <div class="archivos my-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($leccion['archivos'] as $archivo)
            @if ($archivo['tipo'] === 'PDF')
                <div class="archivo shadow-md p-4 rounded-lg">
                    <p class="font-semibold">Tipo: {{ $archivo['tipo'] }}</p>
                    <p class="mt-2">Nombre: {{ $archivo['nombre'] }}</p>
                    <div class="mt-4">
                        <embed src="{{ $archivo['ubicacion'] }}" type="application/pdf" class="w-full h-64 lg:h-96">
                    </div>
                    <div class="mt-4">
                        <a href="{{ $archivo['ubicacion'] }}" class="block text-blue-500 hover:underline"
                            download>Descargar</a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="archivos my-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($leccion['archivos'] as $archivo)
            @if ($archivo['tipo'] === 'Imagen')
                <div class="archivo shadow-md p-4 rounded-lg">
                    <p class="font-semibold">Tipo: {{ $archivo['tipo'] }}</p>
                    <p class="mt-2">Nombre: {{ $archivo['nombre'] }}</p>
                    <img src="{{ $archivo['ubicacion'] }}" alt="{{ $archivo['nombre'] }}"
                        class="w-full h-64 lg:h-96">
                </div>
            @endif
        @endforeach
    </div>

    <div class="archivos my-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($leccion['archivos'] as $archivo)
            @if ($archivo['tipo'] === 'Video')
                <div class="archivo shadow-md p-4 rounded-lg">
                    <p class="font-semibold">Tipo: {{ $archivo['tipo'] }}</p>
                    <p class="mt-2">Nombre: {{ $archivo['nombre'] }}</p>
                    <video controls class="w-full">
                        <source src="{{ $archivo['ubicacion'] }}" type="video/mp4" class="w-full h-64 lg:h-96">
                    </video>
                </div>
            @endif
        @endforeach
    </div>
@endif

@if ($mostrarFormCrear)
    <div
        class="fixed flex items-center justify-center top-0 left-0 right-0 bottom-0 bg-[rgba(0,0,0,0.5)] backdrop-blur z-10">
        <div class="bg-white w-[80%] p-[20px] md:max-w-lg rounded-lg shadow-lg" <div
            class="flex flex-col justify-between h-full p-6">
            <!-- Contenido del formulario de edición -->
            <form wire:submit.prevent="agregarArchivo">
                @csrf
                <legend class="subtitulo text-indigo-600">Agregar Archivo</legend>
                <div class="formulario__contenido">
                    <label for="nombre" class="">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="" wire:model='nombre'
                        placeholder=" " value="{{ old('nombre') }}" />
                    @error('nombre')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__campo">
                    <div class="formulario__contenido">
                        <label for="ubicacion">Archivo/MP4,JPG,PNG,JPEG,PDF</label>
                        <input type="file" name="ubicacion" id="ubicacion" accept=".mp4, .jpg, .png, .jpeg, .pdf"
                            wire:model='ubicacion'>
                        @error('ubicacion')
                            <p class="formulario__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-col justify-between items-center sm:flex-row gap-2">
                    <button type="submit" class="bg-indigo-600 p-2 rounded text-white">Agregar</button>
                    <button type="button" wire:click="cerrarModalCrear"
                        class="bg-gray-400 p-2 rounded text-white">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
</div>
