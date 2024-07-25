<div class="my-4">
    <h2 class="titulo">Dashboard</h2>
    <div class="">
        <div class="grid md:grid-cols-3 gap-8 m-8">
            <a href="{{ route('chat.index') }}"
                class="curso__agregar-leccion bg-green-600 shadow-md flex flex-col p-2 items-center justify-center h-24 rounded">
                <span><i class="text-4xl fa-solid fa-comments"></i> Chat</span>
            </a>
            <a href="{{ route('cursos.index', ['username' => $usuario['usuario']]) }}"
                class="curso__agregar-leccion bg-rose-600 shadow-md flex flex-col p-2 items-center justify-center h-24 rounded">
                <span><i class="fa-solid fa-book-bookmark"></i></i> Ver Cursos</span>
            </a>
            <a href="{{ route('misCursos') }}"
                class="curso__agregar-leccion bg-indigo-600 shadow-md flex flex-col p-2 items-center justify-center h-24 rounded">
                <span><i class="text-4xl fa-solid fa-eye"></i> Mis Cursos</span>
            </a>
        </div>

        <div class="">
            <p class="font-bold text-center flex items-center justify-center gap-2 text-4xl">Cursos <i
                    class="fa-solid fa-plus text-yellow-400 text-2xl"></i> Populares </p>
            <div class="dashboard">
                <div class="slider-cursos">
                    <div class="swiper swiper-popular mas-popular">
                        <div class="swiper-wrapper">
                            @foreach ($cursosPopulares as $curso)
                                @php
                                    extract($curso);
                                @endphp
                                <a href="{{ route('cursos.show', ['id' => $id]) }}"
                                    class="swiper-slide mas-popular__curso shadow-md">
                                    <div class="mas-popular__curso-imagen">
                                        <img src="{{ $imagen }}" alt="{{ $titulo }}">
                                    </div>
                                    <div class="mas-popular__curso-info">
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
                        </div>
                    </div>
                    <!-- Flechas de navegación -->
                    <div class="swiper-button-next custom-next"></div>
                    <div class="swiper-button-prev custom-prev"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
    <script>
        let categoriasEstudiantes = document.querySelector('#categoriasEstudiantes');
        if (categoriasEstudiantes) {
            categoriasEstudiantesData = @json($cursosPopulares);

            let nombresCategorias = categoriasEstudiantesData.map(function(curso) {
                return curso.categoria.nombre;
            });

            let cantidadEstudiantes = categoriasEstudiantesData.map(function(curso) {
                return curso.estudiantes_count; // Ajusta esto según la estructura de tus datos
            });

            let myChart = new Chart(categoriasEstudiantes.getContext("2d"), {
                type: 'polarArea',
                data: {
                    labels: nombresCategorias,
                    datasets: [{
                        label: 'Categorias Populares',
                        data: cantidadEstudiantes,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: ['rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Nombre Curso'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Estudiantes'
                            }
                        }
                    }
                }
            });
        };
        let cursosEstudiantes = document.querySelector('#cursosEstudiantes');
        if (cursosEstudiantes) {
            cursosEstudiantesData = @json($cursosPopulares);

            let nombresCursos = cursosEstudiantesData.map(function(curso) {
                return curso.titulo;
            });

            let cantidadEstudiantes = cursosEstudiantesData.map(function(curso) {
                return curso.estudiantes_count; // Ajusta esto según la estructura de tus datos
            });

            let myChart = new Chart(cursosEstudiantes.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: nombresCursos,
                    datasets: [{
                        label: 'Cursos Populares',
                        data: cantidadEstudiantes,
                        backgroundColor: ['rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: ['rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Categoria Curso'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cantidad de Estudiantes'
                            }
                        }
                    }
                }
            });
        };
    </script>
@endpush
