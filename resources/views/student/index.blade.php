<div class="dashboard">
    <h1 class="titulo">Área Personal</h1>

    <div class="dashboard__acceso">
        <h3 class="subtitulo">Acceso Rápido</h3>
        <nav class="dashboard__navegacion">
            <a class="dashboard__navegacion-link shadow" href="#"><i class="fa-solid fa-user"></i>Perfil</a>
            <a class="dashboard__navegacion-link shadow" href="#"><i class="fa-solid fa-comments"></i>Chat</a>
            <a class="dashboard__navegacion-link shadow" href="{{ route('cursos.index', ["username" => $usuario['usuario']]) }}"><i
                    class="fa-solid fa-book-bookmark"></i>Mi Aprendizaje</a>
        </nav>
    </div>

    <div class="dashboard__principal">
        <h3 class="aprendizaje__titulo">Mi Aprendizaje</h3>
        <div class="aprendizaje swiper mySwiper">
            <div class="aprendizaje__cursos swiper-wrapper">
                <div class="aprendizaje__curso shadow swiper-slide ">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2014/10/05/19/02/binary-code-475664_1280.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>
                    </div>
                </div>
                <div class="aprendizaje__curso shadow swiper-slide">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2018/05/18/15/30/web-design-3411373_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>

                    </div>
                </div>
                <div class="aprendizaje__curso shadow swiper-slide">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2018/05/04/20/01/website-3374825_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>

                    </div>
                </div>
                <div class="aprendizaje__curso shadow swiper-slide">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2019/01/31/20/52/web-3967926_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>

                    </div>
                </div>
                <div class="aprendizaje__curso shadow swiper-slide">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2019/01/31/20/52/web-3967926_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>

                    </div>
                </div>
                <div class="aprendizaje__curso shadow swiper-slide">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2019/01/31/20/52/web-3967926_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>

                    </div>
                </div>
                <div class="aprendizaje__curso shadow swiper-slide">
                    <div class="aprendizaje__curso-imagen">
                        <img src="https://cdn.pixabay.com/photo/2019/01/31/20/52/web-3967926_640.jpg"
                            alt="Nombre del Curso">
                    </div>
                    <div class="aprendizaje__curso-info">
                        <p class="aprendizaje__curso-nombre">Programación Orientada a Objetos (POO)</p>
                        <p class="aprendizaje__curso-instructor"><span>Instructor:</span> Johan Moreno</p>
                        <p class="aprendizaje__curso-duracion"><span>Duración:</span> 4 Horas</p>

                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        {{--         <p class="aprendizaje__titulo">Todos</p>
        <div class="aprendizaje swiper swiper-todos">
            <div class="aprendizaje__cursos swiper-wrapper">
                @empty($cursos)
                    <p>Aún no han creado cursos</p>
                @endempty
                @foreach ($cursos as $curso)
                    @php
                        extract($curso);
                    @endphp
                    <a href="{{ route('cursos.show', ['id' => $id]) }}"
                        class="aprendizaje__curso shadow swiper-slide ">
                        <div class="aprendizaje__curso-imagen">
                            <img src="https://cdn.pixabay.com/photo/2014/10/05/19/02/binary-code-475664_1280.jpg"
                                alt="Nombre del Curso">
                        </div>
                        <div class="aprendizaje__curso-info">
                            <p class="aprendizaje__curso-nombre">{{ $titulo }}</p>
                            <p class="aprendizaje__curso-instructor"><span>Instructor:</span> {{ $docente['name'] }}
                            </p>
                            <p class="aprendizaje__curso-duracion"><span>Duración:</span> {{ $duracion }} Horas</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div> --}}

        <div class="dashboard__categorias">
            <p class="subtitulo">Categorias</p>
            <ul class="dashboard__categorias-lista">
                @foreach ($categorias as $categoria)
                    <li><a href="#">{{ $categoria['nombre'] }}</a></li>
                @endforeach
            </ul>
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
