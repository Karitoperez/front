<div class="dashboard">

    <h1 class="titulo">Cursos</h1>

    <div>
        <a href="{{ route('cursos.create') }}" class="curso__agregar-leccion bg-green-600">
            <span><i class="fa-solid fa-plus"></i> Agregar Curso</span>
        </a>
    </div>

    <div class="dashboard__categorias">
        <p class="subtitulo">Categorias</p>
        <ul class="dashboard__categorias-lista">
            <li><button wire:click="mostrarCursos">Todos</button></li>
            @foreach ($categorias as $categoria)
                @if (count($categoria['cursos']) > 0)
                    <li>
                        <button wire:click="filtrarPorCategoria({{ $categoria['id'] }}, '{{ $categoria['nombre'] }}')">
                            {{ $categoria['nombre'] }}
                        </button>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="">
        <p class="mas-popular__titulo block">{{ $titulo }}</p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 h-full">
            @empty($cursosFiltrados)
                @foreach ($cursos as $curso)
                    @php
                        extract($curso);
                    @endphp
                    <a href="{{ route('cursos.show', ['id' => $id]) }}"
                        class="grid grid-cols-1 md:grid-cols-2 overflow-hidden gap-2 shadow-md">
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
                        </div>
                    </a>
                @endforeach
            @else
                @foreach ($cursosFiltrados as $curso)
                    @php
                        extract($curso);
                    @endphp
                    <a href="{{ route('cursos.show', ['id' => $id]) }}"
                        class="grid grid-cols-1 md:grid-cols-2 overflow-hidden gap-2 shadow-md">
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
                        </div>
                    </a>
                @endforeach
            @endempty
        </div>
    </div>
</div>
