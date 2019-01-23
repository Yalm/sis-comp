<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('ecommerce/home',['categories' => $categories,'products' => $products]);
    }
}
