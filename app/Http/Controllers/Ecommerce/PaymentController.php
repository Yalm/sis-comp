<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Culqi\Culqi;
use App\Order;
use App\Product;
use App\User;
use App\Payment;

class PaymentController extends Controller
{
    public function checkout()
	{
		$products = \Cart::getContent();
        $total_cart = \Cart::getTotal();
        $culqi_pk_public = env('CULQUI_PUBLIC_KEY');

		return view('ecommerce.payment.checkout',
		[
			'products' => $products,
            'total_cart' => $total_cart,
            'culqi_pk_public' => $culqi_pk_public
		]);
    }

    public function success(Request $request)
	{
		if($request->method == 'card')
		{
			return $this->creditCard($request);
		}else{
            return response()->json(['message' => 'not found method'],404);
        }
	}

    private function creditCard($request)
    {
        $total = \Cart::getTotal();

        $SECRET_KEY = env('CULQUI_SECRET_KEY');

        $culqi = new Culqi(array('api_key' => $SECRET_KEY));

        try{
            $culqiSuccess = $culqi->Charges->create(
                array(
                    "amount" => $total * 100,
                    "capture" => true,
                    "currency_code" => "PEN",
                    "description" => "Ventas En Línea Sis Comp",
                    "email" => Auth()->user()->email,
                    "installments" => 0,
                    "source_id" => $request->token
                )
            );
        }
        catch(\Exception $e){
            $message = json_decode($e->getMessage());
            return response()->json($message,422);
        }

        $order = Order::create([
            'customer_id' => Auth()->user()->id,
            'plus_info' => $request->plus_info,
            'state_id' => 2
        ]);

        $meOrder = Order::find($order->id);

		$payment = new Payment;
        $payment->amount = $total;
        $payment->reference_code = $culqiSuccess->reference_code;
		$payment->payment_type_id = 1;
        $meOrder->payment()->save($payment);

        foreach(\Cart::getContent() as $product)
        {
            $productFind = Product::findOrFail($product->id);
            $productFind->stock = $productFind->stock - $product->quantity;
            $productFind->save();

            $order->products()->attach($product->id,['quantity' => $product->quantity]);
        }
        \Cart::clear();
        Auth()->user()->sendOrderNotification($order);
        $users = User::where('actived',true)->get();
        foreach($users as &$user){
            $user->sendOrderNotification($order);
        }
        $order->date = $order->created_at->format('F d \,\ Y ');
        return response()->json(['message' => 'success','data' => $order],200);
    }
}
