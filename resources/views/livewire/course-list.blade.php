<div>
    <div class="dashboard__categorias">
        <p class="subtitulo">Categorias</p>
        <ul class="dashboard__categorias-lista">
            @foreach ($categorias as $categoria)
                @if (count($categoria['cursos']) > 0)
                    <li><a href="#">{{ $categoria['nombre'] }}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="dashboard__principal">
        <p class="mas-popular__titulo">Más Popular</p>
        <div class="mas-popular swiper swiper-popular">
            <div class="mas-popular__cursos  swiper-wrapper">
                @foreach ($cursos as $curso)
                    @php
                        extract($curso);
                    @endphp
                    <a href="{{ route('cursos.show', ['id' => $id]) }}" class="mas-popular__curso shadow-md swiper-slide">
                        <div class="mas-popular__curso-imagen">
                            <img src="https://cdn.pixabay.com/photo/2019/01/31/20/52/web-3967926_640.jpg"
                                alt="Nombre del Curso">
                        </div>
                        <div class="mas-popular__curso-info">
                            <p class="mas-popular__curso-nombre">{{ $titulo }}</p>
                            <p class="mas-popular__curso-instructor"><span>Instructor:</span>
                                {{ $docente['name'] . ' ' . $docente['apellido'] }}</p>
                            <p class="mas-popular__curso-duracion"><span>Duración:</span> {{ $duracion }} Horas
                            </p>
                            <p class="mas-popular__curso-certificacion"><span>Certificación:</span> Sí</p>
                            <p class="mas-popular__curso-calificacion">
                                <i class="fa-regular fa-star text-yellow-400"></i>
                                <i class="fa-regular fa-star text-yellow-400"></i>
                                <i class="fa-regular fa-star text-yellow-400"></i>
                                <i class="fa-regular fa-star text-yellow-400"></i>
                                4/5
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <p class="aprendizaje__titulo">Todos</p>
        <div class="aprendizaje swiper mySwiper">
            <div class="aprendizaje__cursos swiper-wrapper">
                @empty($cursos)
                    <p>Aún no han creado cursos</p>
                @endempty
                @foreach ($cursos as $curso)
                    @php
                        extract($curso);
                    @endphp
                    <a href="{{ route('cursos.show', ['id' => $id]) }}" class="aprendizaje__curso shadow swiper-slide ">
                        <div class="aprendizaje__curso-imagen">
                            <img src="https://cdn.pixabay.com/photo/2014/10/05/19/02/binary-code-475664_1280.jpg"
                                alt="Nombre del Curso">
                        </div>
                        <div class="aprendizaje__curso-info">
                            <p class="aprendizaje__curso-nombre">{{ $titulo }}</p>
                            <p class="aprendizaje__curso-instructor"><span>Instructor:</span> {{ $docente['name'] }}
                            </p>
                            <p class="aprendizaje__curso-duracion"><span>Duración:</span> {{ $duracion }} Horas
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div class="para-aprender">
            <p class="para-aprender__titulo">Para Aprender</p>
            <div class="para-aprender__cursos">
                <div class="para-aprender__curso shadow">
                    <div class="para-aprender__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2014/10/05/19/02/binary-code-475664_1280.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="para-aprender__curso-info">
                        <p class="para-aprender__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="para-aprender__curso-instructor">Johan Moreno</p>
                        <p class="para-aprender__curso-duracion"><span>Duración:</span> 4 Horas</p>
                        <p class="para-aprender__curso-certificacion"><span>Certificación:</span> Sí</p>
                        <p class="para-aprender__curso-calificacion"><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i> 4/5</p>

                    </div>
                </div>
                <div class="para-aprender__curso shadow">
                    <div class="para-aprender__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2017/03/23/09/34/artificial-intelligence-2167835_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="para-aprender__curso-info">
                        <p class="para-aprender__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="para-aprender__curso-instructor">Johan Moreno</p>
                        <p class="para-aprender__curso-duracion"><span>Duración:</span> 4 Horas</p>
                        <p class="para-aprender__curso-certificacion"><span>Certificación:</span> Sí</p>
                        <p class="para-aprender__curso-calificacion"><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i> 4/5</p>

                    </div>
                </div>
                <div class="para-aprender__curso shadow">
                    <div class="para-aprender__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2016/10/16/16/33/dual-screen-1745705_640.png"
                            alt="Nombre del Curso">
                    </div>
                    <div class="para-aprender__curso-info">
                        <p class="para-aprender__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="para-aprender__curso-instructor">Johan Moreno</p>
                        <p class="para-aprender__curso-duracion"><span>Duración:</span> 4 Horas</p>
                        <p class="para-aprender__curso-certificacion"><span>Certificación:</span> Sí</p>
                        <p class="para-aprender__curso-calificacion"><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i> 4/5</p>

                    </div>
                </div>
                <div class="para-aprender__curso shadow">
                    <div class="para-aprender__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2014/12/30/13/44/programming-583923_1280.jpg    "
                            alt="Nombre del Curso">
                    </div>
                    <div class="para-aprender__curso-info">
                        <p class="para-aprender__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="para-aprender__curso-instructor">Johan Moreno</p>
                        <p class="para-aprender__curso-duracion"><span>Duración:</span> 4 Horas</p>
                        <p class="para-aprender__curso-certificacion"><span>Certificación:</span> Sí</p>
                        <p class="para-aprender__curso-calificacion"><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i> 4/5</p>

                    </div>
                </div>
                <div class="para-aprender__curso shadow">
                    <div class="para-aprender__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2014/10/05/19/02/binary-code-475664_1280.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="para-aprender__curso-info">
                        <p class="para-aprender__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="para-aprender__curso-instructor">Johan Moreno</p>
                        <p class="para-aprender__curso-duracion"><span>Duración:</span> 4 Horas</p>
                        <p class="para-aprender__curso-certificacion"><span>Certificación:</span> Sí</p>
                        <p class="para-aprender__curso-calificacion"><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i><i
                                class="fa-regular fa-star text-yellow-400"></i> 4/5</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
