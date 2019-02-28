<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(9);
        $products->each(function($product){
            $product->category;
            $product->cover = Storage::disk('gcs')->url($product->cover);
        });
        return response($products,200)->header('Access-Control-Allow-Origin','*');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $product->category;
        $product->cover = Storage::disk('gcs')->url($product->cover);
        return response($product,200)->header('Access-Control-Allow-Origin','*');
    }
}
