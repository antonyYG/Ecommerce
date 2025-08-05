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
            src="{{ $image ? $image->temporaryUrl() : asset('img/not.jpeg')}}" 
            alt="">
            
        </figure>
        <x-error class="mb-4"></x-error>

        <div class="card">

            <div class="mb-4">
                <x-label class="mb-1">
                    Codigo
                </x-label>
                <x-input 
                wire:model="product.sku" 
                class="w-full" 
                placeholder="Ingrese el codigo">
                </x-input>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model="product.name" 
                class="w-full" 
                placeholder="Ingrese el nombre del producto">
                </x-input>
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Descripcion
                </x-label>
                <x-textarea
                wire:model="product.description"
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
                <x-select class="w-full" wire:model.live="product.subcategory_id">
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
                wire:model="product.price"
                class="w-full"
                placeholder="Ingrese el precio"
                >
            </x-input>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Crear producto
                </x-button>
            </div>
        </div>
    </form>
</div>