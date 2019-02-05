<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('dashboard.product.index',['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.product.create',['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $path = Storage::disk('gcs')->put('products', $request->file('cover'));
        $product = Product::create([
            'cover' => $path,
            'description' => $request->description,
            'name' => $request->name,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'stock' => $request->stock,
            'url' => substr(str_slug($request->name),0,191),
            'category_id' => $request->category_id
        ]);
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        return view('dashboard.product.edit',['categories' => $categories,'product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        if($request->hasFile('cover'))
		{
            Storage::disk('gcs')->delete($product->cover);
            $product->cover = Storage::disk('gcs')->put('products', $request->file('cover'));
        }
        $product->name = $request->name;
        $product->stock = $request->stock;
		$product->description = $request->description;
		$product->short_description =$request->short_description;
		$product->price =$request->price;
        $product->url = substr(str_slug($request->name),0,191);
        $product->category_id =$request->category_id;
        $product->save();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::disk('gcs')->delete($product->cover);
        $product->delete();
		return response()->json($product);
    }
}
