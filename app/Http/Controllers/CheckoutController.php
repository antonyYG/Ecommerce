<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\Variant;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {   

        Cart::instance('shopping');

        $content = Cart::content()->filter(function ($item){
            return $item->qty <= $item->options['stock'];
        });

        $subtotal = $content->sum(function ($item){
            return $item->subtotal;
        });

        $delivery = number_format(5,2);

        $total = $subtotal + $delivery;

        $accessToken = $this->generateAccessToken();
        $sessionToken =  $this->generateSessionToken($accessToken,$total);
        
        return view('checkout.index',compact('total','delivery','subtotal','content','sessionToken'));
    }

    public function generateAccessToken()
    {
        $url_api = config('services.niubiz.url_api') . '/api.security/v1/security';
        $user = config('services.niubiz.user');
        $password = config('services.niubiz.password');

        $auth = base64_encode($user . ':' . $password);

        return Http::withHeaders([
            'Authorization' => 'Basic ' . $auth,
        ])
            ->get($url_api)
            ->body();
    } 

    public function generateSessionToken($accessToken,$total)
    {
        $merchant_id=config('services.niubiz.merchant_id');
        $url_api = config('services.niubiz.url_api') . "/api.ecommerce/v2/ecommerce/token/session/{$merchant_id}";

        $response =Http::withHeaders([
            'Authorization' =>$accessToken,
            'Content-Type' => 'application/json',

        ])
        ->post($url_api,[
            'channel' => 'web',
            'amount' => $total,
            'antifraud' => [
                'client_ip' => request()->ip(),
                'merchantDefineData' => [
                    'MDD15' => 'value15',
                    'MDD20' => 'value20',
                    'MDD33' => 'value33',
                ]
            ]
        ])
        ->json();

        return $response['sessionKey'];
    }

    public function paid(Request $request)
    {
        $accessToken = $this->generateAccessToken();
        $merchant_id=config('services.niubiz.merchant_id');
        $url_api = config('services.niubiz.url_api') . "/api.authorization/v3/authorization/ecommerce/{$merchant_id}";

        $response=Http::withHeaders([
            'Authorization' => $accessToken,
            'Content-Type' => 'application/json'
        ])
        ->post($url_api,[
            "channel" => "web",
            "captureType" => "manual",
            "countable" => true,
            "order" => [
                "tokenId" => $request->transactionToken,
                "purchaseNumber" => $request->purchaseNumber,
                "amount" => $request->amount,
                "currency" => "PEN",
            ]
        ])->json();
        

        session()->flash('niubiz',[
            'response' =>$response,
            "purchaseNumber" => $request->purchaseNumber,
        ]);

        if (isset($response['dataMap']) && $response['dataMap']['ACTION_CODE'] === '000' ) {

            Cart::instance('shopping');

            $content = Cart::content()->filter(function ($item){
                return $item->qty <= $item->options['stock'];
            });

            $address = Address::where('user_id',auth()->id())
            ->where('default',true)
            ->first();

            Order::create([
                'user_id' => auth()->id(),
                'content' => $content,
                'address' => $address,
                'payment_id' => $response['dataMap']['TRANSACTION_ID'],
                'total' => $response['dataMap']['AMOUNT']
            ]);

            foreach ($content as $item) {
                Variant::where('sku',$item->options['sku'])
                ->decrement('stock',$item->qty);

                Cart::remove($item->rowId);
            }
            
            return redirect()->route('gracias');

        }

        return redirect()->route('checkout.index');

    }

}
