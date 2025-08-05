<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
    ]
]">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <img class="size-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold">
                        Bienvenido, {{auth()->user()->name}}
                    </h2>
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <button class="text-sm hover:text-blue-500">
                            Cerrar sesion
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-center">
            <h2 class="text-xl font-semibold" id="clock">
                {{ now() }}
            </h2>
        </div>
    </div>
   <script>
        function updateClock() {
            const clock = document.getElementById('clock');
            const now = new Date();

            // Restamos la diferencia horaria (según la zona del navegador)
            // Para Perú (GMT-5), ajustamos manualmente
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const peruTime = new Date(utc - (5 * 60 * 60 * 1000)); // -5 horas

            const year = peruTime.getFullYear();
            const month = String(peruTime.getMonth() + 1).padStart(2, '0');
            const day = String(peruTime.getDate()).padStart(2, '0');
            const hours = String(peruTime.getHours()).padStart(2, '0');
            const minutes = String(peruTime.getMinutes()).padStart(2, '0');
            const seconds = String(peruTime.getSeconds()).padStart(2, '0');

            clock.textContent = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-admin-layout>