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

        return view('shop.profile.order.show',[
            'order' => $order
        ]);
    }

    public function canceled($id)
    {
        $data = Crypt::decrypt($id);
        $order = Order::findOrFail($data['id']);
        $order->state_id = 1;
        $order->save();

        return back();
    }

}
