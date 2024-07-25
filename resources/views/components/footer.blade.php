<footer class="footer">
    <div class="footer__flex contenedor">

        <div class="footer__container ">
            <div class="footer__logo">
                @if (AuthHelper::estaAutenticado())
                    <a href="{{ route('dashboard.index') }}" class="footer__link">
                        <img src="https://flowbite.com/docs/images/logo.svg" alt="Flowbite Logo" class="footer__image">
                        <span class="footer__text">Talent<span class="footer__dot">.</span>Co</span>
                    </a>
                @else
                    <a href="{{ route('welcome') }}" class="footer__link">
                        <img src="https://flowbite.com/docs/images/logo.svg" alt="Flowbite Logo" class="footer__image">
                        <span class="footer__text">Talent<span class="footer__dot">.</span>Co</span>
                    </a>
                @endif
            </div>
            <div class="footer__sections">
                <div class="footer__section">
                    <h2 class="footer__heading">Menú</h2>
                    <ul class="footer__list">
                        @if (AuthHelper::estaAutenticado())
                            <li class="footer__item">
                                <a href="{{ route('dashboard.index') }}" class="footer__link">Dashboard</a>
                            </li>
                            <li class="footer__item">
                                <a href="{{ route('cursos.index', ['username' => $usuario['usuario']]) }}"
                                    class="footer__link">Cursos</a>
                            </li>
                            <li class="footer__item">
                                <a href="{{ route('dashboard.index') }}" class="footer__link">Mi Aprendizaje</a>
                            </li>
                        @else
                            <li class="footer__item">
                                <a href="{{ route('welcome') }}" class="footer__link">Inicio</a>
                            </li>
                            <li class="footer__item">
                                <a href="{{ route('cursos') }}" class="footer__link">Cursos</a>
                            </li>
                            <li class="footer__item">
                                <a href="{{ route('docentes') }}" class="footer__link">Docentes</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="footer__section">
                    <h2 class="footer__heading">Follow us</h2>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a href="https://github.com/themesberg/flowbite" class="footer__link">Github</a>
                        </li>
                        <li class="footer__item">
                            <a href="https://discord.gg/4eeurUVvTy" class="footer__link">Discord</a>
                        </li>
                    </ul>
                </div>
                <div class="footer__section">
                    <h2 class="footer__heading">Legal</h2>
                    <ul class="footer__list">
                        <li class="footer__item">
                            <a href="#" class="footer__link">Política de Privacidad</a>
                        </li>
                        <li class="footer__item">
                            <a href="#" class="footer__link">Términos y Condiciones</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <span class="footer__copyright">© {{ Date('Y') }}
                <a href="{{ route('dashboard.index') }}" class="">Talent<span
                        class="footer__copy">.</span>Co™</a>. Todos los Derechos Reservados.
            </span>
            <div class="footer__social-links">
                <h2 class="footer__social-titulo">Síguenos</h2>
                <a href="#" class="footer__social-link">
                    <i class="fa-brands fa-square-facebook"></i>
                </a>
                <a href="#" class="footer__social-link">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
