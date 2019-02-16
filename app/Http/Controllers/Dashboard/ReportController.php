<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Order;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.report.index');
    }

    public function topProducts(Request $request)
    {
        $date_init = new \DateTime($request->date_init);
        $date_end = new \DateTime($request->date_end);

        $products = Product::top7Product($date_init,$date_end);
        return response()->json($products);
    }

    public function purchases(Request $request)
    {
        $date_init = new \DateTime($request->date_init);
        $date_end = new \DateTime($request->date_end);

        $orders = Order::purchases($date_init,$date_end)->paginate(9);
        $orders->each(function($order){
            $order->date = $order->created_at->format('F d \,\ Y ');
        });
        return response()->json($orders);
    }
    public function topCustomer(Request $request)
    {
        $date_init = new \DateTime($request->date_init);
        $date_end = new \DateTime($request->date_end);

        $model = Order::topCustomer($date_init,$date_end);

        $model->each(function($model,$index)
        {
            $index++;
            $model->top = $index;
        });
		return response()->json($model);
    }
}
