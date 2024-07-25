@extends('layouts.guest')

@section('content')
    <livewire:student.student-courses :cursos="$cursos" :categorias="$categorias" />
@endsection
