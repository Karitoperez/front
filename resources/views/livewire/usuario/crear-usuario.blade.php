<div>
    @if (session('success'))
        <div class="alerta alerta-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alerta alerta-error">
            {{ session('error') }}
        </div>
    @endif

    <form class="formulario shadow-md" wire:submit.prevent="crearUsuario" enctype="multipart/form-data">
        <p class="formulario__titulo">Nuevo Usuario</p>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="nombre">Nombre</label>
                <input type="text" wire:model="nombre" id="nombre" placeholder=" " />
                @error('nombre')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="formulario__contenido">
                <label for="apellido">Apellido</label>
                <input type="text" wire:model="apellido" id="apellido" placeholder=" " />
                @error('apellido')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="id_tipo_documento">Tipo de documento</label>
                <select id="id_tipo_documento" wire:model="id_tipo_documento">
                    <option {{ !$id_tipo_documento ? 'selected' : '' }}>--Seleccione--</option>
                    <option {{ $id_tipo_documento == '4' ? 'selected' : '' }} value="4">CC</option>
                    <option {{ $id_tipo_documento == '3' ? 'selected' : '' }} value="3">TI</option>
                    <option {{ $id_tipo_documento == '5' ? 'selected' : '' }} value="5">CE</option>
                    <option {{ $id_tipo_documento == '1' ? 'selected' : '' }} value="1">DNI</option>
                    <option {{ $id_tipo_documento == '2' ? 'selected' : '' }} value="2">Pasaporte</option>
                </select>
                @error('id_tipo_documento')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="numero_documento">No. de documento</label>
                <input type="text" wire:model="numero_documento" id="numero_documento" placeholder=" " />
                @error('numero_documento')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" wire:model="fecha_nacimiento" id="fecha_nacimiento" placeholder="" />
                @error('fecha_nacimiento')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="direccion">Dirección</label>
                <input type="text" wire:model="direccion" id="direccion" placeholder=" " />
                @error('direccion')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                @if (AuthHelper::esAdministrador())
                    <div class="formulario__contenido">
                        <label for="id_rol">Tipo de rol</label>
                        <select id="id_rol" wire:model="id_rol">
                            <option {{ !$id_rol ? 'selected' : '' }}>--Seleccione--</option>
                            <option {{ $id_rol == '1' ? 'selected' : '' }} value="1">Administrador</option>
                            <option {{ $id_rol == '3' ? 'selected' : '' }} value="3">Docente</option>
                            <option {{ $id_rol == '2' ? 'selected' : '' }} value="2">Estudiante</option>
                        </select>
                        @error('id_rol')
                            <p class="formulario__error">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="imagen">Imagen</label>
                    <input type="file" wire:model="imagen" id="imagen" />
                    @error('imagen')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="email">Correo</label>
                <input type="email" wire:model="email" id="email" placeholder="" />
                @error('email')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="usuario">Usuario</label>
                <input type="text" wire:model="usuario" id="usuario" placeholder="" />
                @error('usuario')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="formulario__campo">
            <div class="formulario__contenido">
                <label for="password">Contraseña</label>
                <input type="password" wire:model="password" id="password" placeholder="" />
                @error('password')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="formulario__contenido">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" wire:model="password_confirmation" id="password_confirmation" placeholder="" />
                @error('password_confirmation')
                    <p class="formulario__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="formulario__boton">Crear Usuario</button>
    </form>
</div>
