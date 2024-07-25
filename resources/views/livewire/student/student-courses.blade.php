<div class="dashboard">
    <h1 class="titulo">Cursos</h1>
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
    <div class="dashboard__principal">
        <p class="mas-popular__titulo capitalize">{{ $titulo }}</p>
        <div class="mas-popular">
            <div class="mas-popular__cursos flex flex-col gap-4">
                @empty($cursosFiltrados)
                    @foreach ($cursos as $curso)
                        @php
                            extract($curso);
                        @endphp
                        <a href="{{ route('cursos.show', ['id' => $id]) }}" class="mas-popular__curso shadow-md">
                            <div class="mas-popular__curso-imagen">
                                <img src="{{ $imagen }}" alt="{{ $titulo }}">
                            </div>
                            <div class="mas-popular__curso-info">
                                <p class="mas-popular__curso-nombre">{{ $titulo }}</p>
                                <p class="mas-popular__curso-instructor"><span>Instructor:</span>
                                    {{ $docente['name'] . ' ' . $docente['apellido'] }}</p>
                                <p class="mas-popular__curso-duracion"><span>Duración:</span> {{ $duracion }} Horas
                                </p>
                                <p class="mas-popular__curso-certificacion"><span>Certificación:</span> Sí</p>

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
                        <a href="{{ route('cursos.show', ['id' => $id]) }}" class="mas-popular__curso shadow-md ">
                            <div class="mas-popular__curso-imagen">
                                <img src="{{ $imagen }}" alt="{{ $titulo }}">
                            </div>
                            <div class="mas-popular__curso-info">
                                <p class="mas-popular__curso-nombre">{{ $titulo }}</p>
                                <p class="mas-popular__curso-instructor"><span>Instructor:</span>
                                    {{ $docente['name'] . ' ' . $docente['apellido'] }}</p>
                                <p class="mas-popular__curso-duracion"><span>Duración:</span> {{ $duracion }} Horas
                                </p>
                                <p class="mas-popular__curso-certificacion"><span>Certificación:</span> Sí</p>

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
</div>
