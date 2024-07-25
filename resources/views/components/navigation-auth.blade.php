<aside id="menu" class="menu__app">
    <div class="menu__content ">
        <span class="menu__logo">
            <img src="https://flowbite.com/docs/images/logo.svg" alt="Flowbite Logo" />
            <span class="menu__logo-texto">Talent<span>.</span>Co</span>
        </span>

        <ul class="menu__lista">
            <li class="menu__link active">
                <a href="{{ route('dashboard.index') }}"
                    class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <span><i class="fa-solid fa-chart-pie"></i> Dashboard</span>
                </a>
            </li>
            <li class="menu__link">
                <a href="{{ route('chat.index') }}">
                    <span><i class="fa-solid fa-comments"></i> Chat</span>
                </a>
            </li>
{{--             <li class="menu__link">
                <a href="#">
                    <span><i class="fa-solid fa-calendar-days"></i> Calendario</span>
                </a>
            </li> --}}

            @if (AuthHelper::esEstudiante())
                <button class="menu__link-btn dropdown">
                    <span><i class="fa-solid fa-book-bookmark"></i> Cursos</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="submenu">
                    <li class="menu__link">
                        <a href="{{ route('cursos.index', ['username' => $usuario['usuario']]) }}"
                            class="{{ request()->routeIs('cursos.index') ? 'active' : '' }}">
                            <span><i class="fa-solid fa-eye"></i> Ver Cursos</span>
                        </a>
                    </li>
                    <li class="menu__link">
                        <a href="{{ route('misCursos') }}">
                            <span><i class="fa-solid fa-plus"></i> Mi Aprendizaje</span>
                        </a>
                    </li>
                </ul>
            @endif

            @if (AuthHelper::esAdministrador())
                <button class="menu__link-btn dropdown">
                    <span><i class="fa-solid fa-user-group"></i> Usuarios</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="submenu">
                    <li class="menu__link">
                        <a href="{{ route('usuarios.index') }}">
                            <span><i class="fa-solid fa-eye"></i> Ver Usuarios</span>
                        </a>
                    </li>
                    <li class="menu__link">
                        <a href="{{ route('usuarios.create') }}">
                            <span><i class="fa-solid fa-plus"></i> Crear Usuario</span>
                        </a>
                    </li>
                </ul>

                <button class="menu__link-btn dropdown">
                    <span><i class="fa-solid fa-book-bookmark"></i> Cursos</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="submenu">
                    <li class="menu__link">
                        <a href="{{ route('cursos.index', ['username' => $usuario['usuario']]) }}">
                            <span><i class="fa-solid fa-eye"></i> Ver Cursos</span>
                        </a>
                    </li>
                    <li class="menu__link">
                        <a href="{{ route('misCursos') }}">
                            <span><i class="fa-solid fa-eye"></i> Mis Cursos</span>
                        </a>
                    </li>
                    <li class="menu__link">
                        <a href="{{ route('cursos.create') }}">
                            <span><i class="fa-solid fa-plus"></i> Crear Curso</span>
                        </a>
                    </li>
                </ul>

                {{--                 <ul class="submenu">
                    <li class="menu__link">
                        <a href="{{ route('usuarios.index') }}">
                            <span><i class="fa-solid fa-eye"></i> Ver Usuarios</span>
                        </a>
                    </li>
                    <li class="menu__link">
                        <a href="{{ route('usuarios.create') }}">
                            <span><i class="fa-solid fa-plus"></i> Crear Usuario</span>
                        </a>
                    </li>
                </ul> --}}
            @endif

            @if (AuthHelper::esDocente())
                <button class="menu__link-btn dropdown">
                    <span><i class="fa-solid fa-book-bookmark"></i> Cursos</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="submenu">
                    <li class="menu__link">
                        <a href="{{ route('cursos.index', ['username' => $usuario['usuario']]) }}">
                            <span><i class="fa-solid fa-eye"></i> Mis Cursos</span>
                        </a>
                    </li>
                    <li class="menu__link">
                        <a href="{{ route('cursos.create') }}">
                            <span><i class="fa-solid fa-plus"></i> Crear Curso</span>
                        </a>
                    </li>
                </ul>
            @endif
        </ul>
    </div>

    <div class="menu__footer">
        @if (AuthHelper::estaAutenticado())
            <a href="{{ route('usuarios.show', ['id' => $usuario['id']]) }}" class="menu__profile">
                <img alt="" src="{{ $usuario['imagen'] }}" class="menu__profile-image " />

                <div class="menu__profile-info">
                    <p>{{ $usuario['usuario'] }}</p>
                    <span class="menu__profile-email">{{ $usuario['email'] }}</span>
                    @if (AuthHelper::esAdministrador())
                        <span class="menu__profile-rol">Administrador</span>
                    @endif
                    @if (AuthHelper::esDocente())
                        <span class="menu__profile-rol">Docente</span>
                    @endif
                    @if (AuthHelper::esEstudiante())
                        <span class="menu__profile-rol">Estudiante</span>
                    @endif
                </div>
            </a>
            <a class="menu__logout" href="{{ route('logout') }}">Cerrar Sesión</a>
        @endif
    </div>
</aside>

<span id="menuToggle" class="shadow-xl">
    <i class="fa-solid fa-chevron-right"></i>
</span>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menu = document.querySelector('.header__app');
        const menuToggle = document.querySelector('#menuToggle');

        menuToggle.addEventListener('click', function() {
            menu.classList.toggle('mostrar');
            menuToggle.classList.toggle('girar-menu');
        });
    });
</script>
