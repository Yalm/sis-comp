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

		return view('ecommerce.payment.checkout',
		[
			'products' => $products,
			'total_cart' => $total_cart,
		]);
    }

    public function success(Request $request)
    {
        $total = \Cart::getTotal();

        $SECRET_KEY = "sk_test_Km1vANGLrdAE8jKm";

        $culqi = new Culqi(array('api_key' => $SECRET_KEY));

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

        $order = Order::create([
            'customer_id' => Auth()->user()->id,
            'amount' => $total,
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
        return response()->json(['message' => 'success','data' => $order],200);
    }
}
