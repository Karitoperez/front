@extends('layouts.app')

@section('content')
    @if (AuthHelper::esEstudiante())
        <livewire:student.student-courses :cursos="$cursos" :categorias="$categorias"/>
    @endif
    @if (AuthHelper::esDocente())
        <livewire:teacher.teacher-courses :cursos="$cursos" :categorias="$categorias" :usuario="$usuario" />
    @endif
    @if (AuthHelper::esAdministrador())
        <livewire:admin.admin-cursos :cursos="$cursos" :categorias="$categorias" :usuario="$usuario" />
    @endif
@endsection
