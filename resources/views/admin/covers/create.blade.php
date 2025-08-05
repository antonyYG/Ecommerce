<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard')
    ],
    [
        'name' => 'Portadas',
        'route' => route('admin.covers.index')
        
    ],
    [
        'name' => 'Nuevo'
    ]

]">

    <x-error></x-error>
    <form action="{{route('admin.covers.store')}}" method="post"
        enctype="multipart/form-data">
        @csrf

        <figure class="relative mb-4">

            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white cursor-pointer text-gray-700">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar Imagen
                    <input type="file" 
                    class="hidden"
                    accept="image/*"
                    name="image"
                    onchange="previewImage(event, '#imgPreview')">
                </label>
            </div>

            <img src="{{asset('img/not.jpeg')}}" alt="Portada" class="w-full aspect-[3/1] object-cover object-center"
            id="imgPreview">

        </figure>

        <div class="mb-4">

            <x-label>
                Titulo
            </x-label>

            <x-input name="title" value="{{old('title')}}" class="w-full" placeholder="Ingrese el titulo" >

            </x-input>

        </div>

        <div class="mb-4">

            <x-label>
                Fecha de ingreso
            </x-label>

            <x-input type="date" name="start_at" value="{{old('start_at', now()->format('Y-m-d'))}}" class="w-full">

            </x-input>

        </div>

        <div class="mb-4">

            <x-label>
                Fecha fin (Opcional)
            </x-label>

            <x-input type="date" name="end_at" value="{{old('end_at')}}" class="w-full">

            </x-input>

        </div>

        <div class="mb-4 flex space-x-2">

            <label>
                <x-input type="radio" name="is_active" value="1"
                 checked>
                </x-input>
                Activo
            </label>

            <label>
                <x-input type="radio" name="is_active" value="0">
                </x-input>
                Inactivo
            </label>

        </div>

        <div class="flex justify-end">

            <x-button>
                Crear portada
            </x-button>

        </div>


    </form>

    @push('js')
    
    <script>
        function previewImage(event, querySelector){

            //Recuperamos el input que desencadeno la acción
            let input = event.target;
            
            //Recuperamos la etiqueta img donde cargaremos la imagen
            let imgPreview = document.querySelector(querySelector);

            // Verificamos si existe una imagen seleccionada
            if(!input.files.length) return
            
            //Recuperamos el archivo subido
            let file = input.files[0];

            //Creamos la url
            let objectURL = URL.createObjectURL(file);
            
            //Modificamos el atributo src de la etiqueta img
            imgPreview.src = objectURL;
                        
        }
    </script>
    
    @endpush

</x-admin-layout>