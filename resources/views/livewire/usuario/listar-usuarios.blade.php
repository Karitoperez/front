<div>
    <div>
        <a href="{{ route('usuarios.create') }}" class="curso__agregar-leccion bg-green-600">
            <span><i class="fa-solid fa-plus"></i> Agregar Usuario</span>
        </a>
    </div>
    <div class="usuarios__buscador">
        <label for="busqueda"><i class="fas fa-search usuarios__icon"></i></label>
        <input wire:model.live="busqueda" type="search" id="busqueda" name="busqueda" placeholder="Ej: Rosa">
    </div>

    @empty(!$usuarios)
        <div class="usuarios__container">
            <div class="usuarios__grid">
                @foreach ($usuarios as $usuario)
                    @if (!AuthHelper::esUsuarioActual($usuario['id']))
                        <a href="{{ route('usuarios.show', ['id' => $usuario['id']]) }}" wire:key="{{ $usuario['id'] }}"
                            class="usuarios__card shadow shadow-indigo-300">
                            <div class="usuarios__imagen">
                                <img src="{{ $usuario['imagen'] }}" alt="Nombre del Curso">
                            </div>
                            <div class="usuarios__info">
                                <p class="usuarios__name">{{ $usuario['name'] . ' ' . $usuario['apellido'] }}</p>
                                <p class="usuarios__usuario">{{ $usuario['usuario'] }}</p>
                                <p class="usuarios__email">{{ $usuario['email'] }}</p>
                                <p class="usuarios__rol">{{ $usuario['rol']['nombre'] }}</p>
                            </div>
                            {{--                             <div class="usuarios__acciones">
                                <a href="{{ route('usuarios.show', ['id' => $usuario['id']]) }}"
                                    class="usuarios__acciones-accion usuarios__acciones-ver"><i
                                        class="fa-solid fa-eye"></i></a>
                                <button class="usuarios__acciones-accion usuarios__acciones-editar"
                                    wire:click.prevent="abrirModalEditar({{ $usuario['id'] }})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button
                                    wire:click.prevent="$dispatch('confirmarEliminarUsuario', { id: {{ $usuario['id'] }} })"
                                    class="usuarios__acciones-accion usuarios__acciones-eliminar"
                                    {{ AuthHelper::esUsuarioActual($usuario['id']) ? 'disabled hidden' : '' }}>
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div> --}}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="usuarios__container">
            <h2>Aún no has agregado usuarios</h2>
        </div>
    @endempty


    <!-- Modal para editar usuario -->
    @if ($modalEditar)
        <div wire:transition.opacity.duration.400ms
            class="transition-all ease-in fixed z-50 bg-[rgba(0,0,0,0.5)] backdrop-blur top-0 left-0 w-full p-2 h-screen overflow-y-scroll">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-gray-950 p-4 rounded-lg w-full max-w-2xl">
                    <!-- Contenido del modal para agregar usuario -->
                    <form wire:submit.prevent="actualizarUsuario" enctype="multipart/form-data">
                        <legend class="text-2xl font-bold text-white text-center mb-2">Editar Usuario</legend>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="mb-2">
                                <label for="id_rol">Rol</label>
                                <select wire:model="id_rol" id="id_rol" name="id_rol"
                                    class="p-1 ring-0 border-2 border-gray-200 transition-border focus:border-gray-100 focus:ring-0 block mt-1 w-full capitalize">
                                    <option value="1">Administrador</option>
                                    <option value="2">Estudiante</option>
                                    <option value="3">Docente</option>
                                </select>
                                @error('id_rol')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-700 text-white rounded-md hover:bg-blue-800 ">
                                Guardar
                            </button>
                            <button wire:click.prevent="cerrarModalEditar"
                                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener("livewire:init", function() {
            Livewire.on("confirmarEliminarUsuario", usuarioId => {
                Swal.fire({
                    title: "¿Está seguro?",
                    text: "Esta acción no se puede revertir!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch("eliminarUsuario", usuarioId);
                    }
                });
            });

            Livewire.on("usuarioEliminado", () => {
                Swal.fire({
                    title: "Usuario Eliminado",
                    text: "El usuario ha sido eliminado correctamente.",
                    icon: "success"
                });
            });

            Livewire.on("usuarioCreado", () => {
                Swal.fire({
                    title: "Usuario Creado",
                    text: "El usuario se ha creado correctamente.",
                    icon: "success"
                });
            });

            Livewire.on("usuarioActualizado", () => {
                Swal.fire({
                    title: "Usuario Actualizado",
                    text: "El usuario se ha actualizado correctamente.",
                    icon: "success"
                });
            });
        });
    </script>
@endpush
