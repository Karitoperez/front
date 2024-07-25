@extends(AuthHelper::estaAutenticado() ? 'layouts.app' : 'layouts.guest')

@section('content')
    <livewire:curso.show-course :curso="$curso" :usuario="$usuario" />
@endsection

