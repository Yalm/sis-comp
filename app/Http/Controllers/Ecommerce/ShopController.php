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
        $products = Product::all();
        return view('ecommerce/home',['products' => $products]);
    }

    public function product($url)
    {
        $product = Product::where('url',$url)->first();
        return view('ecommerce/show-product',['product' => $product]);
    }

    public function shop(Request $request)
    {
        if($request->ajax()){
            $data = Product::latest()->name($request->search)
            ->categorySearch($request->category)
            ->price($request->min_price,$request->max_price)->paginate(9);
            return response()->json($data,200);
        }
        return view('ecommerce/shop',['categorySearch' => $request->category,'search' => $request->search]);
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
