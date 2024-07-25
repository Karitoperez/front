@extends('layouts.app')

@section('content')
    @if (AuthHelper::esEstudiante())
        <livewire:student.mis-cursos />
    @endif
{{--     @if (AuthHelper::esDocente())
        <livewire:teacher.teacher-courses :cursos="$cursos" :categorias="$categorias" :usuario="$usuario" />
    @endif --}}
    @if (AuthHelper::esAdministrador())
        <livewire:admin.mis-cursos />
    @endif
@endsection
