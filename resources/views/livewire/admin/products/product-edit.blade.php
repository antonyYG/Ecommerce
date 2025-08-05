<div>
    <form wire:submit="store">
        <figure class="mb-4 relative">
            <div class="absolute top-8 right-8">
                <label class="flex items-center px-4 py-2 rounded-lg bg-white cursor-pointer text-gray-700">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar Imagen
                    <input type="file" 
                    class="hidden"
                    accept="image/*"
                    wire:model="image">
                </label>
            </div>
            <img class="aspect-[16/9] object-cover object-center w-full" 
            src="{{ $image ? $image->temporaryUrl() : Storage::url($productEdit['image_path'])}}" 
            alt="">
        </figure>
        <x-error class="mb-4"></x-error>

        <div class="card">

            <div class="mb-4">
                <x-label class="mb-1">
                    Codigo
                </x-label>
                <x-input 
                wire:model="productEdit.sku" 
                class="w-full" 
                placeholder="Ingrese el codigo">
                </x-input>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="productEdit.name" 
                class="w-full" 
                placeholder="Ingrese el nombre del producto">
                </x-input>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripcion
                </x-label>
                <x-textarea
                wire:model="productEdit.description"
                class="w-full"
                placeholder="Ingrese la descripcion del producto">
                </x-textarea>
            </div>

            <div class="mb-4">
                <x-label>
                    Familias
                </x-label>
                <x-select class="w-full" wire:model.live="family_id">
                    <option value="" disabled>
                        Seleccionar una familia
                    </option>
                    @foreach ($families as $family)
                        <option value="{{$family->id}}">
                            {{$family->name}}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label>
                    Categorias
                </x-label>
                <x-select class="w-full" wire:model.live="category_id">
                    <option value="" disabled>
                        Seleccionar una Categoria
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{$category->id}}">
                            {{$category->name}}
                        </option>
                    @endforeach
                </x-select>
            </div>
            <div class="mb-4">
                <x-label>
                    SubCategorias
                </x-label>
                <x-select class="w-full" wire:model.live="productEdit.subcategory_id">
                    <option value="" disabled>
                        Seleccionar una SubCategoria
                    </option>
                    @foreach ($this->subCategories as $subcategory)
                        <option value="{{$subcategory->id}}">
                            {{$subcategory->name}}
                        </option>
                    @endforeach
                </x-select>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Precio
                </x-label>
                <x-input
                type="number"
                step="0.01" 
                wire:model="productEdit.price"
                class="w-full"
                placeholder="Ingrese el precio"
                >
            </x-input>
            </div>

            @empty($product->variants->count() > 0)
                
            <div class="mb-4">
                <x-label class="mb-1">
                    Stock
                </x-label>
                <x-input
                type="number"
                wire:model="productEdit.stock"
                class="w-full"
                placeholder="Ingrese el stock del producto"
                >
            </x-input>
            </div>
            
            @endempty

            <div class="flex justify-end">
                <div class="flex justify-end space-x-2">
                <x-danger-button onclick="confirmDelete()">
                    Eliminar
                </x-danger-button>
                <x-button>
                    Actualizar
                </x-button>
            </div>
            </div>
        </div>
    </form>
    <form action="{{route('admin.products.destroy',$product)}}" id="delete-form"
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
</div>