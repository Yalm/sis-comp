<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth('web')->user()->orders()->latest()->paginate(5);
        return view('ecommerce.profile.order.home',[
            'orders' => $orders
        ]);
    }

    public function show($id)
    {
        $data = Crypt::decrypt($id);
        $order = Order::findOrFail($data['id']);

        return view('ecommerce.profile.order.show',[
            'order' => $order
        ]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->state_id = 1;
        $order->save();
        return response()->json(['message' => 'su pedido ha sido cancelado con éxito'],200);
    }

}
