@extends('layouts.app')

@section('content')
    {{--     @if (session('success'))
        <div class="alerta alerta--success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alerta alerta--error">
            {{ session('error') }}
        </div>
    @endif
 --}}

    <div class="contenedor">
        <livewire:archivo-leccion :leccion="$leccion" :usuario="$usuario">
    </div>
@endsection
