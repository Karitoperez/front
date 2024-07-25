<div>
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
    @endif
    @if (session('success'))
        <div class="alerta alerta-error">
            <div class="alerta__contenido shadow-md min-w-2xl">
                <h2 class="subtitulo text-green-600 my-4">Error</h2>
                <p class="text-center">
                    {{ session('success') }}
                </p>
                <button class="btnCerrarAlerta"><i class="fa-solid fa-x"></i></button>
            </div>
        </div>
    @endif --}}

    @if ($curso)
        @if (AuthHelper::estaAutenticado())
            <div class="contenedor">
                <a class="curso__volver" href="{{ route('misCursos') }}">Volver</a>
            </div>
        @endif
        <div class="curso contenedor">
            <div class="curso__izquierda">
                <div class="curso__imagen">
                    <img src="{{ $curso['imagen'] }}" alt="{{ $curso['titulo'] }}">
                </div>
                <div class="curso__info">
                    <h2 class="curso__titulo">{{ $curso['titulo'] }}</h2>
                    @php
                        $total_comentarios = count($curso['comentarios']);
                        $total_calificacion = 0;
                        foreach ($curso['comentarios'] as $comentario) {
                            $total_calificacion += $comentario['calificacion'];
                        }
                        $promedio_calificacion = $total_comentarios > 0 ? $total_calificacion / $total_comentarios : 0;
                    @endphp

                    <p class="curso__calificacion">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $promedio_calificacion)
                                <i class="fa-solid fa-star text-yellow-400"></i>
                            @else
                                <i class="fa-regular fa-star text-yellow-400"></i>
                            @endif
                        @endfor
                        <span>
                            {{ number_format($promedio_calificacion, 1) }}/5
                        </span>
                    </p>
                    {{-- <p class="curso__estado">{{ $curso['estado'] == 1 ? 'Activo' : 'Inactivo' }}</p> --}}

                    <p class="curso__categoria"><span><i class="fa-solid fa-list"></i>
                            {{ $curso['categoria']['nombre'] }}</span></p>


                    <p class="curso__docente"><i class="fa-solid fa-user-tie"></i>
                        {{ $curso['docente']['name'] . ' ' . $curso['docente']['apellido'] }}
                    </p>
                    <p class="curso__duracion"><i class="fa-regular fa-clock"></i> {{ $curso['duracion'] }}h
                    </p>
                    <p class="curso__estudiantes"> <i class="fa-solid fa-user-graduate"></i>
                        {{ count($curso['estudiantes']) }} </p>

                    @if (AuthHelper::estaAutenticado())
                        @if (AuthHelper::esDocenteDelCurso($curso['id_docente']))
                            <div>
                                <a class="curso__agregar-leccion bg-green-600 py-2"
                                    href="{{ route('cursos.edit', ['curso' => $curso['id']]) }}">Editar Curso</a>
                            </div>
                        @endif
                    @endif

                    <p class="curso__descripcion">{{ $curso['descripcion'] }}</p>

                    @if (AuthHelper::estaAutenticado())
                        @if (AuthHelper::esEstudiante() && !AuthHelper::inscritoEnCurso($curso['id']))
                            <form id="formInscripcion" method="post" action="{{ route('inscripcion.store') }}">
                                @csrf
                                <input type="hidden" name="id_estudiante" value="{{ $usuario['id'] }}">
                                <input type="hidden" name="id_curso" value="{{ $curso['id'] }}">
                                <button type="button" id="inscribirmeButton"
                                    class="curso__agregar-leccion my-2 inline-block bg-green-600">Inscribirme</button>
                            </form>
                        @endif
                        @if (AuthHelper::esEstudiante() && AuthHelper::inscritoEnCurso($curso['id']))
                            <p class="w-min p-2 bg-green-500 text-white text-base font-bold tracking-widest">Inscrito
                            </p>
                        @endif
                    @endif
                </div>
            </div>

            <div class="curso__contenido contenedor">
                <div class="curso__subtitulo">
                    <p>Contenido del curso</p>
                    @if (AuthHelper::estaAutenticado())
                        @if (AuthHelper::esDocenteDelCurso($curso['id_docente']))
                            <a class="curso__agregar-leccion bg-green-600"
                                href="{{ route('lecciones.create', ['curso' => $curso['id']]) }}">Agregar Lección</a>
                        @endif
                    @endif

                </div>
                <p class="curso__no-lecciones">No. Lecciones: {{ count($curso['lecciones']) }}</p>
                <ul class="curso__lecciones-lista">
                    @foreach ($curso['lecciones'] as $leccion)
                        <li class="curso__lecciones-titulo">
                            <a href="{{ route('lecciones.show', $leccion['id']) }}">{{ $leccion['titulo'] }}</a>

                            @if (AuthHelper::estaAutenticado())
                                @if (AuthHelper::esDocenteDelCurso($curso['id_docente']))
                                    <a href="{{ route('lecciones.edit', $leccion['id']) }}"
                                        class="usuarios__acciones-accion usuarios__acciones-ver">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="contenido-curso contenedor">
            <p class="curso__subtitulo">
                Comentarios
            </p>
            <p class="curso__no-lecciones">No. Comentarios: {{ count($curso['comentarios']) }}</p>

            @if (AuthHelper::estaAutenticado())
                @if (!AuthHelper::cursoComentado($curso['id']))
                    @if (AuthHelper::esEstudiante() && AuthHelper::inscritoEnCurso($curso['id']))
                        <!-- Modal -->
                        <div class=" bg-white w-[80%] md:max-w-lg rounded-lg shadow-lg">
                            <div class="flex flex-col justify-between h-full p-6">
                                <!-- Contenido del modal -->
                                <form wire:submit.prevent="agregarComentario" class="mb-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="comentario"
                                            class="block text-gray-700 font-bold mb-2">Comentario:</label>
                                        <textarea wire:model="comentario" id="comentario" rows="4" cols="50"
                                            class="w-full text-2xl border rounded-lg focus:outline-none focus:border-none px-4 py-2 resize-none"></textarea>
                                        @error('comentario')
                                            <p class="text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4 flex gap-4 items-center">
                                        <label class="block text-gray-700 font-bold">Calificación:</label>
                                        <div class="clasificacion">
                                            <input id="radio1" type="radio" wire:model="calificacion"
                                                name="estrellas" value="5">
                                            <label for="radio1">&#9733;</label>
                                            <input id="radio2" type="radio" wire:model="calificacion"
                                                name="estrellas" value="4">
                                            <label for="radio2">&#9733;</label>
                                            <input id="radio3" type="radio" wire:model="calificacion"
                                                name="estrellas" value="3">
                                            <label for="radio3">&#9733;</label>
                                            <input id="radio4" type="radio" wire:model="calificacion"
                                                name="estrellas" value="2">
                                            <label for="radio4">&#9733;</label>
                                            <input id="radio5" type="radio" wire:model="calificacion"
                                                name="estrellas" value="1">
                                            <label for="radio5">&#9733;</label>
                                        </div>
                                        @error('calificacion')
                                            <p class="formulario__error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Mostrar errores de validación para el campo calificacion -->
                                    @if ($errors->has('calificacion'))
                                        <p class="text-red-500">{{ $errors->first('calificacion') }}</p>
                                    @endif
                                    <!-- Botón para enviar el comentario -->
                                    <div class="flex flex-col justify-between items-center sm:flex-row gap-2">
                                        <button type="submit" class="bg-indigo-600 p-2 rounded text-white">Enviar
                                            comentario</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @endif
                @endif
            @endif

            @if ($mostrarFormEditar)
                <div class="bg-white w-[80%] md:max-w-lg rounded-lg shadow-lg">
                    <div class="flex flex-col justify-between h-full p-6">
                        <!-- Contenido del formulario de edición -->
                        <form wire:submit.prevent="actualizarComentario">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">

                                <label for="comentario" class="block text-gray-700 font-bold mb-2">Comentario</label>
                                <textarea wire:model='comentario' id="comentario" rows="4" cols="50"
                                    class="w-full text-2xl border rounded-lg focus:outline-none focus:border-none px-4 py-2 resize-none">{{ $this->comentarioModelo['comentario'] }}</textarea>
                                @error('comentario')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center gap-4 mb-2">
                                <label for="calificacion" class="block text-gray-700 font-bold">Calificación</label>
                                <div class="clasificacion">
                                    <input id="radio1" type="radio" wire:model="calificacion" name="estrellas"
                                        value="5">
                                    <label for="radio1">&#9733;</label>
                                    <input id="radio2" type="radio" wire:model="calificacion" name="estrellas"
                                        value="4">
                                    <label for="radio2">&#9733;</label>
                                    <input id="radio3" type="radio" wire:model="calificacion" name="estrellas"
                                        value="3">
                                    <label for="radio3">&#9733;</label>
                                    <input id="radio4" type="radio" wire:model="calificacion" name="estrellas"
                                        value="2">
                                    <label for="radio4">&#9733;</label>
                                    <input id="radio5" type="radio" wire:model="calificacion" name="estrellas"
                                        value="1">
                                    <label for="radio5">&#9733;</label>
                                </div>
                            </div>
                            <div class="flex flex-col justify-between items-center sm:flex-row gap-2">
                                <button type="submit" class="bg-indigo-600 p-2 rounded text-white">Guardar</button>
                                <button type="button" wire:click.prevent="cerrarModalEditar"
                                    class="bg-gray-400 p-2 rounded text-white">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <div class="curso__valoraciones">
                @foreach ($curso['comentarios'] as $comentario)
                    <div class="curso__valoracion shadow-md">
                        <div class="curso__valoracion-info">
                            <img src="{{ $comentario['user']['imagen'] }}" alt="{{ $comentario['user']['name'] }}">
                            <div>
                                <span>{{ $comentario['user']['name'] }}</span>
                                <span>
                                    @php
                                        $calificacion = $comentario['calificacion'];
                                        $estrellas = min(max(round($calificacion), 0), 5); // Asegúrate de que la calificación esté entre 0 y 5
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $estrellas)
                                            <i class="fa-solid fa-star text-yellow-400 text-sm"></i>
                                        @else
                                            <i class="fa-regular fa-star text-yellow-400 text-sm"></i>
                                        @endif
                                    @endfor
                                </span>
                            </div>
                        </div>
                        <p>{{ $comentario['comentario'] }}</p>
                        @if ($usuario)
                            @if (AuthHelper::comentarioUsuario($comentario['id_usuario']))
                                <!-- Verifica si el comentario pertenece al usuario actual -->
                                <button wire:click.prevent="abrirModalEditar({{ json_encode($comentario) }})"
                                    class="absolute right-0 top-0 bg-green-600 text-white"><i
                                        class="text-[16px] p-2 transition-all hover:text-[18px] fa-regular fa-pen-to-square"></i></button>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('cursoActualizado', function(cursoData) {
                console.log('Curso actualizado:', cursoData);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {

            const inscribirmeButton = document.getElementById('inscribirmeButton');
            const form = document.getElementById('formInscripcion');

            if (inscribirmeButton) {
                inscribirmeButton.addEventListener('click', async () => {
                    const confirmation = await Swal.fire({
                        title: "¿Estás seguro de que deseas inscribirte en este curso?",
                        text: "Esta acción es irreversible.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, inscribirme",
                    });

                    if (confirmation.isConfirmed) {
                        form.submit(); // Submit the form if user confirms
                    }
                });
            }

            const abrirModal = document.getElementById('abrirModal');
            const cerrarModal = document.getElementById('cerrarModal');
            const modal = document.getElementById('modal');

            if (modal) {


                abrirModal.addEventListener('click', () => {
                    modal.classList.remove('hidden');
                });

                cerrarModal.addEventListener('click', () => {
                    modal.classList.add('hidden');
                });
            }
        });
    </script>
@endpush
