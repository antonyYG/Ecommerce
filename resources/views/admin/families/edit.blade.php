<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.families.index')
        
    ],
    [
        'name' => $family->name,
    ]
]">
 <div class="card">
        <form action="{{route('admin.families.update',$family)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">

                <x-label class="mb-2">
                    Nombre
                </x-label>

                <x-input class="w-full" placeholder="Ingrese el nombre de la familia" name="name"
                value="{{old('name',$family->name)}}">
                </x-input>
            </div>
            <div class="flex justify-end space-x-2">
                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>
                <x-button>
                    Actualizar
                </x-button>
            </div>
        </form>
    </div>
    <form action="{{route('admin.families.destroy',$family)}}" id="delete-form"
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