<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Conductores',
        'route' => route('admin.drivers.index')
        
    ],
    [
        'name' => $driver->user->name
    ]
]">

    <div class="bg-white rounded-lg shadow-lg p-8">

        <x-error></x-error>

        <form action="{{route('admin.drivers.update',$driver)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-label class="mb-1">
                    Usuario
                </x-label>

                <x-select class="w-full"
                name="user_id">
                    <option value="" selected disabled>Selecione un usuario</option>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @selected($user->id == old('user_id',$driver->user_id))>
                            {{$user->name}}
                        </option>
                    @endforeach

                </x-select>

            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">

                <div>

                    <x-label class="mb-1">
                        Tipo de unidad
                    </x-label>

                    <x-select class="w-full"
                    name="type">

                        <option value="1"
                        @selected(old('type',$driver->type)==1)>
                            Motocicleta
                        </option>

                        <option value="2"
                        @selected(old('type',$driver->type)==2)>
                            Automovil
                        </option>

                        

                    </x-select>

                </div>

                <div>

                    <x-label class="mb-1">
                        Placa
                    </x-label>

                    <x-input class="w-full" name="plate_number"
                    placeholder="Ingrese la pla del vehiculo"
                    value="{{old('plate_number',$driver->plate_number)}}"></x-input>

                </div>

            </div>

            <div class="flex justify-end space-x-2">

                <x-danger-button
                id="delete-button">
                    Eliminar
                </x-danger-button>

                <x-button>
                    Actualizar
                </x-button>

            </div>

        </form>

    </div>

    <form action="{{route('admin.drivers.destroy',$driver)}}" method="POST"
    id="delete_form">
        @csrf
        @method('DELETE')

    </form>

    @push('js')
        <script>
            document.getElementById('delete-button').addEventListener('click',function(){
                document.getElementById('delete_form').submit();
            })
        </script>
    @endpush

</x-admin-layout>