<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\State;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax() && $request->json)
        {
            $orders = Order::latest()->search($request->search)->paginate(7);
            $orders->each(function($order){
                $order->customer;
                $order->state;
                $order->payment;
                $order->date = $order->created_at->format('F d \,\ Y ');
            });
            return response()->json($orders,200);
        }else{
            return view('dashboard.order.index');
        }
    }

    public function edit($id)
    {
        $states = State::all();
        $order = Order::findOrFail($id);
        $order->customer;
        $order->products;
        $order->payment;
        $order->payment->date = $order->payment->created_at->format('F d \,\ Y ');
        return view('dashboard.order.edit',['states' => $states,'order' => $order]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->plus_info = $request->plus_info;
        $order->state_id = $request->state_id;
        $order->save();
        return response()->json($order);
    }
}
