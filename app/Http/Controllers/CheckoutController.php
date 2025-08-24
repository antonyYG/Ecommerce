<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index()
    {   
        $accessToken = $this->generateAccessToken();
        $sessionToken =  $this->generateSessionToken($accessToken);
        
        return view('checkout.index',compact('sessionToken'));
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

    public function generateSessionToken($accessToken)
    {
        $merchant_id=config('services.niubiz.merchant_id');
        $url_api = config('services.niubiz.url_api') . "/api.ecommerce/v2/ecommerce/token/session/{$merchant_id}";

        $response =Http::withHeaders([
            'Authorization' =>$accessToken,
            'Content-Type' => 'application/json',

        ])
        ->post($url_api,[
            'channel' => 'web',
            'amount' => Cart::instance('shopping')->subtotal(),
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

            $address = Address::where('user_id',auth()->id())
            ->where('default',true)
            ->first();

            Order::create([
                'user_id' => auth()->id(),
                'content' => Cart::instance('shopping')->content(),
                'address' => $address,
                'payment_id' => $response['dataMap']['TRANSACTION_ID'],
                'total' => Cart::subtotal()
            ]);

            Cart::destroy();
            
            return redirect()->route('gracias');

        }

        return redirect()->route('checkout.index');

    }

}
