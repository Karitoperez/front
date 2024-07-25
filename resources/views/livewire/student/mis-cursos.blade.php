<div class="dashboard">
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

    <h1 class="titulo">Mis Cursos</h1>

    <div class="dashboard__categorias">
        <p class="subtitulo">Categorias</p>
        <ul class="dashboard__categorias-lista">
            <li><button wire:click.prevent="mostrarCursos">Todos</button></li>
            @foreach ($categorias as $categoria)
                @if (count($categorias) > 0)
                    <li>
                        <button wire:click="filtrarPorCategoria({{ $categoria['id'] }}, '{{ $categoria['nombre'] }}')">
                            {{ $categoria['nombre'] }}
                        </button>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="flex flex-col">
        <p class="mas-popular__titulo block">{{ $titulo }}</p>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 p-2 md:px-0">
            @empty($cursosFiltrados)
                @foreach ($misCursos as $curso)
                    @php
                        extract($curso);
                    @endphp
                    <a href="{{ route('cursos.show', ['id' => $curso['id']]) }}"
                        class="grid grid-cols-1 md:grid-cols-2 overflow-hidden gap-4 shadow-md">
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
            @endempty
        </div>
    </div>
</div>
