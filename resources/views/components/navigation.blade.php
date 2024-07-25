<div class="nav-guest contenedor">
    <a href="{{route('welcome')}}" class="nav-guest__logo">
        <span class="nav-guest__logo-img">
            <img src="https://flowbite.com/docs/images/logo.svg" alt="Flowbite Logo" />
        </span>
        <span class="nav-guest__logo-text">Talent<span class="nav-guest__logo-dot">.</span>Co</span>
    </a>

    <nav class="nav-guest__menu">
        <a href="{{ route('welcome') }}" class="nav-guest__menu-link" aria-current="page">Inicio</a>
        <a href="{{route('cursos')}}" class="nav-guest__menu-link">Cursos</a>
{{--         <a href="{{route('docentes')}}" class="nav-guest__menu-link">Docentes</a>
        <a href="{{route('cursos')}}" class="nav-guest__menu-link">Contacto</a> --}}
    </nav>

    <div class="nav-guest__actions">
        <a href="{{ route('login') }}" class="nav-guest__action-link nav-guest__action-logo" aria-current="page">Login</a>
        <a href="{{ route('registrarse.create') }}" class="nav-guest__action-link" aria-current="page">Registrarme</a>
    </div>
</div>
