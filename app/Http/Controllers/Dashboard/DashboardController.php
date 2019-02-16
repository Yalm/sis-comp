<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Product;
use App\Order;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customersCount = Customer::all()->count();
        $productsCount = Product::all()->count();
        $orderCount = Order::all()->count();
        return view('dashboard.index',['customersCount' => $customersCount,'productsCount' => $productsCount,'orderCount' => $orderCount]);
    }
}
