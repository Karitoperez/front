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

        <form class="formulario shadow-md" wire:submit.prevent='registro' enctype="multipart/form-data">
            @csrf
            <p class="formulario__titulo">Registrarse</p>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="nombre">Nombres</label>
                    <input type="text" wire:model="nombre" id="nombre" placeholder="Nombres"
                        value="{{ old('nombre') }}" />
                    @error('nombre')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="formulario__contenido">
                    <label for="apellido">Apellidos</label>
                    <input type="text" wire:model="apellido" id="apellido" placeholder="Apellidos"
                        value="{{ old('apellido') }}" />
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
                        <option {{ $id_tipo_documento === '4' ? 'selected' : '' }} value="4">CC</option>
                        <option {{ $id_tipo_documento === '3' ? 'selected' : '' }} value="3">TI</option>
                        <option {{ $id_tipo_documento === '5' ? 'selected' : '' }} value="5">CE</option>
                        <option {{ $id_tipo_documento === '1' ? 'selected' : '' }} value="1">DNI</option>
                        <option {{ $id_tipo_documento === '2' ? 'selected' : '' }} value="2">Pasaporte</option>
                    </select>
                    @error('id_tipo_documento')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="numero_documento">No. de documento</label>
                    <input type="text" wire:model="numero_documento" id="numero_documento"
                        placeholder="Número de documento" value="{{ old('numero_documento') }}" />
                    @error('numero_documento')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                    <input type="date" wire:model="fecha_nacimiento" id="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento') }}" />
                    @error('fecha_nacimiento')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="direccion">Dirección</label>
                    <input type="text" wire:model="direccion" id="direccion" placeholder="Dirección de residencia"
                        value="{{ old('direccion') }}" />
                    @error('direccion')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <div class="formulario__contenido">
                        <label for="id_rol">Tipo de rol</label>
                        <select id="id_rol" wire:model="id_rol">
                            <option {{ !$id_rol ? 'selected' : '' }}>--Seleccione--</option>
                            <option {{ $id_rol == '3' ? 'selected' : '' }} value="3">Docente</option>
                            <option {{ $id_rol == '2' ? 'selected' : '' }} value="2">Estudiante</option>
                        </select>
                        @error('id_rol')
                            <p class="formulario__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="formulario__contenido">
                    <label for="imagen">Imagen</label>
                    <input type="file" wire:model="imagen" id="imagen">
                    @error('imagen')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="email">Correo</label>
                    <input type="email" wire:model="email" id="email" placeholder="Correo Electrónico"
                        value="{{ old('email') }}" />
                    @error('email')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="usuario">Usuario</label>
                    <input type="text" wire:model="usuario" id="usuario" placeholder="Nombre de usuario"
                        value="{{ old('usuario') }}" />
                    @error('usuario')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="formulario__campo">
                <div class="formulario__contenido">
                    <label for="password">Contraseña</label>
                    <input type="password" wire:model="password" id="password" placeholder="Contraseña"
                        value="{{ old('password') }}" />
                    @error('password')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="formulario__contenido">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" wire:model="password_confirmation" id="password_confirmation"
                        placeholder="Repetir contraseña" value="{{ old('password_confirmation') }}" />
                    @error('password_confirmation')
                        <p class="formulario__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="formulario__boton">Registrarme</button>
        </form>
    </div>
