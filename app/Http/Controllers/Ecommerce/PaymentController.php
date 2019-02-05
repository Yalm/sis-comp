<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Culqi\Culqi;
use App\Order;
use App\Product;

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
        $total = \Cart::getTotal();

        $SECRET_KEY = env('CULQUI_SECRET_KEY');

        $culqi = new Culqi(array('api_key' => $SECRET_KEY));

        try{
            $payment = $culqi->Charges->create(
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
            'amount' => $total,
            'plus_info' => $request->plus_info,
            'reference_code' => $payment->reference_code,
            'state_id' => 2
        ]);

        foreach(\Cart::getContent() as $product)
        {
            $productFind = Product::findOrFail($product->id);
            $productFind->stock = $productFind->stock - $product->quantity;
            $productFind->save();

            $order->products()->attach($product->id,['quantity' => $product->quantity]);
        }
        \Cart::clear();
        Auth()->user()->sendOrderNotification($order);
        return response()->json(['message' => 'success','data' => $order],200);
    }
}
