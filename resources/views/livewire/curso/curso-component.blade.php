{{-- <div>
    @section('content')
        @if (AuthHelper::esEstudiante())
            <livewire:student.student-courses :cursos="$cursos" :categorias="$categorias" :user="$user" />
        @endif
        @if (AuthHelper::esDocente())
            <livewire:teacher.teacher-courses :cursos="$cursos" :categorias="$categorias" :user="$user" />
        @endif
        @if (AuthHelper::esAdministrador())
            <livewire:admin.admin-courses :cursos="$cursos" :categorias="$categorias" :user="$user" />
        @endif
    @endsection
</div> --}}
