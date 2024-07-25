@extends('layouts.app')

@section('content')
    @if (AuthHelper::esEstudiante())
        <livewire:student.dashboard />
        @endif
        @if (AuthHelper::esDocente())
        <livewire:teacher.dashboard />
    @endif
    @if (AuthHelper::esAdministrador())
        <livewire:admin.dashboard />
    @endif
@endsection
