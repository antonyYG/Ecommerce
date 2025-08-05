<div>
    <x-error>
        
    </x-error>
    <form wire:submit="save">
    <div class="card">

        <div class="mb-4">
            <x-label class="mb-2">
                Familias
            </x-label>
            <x-select class="w-full" wire:model.live="subcategory.family_id">
                <option value="" disabled>
                    Seleciones Una familia
                </option>
                @foreach ($families as $family )
                    <option value="{{$family->id}}">
                        {{$family->name}}
                    </option>
                @endforeach
            </x-select>
        </div>
        <div class="mb-4">
            <x-label class="mb-2">
                Categorias
            </x-label>
            <x-select name="category_id" class="w-full" wire:model.live="subcategory.category_id">
                <option value="" disabled>
                    Seleciones una categoria
                </option>
                @foreach ($this->categories as $category)
                    <option value="{{$category->id}}"
                        @selected(old('category_id') == $category->id)>
                        {{$category->name}}
                    </option>
                @endforeach
            </x-select>
        </div>
        <div class="mb-4">
            <x-label class="mb-2">
                Nombre
            </x-label>

            <x-input class="w-full" placeholder="Ingrese el nombre de la categoria" wire:model="subcategory.name">
            </x-input>
            @error('name')
                <span class="text-red-700 semibold">{{$message}}</span>
            @enderror
        </div>
        <div class="flex justify-end">
            <x-button>
                Guardar
            </x-button>
        </div>
    </div>
</form>

</div>

