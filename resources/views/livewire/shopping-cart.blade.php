<div class="min-h-screen flex flex-col">

    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6">

        <div class="lg:col-span-5">
            <div class="flex justify-between mb-2">

                <h1 class="text-lg">
                    Carrito de compras ({{Cart::count()}} productos)
                </h1>

                <button class="font-semibold text-gray-600 hover:text-blue-400 underline hover:no-underline"
                    wire:click="destroy()">
                    Limpiar Carro
                </button>

            </div>


            <div class="card">

                <ul class="space-y-4">

                    @forelse (Cart::content() as $item)
                    
                        <li class="lg:flex {{$item->qty > $item->options['stock'] ? 'text-red-600' : ''}}">

                            <img class="w-full lg:w-36 aspect-[4/3] object-cover object-center mr-2" src="{{$item->options->image}}" alt="">

                            <div class="w-80">

                                @if ($item->qty > $item->options['stock'])
                                    
                                    <p class="font-semibold">
                                        Stock insuficiente
                                    </p>

                                @endif

                                <p class="text-sm truncate">
                                    <a href="{{route('products.show',$item->id)}}">
                                        {{$item->name}}
                                    </a>
                                </p>

                                <button class="bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold rounded px-2.5 py-0.5"
                                    wire:click="remove('{{$item->rowId}}')">
                                    <i class="fa-solid fa-xmark"></i>
                                    Quitar
                                </button>

                                @if(count($item->options->features))

                                            <p class="text-xs mb-2 text-gray-500">

                                                    {{ implode(' | ', $item->options->features) }}

                                            </p>

                                @endif

                            </div>

                            <p>
                                S/. {{$item->price}}
                            </p>

                            <div class="ml-auto space-x-3">

                                <button class="btn btn-gray"
                                    wire:click="decrease('{{$item->rowId}}')">
                                    -
                                </button>

                                <span class="inline-block w-2 text-center">
                                    {{ $item->qty }}
                                </span>

                                <button class="btn btn-gray"
                                    wire:click="increase('{{$item->rowId}}')"
                                    @disabled($item->qty >= $item->options['stock'])>
                                    +
                                </button>

                            </div>

                        </li>
                    @empty
                        <p class="text-center">
                            No hay productos en el carrito
                        </p>
                    @endforelse

                </ul>

            </div>

        </div>

        <div class="lg:col-span-2">

            <div class="card">
                
                <div class="flex justify-between font-semibold mb-2">
                    <p>

                        total

                    </p>

                    <p>

                        S/. {{$this->subtotal}}

                    </p>

                </div>

                <a href="{{route('shipping.index')}}" class="btn btn-purple block w-full text-center">

                    Continuar con la compra

                </a>

            </div>

        </div>

    </div>

</div>
