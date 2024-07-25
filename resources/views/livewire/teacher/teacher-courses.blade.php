<div class="dashboard">
    <h1 class="titulo">Mis Cursos</h1>

    <div>
        <a href="{{ route('cursos.create') }}" class="curso__agregar-leccion bg-green-600">
            <span><i class="fa-solid fa-plus"></i> Agregar Curso</span>
        </a>
    </div>

    @empty($cursos)
        <div class="docente__no">
            <p class="docente__no-cursos">No has creado cursos todavía.</p><a class="docente__no-btn"
                href="{{ route('cursos.create') }}">Crear Curso</a>
        </div>
    @else
        <div class="dashboard__categorias">
            <p class="subtitulo">Categorias</p>
            <ul class="dashboard__categorias-lista">
                <li><button wire:click.prevent="mostrarCursos">{{ $titulo }}</button></li>
                @empty($cursosFiltrados)
                    @foreach ($cursos as $curso)
                        <li>
                            <button
                                wire:click.prevent="filtrarPorCategoria({{ $curso['categoria']['id'] }}, '{{ $curso['categoria']['nombre'] }}')">
                                {{ $curso['categoria']['nombre'] }}
                            </button>
                        </li>
                    @endforeach
                @endempty
            </ul>
        </div>
        <div class="dashboard__principal">
            <p class="mas-popular__titulo capitalize">{{ $titulo }}</p>
            <div class="mas-popular">
                <div class="mas-popular__cursos">
                    @empty($cursosFiltrados)
                        @foreach ($cursos as $curso)
                            @php
                                extract($curso);
                            @endphp
                            <div class="grid grid-cols-1 md:grid-cols-2 overflow-hidden gap-2 shadow-md">
                                <img src="{{ $imagen }}" alt="{{ $titulo }}"
                                    class="h-60 md:h-full w-full object-contain">
                                <div class="py-4">
                                    <p class="font-bold leading-7">{{ $titulo }}</p>
                                    <p class="capitalize text-2xl"><span>Por:
                                        </span>{{ $docente['name'] . ' ' . $docente['apellido'] }}
                                    </p>
                                    <p class="capitalize text-2xl"><span><i class="fa-regular fa-clock"></i></span>
                                        {{ $duracion }} Horas</p>

                                    @php
                                        $total_comentarios = count($curso['comentarios']);
                                        $total_calificacion = 0;
                                        foreach ($curso['comentarios'] as $comentario) {
                                            $total_calificacion += $comentario['calificacion'];
                                        }
                                        $promedio_calificacion =
                                            $total_comentarios > 0 ? $total_calificacion / $total_comentarios : 0;
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

                                    <div class="">
                                        <a href="{{ route('cursos.show', ['id' => $curso['id']]) }}" class="inline-block">
                                            <i class="fa-solid fa-eye bg-green-600 text-white p-2"></i>
                                        </a>
                                        <a href="{{ route('cursos.edit', ['curso' => $curso['id']]) }}" class="">
                                            <i class="fa-solid fa-pen bg-blue-600 text-white p-2"></i>
                                        </a>
                                        <button
                                            wire:click.prevent="$dispatch('confirmarEliminarCurso', { id: {{ $curso['id'] }} })">
                                            <i class="fa-solid fa-trash bg-red-600 text-white p-2"></i>
                                        </button>
                                    </div>


                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($cursosFiltrados as $curso)
                            <div class="para-aprender__curso shadow pb-10">
                                <div class="para-aprender__curso-imagen">
                                    <img src="{{ $curso['imagen'] }}" alt="{{ $curso['titulo'] }}">
                                </div>
                                <div class="para-aprender__curso-info">
                                    <p class="para-aprender__curso-nombre">{{ $curso['titulo'] }}</p>
                                    <p class="para-aprender__curso-instructor">Docente:
                                        {{ $curso['docente']['name'] }}</p>
                                    <p class="para-aprender__curso-duracion"><span>Duración:</span>
                                        {{ $curso['duracion'] }}
                                        Horas</p>
                                    <p class="para-aprender__curso-certificacion"><span>Certificación:</span> Sí</p>
                                    @php
                                        $total_comentarios = count($curso['comentarios']);
                                        $total_calificacion = 0;
                                        foreach ($curso['comentarios'] as $comentario) {
                                            $total_calificacion += $comentario['calificacion'];
                                        }
                                        $promedio_calificacion =
                                            $total_comentarios > 0 ? $total_calificacion / $total_comentarios : 0;
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
                                </div>
                                <div class="usuarios__acciones">
                                    <a href="{{ route('cursos.show', ['id' => $curso['id']]) }}"
                                        class="usuarios__acciones-accion usuarios__acciones-ver"><i
                                            class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('cursos.edit', ['curso' => $curso['id']]) }}"
                                        class="usuarios__acciones-accion usuarios__acciones-ver"><i
                                            class="fa-solid fa-pen"></i></a>
                                    {{--                                 <button wire:click.prevent="eliminarCurso({{ $curso['id'] }})"
                                        class="usuarios__acciones-accion usuarios__acciones-ver">
                                        <i class="fa-solid fa-trash"></i>
                                    </button> --}}
                                    <button
                                        wire:click.prevent="$dispatch('confirmarEliminarCurso', { id: {{ $curso['id'] }} })"
                                        class="usuarios__acciones-accion usuarios__acciones-eliminar">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endempty
                </div>
            </div>
        </div>
    @endempty
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:init", function() {
            Livewire.on("confirmarEliminarCurso", id => {
                Swal.fire({
                    title: "¿Está seguro?",
                    text: "Esta acción no se puede revertir!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch("eliminarCurso", id);
                    }
                });
            });

            Livewire.on("cursoEliminado", () => {
                Swal.fire({
                    title: "Curso Eliminado",
                    text: "El curso ha sido eliminado correctamente.",
                    icon: "success"
                });
            });
        });
    </script>
@endpush
