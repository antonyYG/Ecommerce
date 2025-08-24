<x-app-layout>

    <div class="max-w-4xl mx-auto pt-12">

        <img src="https://d1ih8jugeo2m5m.cloudfront.net/2024/01/gracias-por-tu-compra-minimalista.jpg" alt="">

        @if (session('niubiz'))
            
            @php
                
                $response = session('niubiz')['response'];


            @endphp

            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 mt-8" role="alert">
                <p class="bt-4">
                    {{$response['dataMap']['ACTION_DESCRIPTION']}}
                </p>

                <p>
                    <b>Numero de pedido:</b>
                    {{$response['order']['purchaseNumber']}}
                </p>

                <p>
                    <b>Fecha y hora del pedido</b>
                    {{
                        now()->createFromFormat('ymdHis',$response['dataMap']['TRANSACTION_DATE'])->format('d-m-Y H:i:s') 
                    }}
                </p>

                <p>
                    <b>Tarjeta:</b>
                    {{$response['dataMap']['CARD']}} ({{$response['dataMap']['BRAND']}})
                </p>

                <p>
                    <b>Importe:</b>
                    {{$response['order']['amount']}} {{$response['order']['currency']}}
                </p>
                

            </div>

        @endif

    </div>

</x-app-layout>