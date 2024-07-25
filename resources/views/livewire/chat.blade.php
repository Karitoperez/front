<div class="md:h-screen my-1 flex flex-col w-3/4 mx-auto shadow-md">
    <h1 class="text-center text-4xl text-indigo-600 my-8 font-bold">Chat</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 h-full">
        <div class="border-r p-2">
            <h4>Chats</h4>
            {{--             <ul>
                @foreach ($usuarios as $usuario)
                    @if ($usuario['id'] != $usuarioAuth['id'])
                        <li wire:click.prevent="abrirModalConversacion({{ $usuario['id'] }})"
                            class="cursor-pointer hover:bg-gray-200 py-2 px-4 capitalize block">
                            {{ $usuario['name'] }}
                        </li>
                    @endif
                @endforeach
            </ul>
            <h4>Conversaciones</h4> --}}

            @empty($usuarioAuth['conversaciones'])
                <p>Aún no has iniciado una conversación.</p>
            @else
                <div class="w-full">
                    <label for="busqueda"></label>
                    <input wire:model.live="busqueda" class="w-full focus:border-none text-2xl" type="search" id="busqueda"
                        name="busqueda" placeholder="Busca un chat">
                </div>
                <ul>
                    @foreach ($usuarioAuth['conversaciones'] as $conversacion)
                        <li wire:click.prevent="abrirModalMensajes({{ $conversacion['id'] }})"
                            class="conversacion cursor-pointer hover:bg-gray-200 py-2 px-4 capitalize">
                            @foreach ($conversacion['usuarios'] as $usuario)
                                @if ($usuario['id'] != $usuarioAuth['id'])
                                    {{ $usuario['name'] }}
                                @endif
                            @endforeach
                        </li>
                    @endforeach
                </ul>
            @endempty
        </div>

        <div class="w-full pb-4 flex flex-col relative md:my-4">
            @if ($modalConversacion)
                @if (!empty($conversacionActual['mensajes']))
                    @foreach ($conversacionActual['participantes'] as $usuario)
                        @if ($usuario['id_usuario'] != $usuarioAuth['id'])
                            <div class="flex items-center gap-2 p-4 border-b border-black">
                                <img src="{{ $usuario['user']['imagen'] }}" alt="Imagen usuario"
                                    class="w-16 h-16 rounded-full">
                                <h4 class="capitalize font-bold text-4xl text-green-600 py-4">
                                    {{ $usuario['user']['name'] }}</h4>
                            </div>
                        @endif
                    @endforeach
                    <ul
                        class="message-list flex flex-col gap-2 overflow-hidden overflow-y-scroll pb-16 h-[40rem] pt-2 pl-2">
                        @foreach (array_filter($conversacionActual['mensajes']) as $mensaje)
                            <li
                                class="flex items-start {{ $mensaje['id_usuario'] === $usuarioAuth['id'] ? 'justify-end' : '' }} gap-2.5">
                                <div class="flex flex-col w-full max-w-[320px]">
                                    <div
                                        class="flex flex-col leading-1.5 p-4 border-gray-200 {{ $mensaje['id_usuario'] == $usuarioAuth['id'] ? 'bg-indigo-200' : 'bg-gray-200' }} rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                        <p class="text-xl font-normal text-gray-900 dark:text-white">
                                            {{ $mensaje['mensaje'] }}</p>
                                        <span
                                            class="text-sm capitalize font-normal text-gray-500 dark:text-gray-200">{{ \Carbon\Carbon::parse($mensaje['created_at'])->format('H:i:s') }}</span>
                                    </div>
                                </div>
                                <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                    data-dropdown-placement="bottom-start"
                                    class="inline-flex self-center items-center p-2 text-xl capitalize font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                                    type="button">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                        <path
                                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                    </svg>
                                </button>
                                <div id="dropdownDots"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-xl capitalize text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownMenuIconButton">
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div class="absolute bottom-0 left-0 right-0 flex">
                    <input type="text" wire:model="mensaje" wire:keydown.enter="enviarMensaje"
                        class="border-none focus:border-none focus:outline-none rounded p-2 w-full text-2xl"
                        placeholder="Escribe un mensaje">
                    @error('mensaje')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const conversaciones = document.querySelectorAll(".conversacion");

        conversaciones.forEach(conversacion => {
            conversacion.addEventListener("click", e => {
                e.preventDefault();
                // Selecciona el contenedor de mensajes
                var messageContainer = document.querySelector(".message-list");

                if (messageContainer) {
                    // Haz scroll hacia abajo al contenedor de mensajes
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                }
            })
        });
    });
</script>

<script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    let pusher = new Pusher('a2dd7a88c32a22d60423', {
        cluster: 'us2'
    });

    let channel = pusher.subscribe('chat-room');

    channel.bind('mensaje-guardado', function(data) {
        alert('Evento recibido: ' + JSON.stringify(data));
    });
</script>
