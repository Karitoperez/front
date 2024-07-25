@extends('layouts.guest')

@section('content')
    <div class="hero">
        <canvas id="background"></canvas>
        <div class="hero__content shadow">
            <div class="hero__subtitle">
                <p class="hero__subtitle-texto shadow shadow-indigo-300">
                    Descubre tu próximo curso <a href="{{ route('cursos') }}" class="hero__link"><span
                            class="hero__arrow" aria-hidden="true"></span>Ver más <span aria-hidden="true">&rarr;</span></a>
                </p>
            </div>
            <div class="hero__text">
                <h1 class="hero__title">¿Estás listo para transformar tu futuro?</h1>
                <p class="hero__description">Comienza tu viaje de aprendizaje hoy mismo. Regístrate ahora para acceder a
                    nuestra amplia gama de cursos y lleva tus habilidades al siguiente nivel.</p>
                <div class="hero__buttons">
                    <a href="{{ route('registrarse.create') }}" class="hero__button">Registrarme</a>
                    <a href="{{ route('cursos') }}" class="hero__button">Ver cursos <span
                            aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
    </div>
@endsection
