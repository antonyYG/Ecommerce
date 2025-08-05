<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Categorias',
        'route' => route('admin.categories.index')
        
    ],
    [
        'name' => $category->name,
    ]  
]">
    <form action="{{route('admin.categories.update',$category)}}" method="post">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="mb-4">
                <x-label class="mb-2">
                    Familia
                </x-label>
                <x-select name="family_id" class="w-full">
                    @foreach ($families as $family)
                        <option value="{{$family->id}}"
                            @selected(old('family_id',$category->family_id) == $family->id)>
                            {{$family->name}}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="mb-4">
                <x-label class="mb-2">
                    Nombre
                </x-label>

                <x-input class="w-full" placeholder="Ingrese el nombre de la categoria" name="name"
                    value="{{old('name',$category->name)}}">
                </x-input>
                @error('name')
                    <span class="text-red-700 semibold">{{$message}}</span>
                @enderror
            </div>
            <div class="flex justify-end">
                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>
                <x-button class="ml-2">
                    Actualizar
                </x-button>
            </div>
        </div>
        
    </form>
    <form action="{{route('admin.categories.destroy',$category)}}" id="delete-form"
    method="post">
        @csrf
        @method('DELETE')

    </form>
    @push('js')
    <script>
        function confirmDelete(){
            /*document.getElementById('delete-form').submit();*/
            Swal.fire({
            title: "¿Estas seguro?",
            text: "¡No podra revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Si , borralo!",
            cancelButtonText: "cancelar"
            }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
            });
        }
    </script>        
    @endpush
</x-admin-layout>