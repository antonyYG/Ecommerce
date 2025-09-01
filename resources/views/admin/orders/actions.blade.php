<div class="flex flex-col space-y-2">

    @switch($order->status)
        @case(\App\Enums\OrderStatus::Pending)
            
            <button
            wire:click="markAsProcessing({{$order->id}})" 
            class="underline text-blue-500 hover:no-underline">
                Listo para despachar
            </button>

            @break
        @case(\App\Enums\OrderStatus::Processing)

            <button 
            class="underline text-blue-500 hover:no-underline"
            Wire:click="assignDriver({{$order->id}})">
                Asignar Repartidor
            </button>

            @break
        @case(\App\Enums\OrderStatus::Failed)

            <button 
            class="underline text-blue-500 hover:no-underline"
            Wire:click="markAsRefunded({{$order->id}})">
                Marcar como devuelto
            </button>

            @break
        @case(\App\Enums\OrderStatus::Refunded)

            <button 
            class="underline text-blue-500 hover:no-underline"
            Wire:click="assignDriver({{$order->id}})">
                Asignar Repartidor
            </button>


            @break
        @default
            
    @endswitch

    @if ($order->status != \App\Enums\OrderStatus::Cancelled)
        <button class="underline text-blue-500 hover:no-underline"
        wire:click="cancelOrder({{$order->id}})">
            Cancelar
        </button>   
    @endif
        

</div>