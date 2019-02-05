<?php

namespace App\Http\Controllers\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(9)->get();
        $products->each(function($products){
            $products->cover = Storage::disk('gcs')->url($products->cover);
        });
        return view('ecommerce/home',['products' => $products]);
    }

    public function product($url)
    {
        $product = Product::where('url',$url)->first();
        $product->cover = Storage::disk('gcs')->url($product->cover);
        return view('ecommerce/show-product',['product' => $product]);
    }

    public function shop(Request $request)
    {
        $max = Product::max('price');
        return view('ecommerce/shop',['max' => $max]);
    }

    public function shopJson(Request $request)
    {
        $data = Product::latest()->name($request->search)
        ->categorySearch($request->category)
        ->price($request->min_price,$request->max_price)->paginate(9);
        /*$data->each(function($data){
            $data->cover = Storage::disk('gcs')->url($data->cover);
        });*/
        return response()->json($data,200);
    }


    public function about()
    {
        return view('ecommerce/about');
    }

    public function contact()
    {
        return view('ecommerce/contact');
    }
    public function terms()
    {
        return view('ecommerce/terms');
    }

    public function sendContact(Request $request)
    {
        /*Mail::send('emails.contact-us',
        [
            'email' => $request->email,
            'user_message' => $request->message,
        ], function($message) use($request)
        {
            $message->from($request->email);
            $message->to('i2917724@continental.edu.pe', 'Admin')->subject('Mensaje de Contáctanos');
        });*/
        return back()->with('success', '¡Gracias por contactarnos!');

    }
}
