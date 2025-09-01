<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de compra</title>

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }
        .ticket{
            max-width: 420px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 2px solid #4a90e2;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }
        h1,h2,h3,h4{
            text-align: center;
            margin-bottom: 10px;
            color: #4a90e2;
        }
        h3{
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 12px;
        }
        .info{
            margin-bottom: 20px;
        }
        .info div{
            margin-bottom: 6px;
            font-size: 14px;
            line-height: 1.4;
        }
        .info div span{
            font-weight: bold;
            color: #555;
        }
        .footer{
            text-align: center;
            font-size: 12px;
            padding-top: 10px;
            border-top: 1px dashed #ccc;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <h4>
            Numero de orden: {{$order->id}}
        </h4>

        <div class="info">
            <h3>
                Información de la compañía
            </h3>

            <div>
                <span>Nombre:</span> Ecommerce Pepe
            </div>
            <div>
                <span>RUC:</span> 21232345672
            </div>
            <div>
                <span>Teléfono:</span> 987654321
            </div>
            <div>
                <span>Correo:</span> pepe@gmail.com
            </div>
        </div>

        <div class="info">
            <h3>
                Datos del cliente
            </h3>

            <div>
                <span>Nombre:</span> {{$order->address['receiver_info']['name'] . ' '.$order->address['receiver_info']['last_name'] }}
            </div>
            <div>
                <span>Documento:</span> {{$order->address['receiver_info']['document_number']}}
            </div>
            <div>
                <span>Dirección:</span> {{$order->address['description']}} - {{$order->address['district']}} ({{$order->address['reference']}})
            </div>
            <div>
                <span>Teléfono:</span> {{$order->address['receiver_info']['phone']}}
            </div>
        </div>

        <div class="footer">
            ¡Gracias por su compra! <br>
            <small>Conserve este ticket como comprobante.</small>
        </div>
    </div>
</body>
</html>
