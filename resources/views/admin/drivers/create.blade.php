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
        'name' => 'Nuevo'
    ]
]">

    <div class="bg-white rounded-lg shadow-lg p-8">

        <x-error></x-error>

        <form action="{{route('admin.drivers.store')}}" method="post">
            @csrf
            <div class="mb-4">
                <x-label class="mb-1">
                    Usuario
                </x-label>

                <x-select class="w-full"
                name="user_id">
                    <option value="" selected disabled>Selecione un usuario</option>
                    @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @selected($user->id == old('user_id'))>
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
                        @selected(old('type')==1)>
                            Motocicleta
                        </option>

                        <option value="2"
                        @selected(old('type')==2)>
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
                    value="{{old('plate_number')}}"></x-input>

                </div>

            </div>

            <div class="flex justify-end">

                <x-button>
                    Guardar
                </x-button>

            </div>

        </form>

    </div>

</x-admin-layout>