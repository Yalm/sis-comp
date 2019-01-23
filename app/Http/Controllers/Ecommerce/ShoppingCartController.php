<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
    public function index(Request $request)
    {
        $cart = \Cart::getContent();
        return view('ecommerce/shopping-cart')->with('cart', $cart);
    }


    public function store(Request $request)
    {
        $qty =  ($request->qty) ?  $request->qty:1;
        $itemQty = (\Cart::get($request->id)) ? \Cart::get($request->id)->quantity:null;

        /* sold out validaton */
		if($request->stock <= 0)
		{
			return response()->json(['message' => 'Producto agotado']);
        }

        if(!empty($itemQty))
		{
			if($itemQty + $qty > $request->stock)
			{
				return response()->json(['message' => 'Stock superado'],422);
			}
        }

        $product = \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $qty,
            'attributes' => array(
                'cover' => $request->cover,
                'stock' => $request->stock
            )
        ));

        $count_cart = \Cart::getTotalQuantity();
        return response()->json(['product' => $product, 'count_cart' => $count_cart],200);
    }

    public function count()
    {
        $count = \Cart::getTotalQuantity();
        return response()->json($count, 200);
    }

    public function destroy($id)
    {
		\Cart::remove($id);
		$total = \Cart::getTotal();
		$count_cart = \Cart::getTotalQuantity();
		return response()->json(['total' => $total, 'count_cart' => $count_cart]);
	}
}
