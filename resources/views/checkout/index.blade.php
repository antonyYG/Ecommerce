<x-app-layout>

    <div class="-mb-16 text-gray-700" x-data="{
        pago:1
    }">

        <div class="grid grid-cols-1 lg:grid-cols-2">

            <div class="cols-span-1 bg-white">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">

                    <h1 class="text-2xl font-semibold mb-2">
                        Pago
                    </h1>

                    <div class="shadow rounded-lg overflow-hidden border border-gray-400">

                        <ul class="divide-y divide-gray-400">
                            <li>
                                <label class="p-4 flex items-center">

                                    <input type="radio" value="1" x-model="pago">

                                    <span class="ml-2">
                                        Tarjeta de debito / credito
                                    </span>

                                    <img src="https://codersfree.com/img/payments/credit-cards.png" class="h-6 ml-auto">

                                </label>

                                <div class="p-4 bg-gray-100 text-center border-top border-gray-400"
                                    x-cloak
                                    x-show="pago==1">

                                    <i class="fa-regular fa-credit-card text-9xl"></i>

                                    <p class="mt-2">
                                        Luego de hacer click en pagar ahora se abrira el checkaut de Niubiz para completar la compra
                                    </p>

                                </div>

                            </li>
                        </ul>

                    </div>

                </div>
            </div>

            <div class="cols-span-1">
                <div class="lg:max-w-[40rem] py-12 px-4 lg:pl-8 sm:pr-6 lg:pr-8 mr-auto">
                    
                    <ul class="space-y-4 mb-4">

                        @foreach ($content as $item)
                            <li class="flex items-center space-x-4">

                                <div class="flex-shrink-0 relative">
                                    <img class="h-16 aspect-square" src="{{$item->options->image}}" alt="">

                                    <div class="flex justify-center items-center h-6 w-6 bg-gray-900 bg-opacity-70 rounded-full absolute -right-2 -top-2">
                                        <span class="text-white font-semibold">
                                            {{$item->qty}}
                                        </span>
                                    </div>

                                </div>

                                <div class="flex-1">
                                    <p>
                                        {{$item->name}}
                                    </p>
                                </div>

                                <div class="flex-shrink-0">
                                    <p>
                                        S/.{{$item->price}}
                                    </p>
                                </div>

                            </li>
                        @endforeach

                    </ul>

                    <div class="flex justify-between">
                        <p>
                            Subtotal
                        </p>

                        <p>
                            S/ . {{$subtotal}}
                        </p>

                    </div>

                    <div class="flex justify-between">
                        <p>
                            Envio

                            <i class="fas fa-info-circle" title="El precio de envio es de S/ 5"></i>

                        </p>

                        <p>
                            S/ . {{$delivery}}
                        </p>

                    </div>

                    <hr class="my-3">

                    <div class="flex justify-between mb-4">

                        <p class="text-lg font-semibold">
                            Total
                        </p>

                        <p>
                            S/ . {{$total}}
                        </p>

                    </div>

                    <div>
                        <button onclick="openForm()" class="btn btn-purple w-full">
                            Finalizar pedido
                        </button>

                        @if (session('niubiz'))
                            
                            @php
                                $niubiz = session('niubiz');
                                $response = $niubiz['response'];
                                $purchaseNumber = $niubiz['purchaseNumber'];
                            @endphp

                            @isset($response["data"])
                                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 mt-8" role="alert">
                                    <p class="mb-4">
                                        {{$response['data']['ACTION_DESCRIPTION']}}
                                    </p>

                                    <p>
                                        <b>Numero de pedido</b>
                                        {{$purchaseNumber}}
                                    </p>

                                    <p>
                                        <b>
                                            Fecha y hora del pedido
                                        </b>

                                        {{now()->createFromFormat('ymdHis',$response['data']['TRANSACTION_DATE'])->format('d-m-Y H:i:s') }}

                                    </p>

                                    @isset($response['data']['CARD'])

                                        <p>
                                            <b>Tarjeta:</b>
                                            {{$response['data']['CARD']}} ({{$response['data']['BRAND']}})
                                        </p>
                                        
                                    @endisset

                                </div>
                            @endisset

                        @endif

                    </div>

                </div>
            </div>

        </div>

    </div>

    @push('js')
        <script type="text/javascript" src="{{config('services.niubiz.url_js')}}">
       
        </script>
        <script type="text/javascript">
        let amount = {{$total}};
        let purchasenumber = Math.floor(Math.random() * 10000000);
        function openForm() {
            VisanetCheckout.configure({
            sessiontoken:'{{$sessionToken}}',
            channel:'web',
            merchantid:"{{config('services.niubiz.merchant_id')}}",
            purchasenumber:purchasenumber,
            amount:amount,
            expirationminutes:'20',
            timeouturl:'about:blank',
            merchantlogo:'img/comercio.png',
            formbuttoncolor:'#000000',
            action:"{{ route('checkout.paid') }}?amount="+amount + "&purchaseNumber=" + purchasenumber,
            complete: function(params) {
            alert(JSON.stringify(params));
            }
            });
            VisanetCheckout.open();
        }

        function procesar(parametros) {
            console.log(parametros);
        }
        </script>
        
    @endpush

</x-app-layout>