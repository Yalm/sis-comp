<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('dashboard.category.index',[
          'categories' => $categories,
        ]);
    }


    public function store(CategoryRequest $request)
    {
        $category = Category::create([
          'name' => $request->name
        ]);
        return response()->json($category);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->name =$request->name;
        $category->save();

        return response()->json($category);
    }

    public function destroy($id)
    {
        $cateogry = Category::findOrFail($id);

        if($cateogry->products()->count() > 0)
        {
            return response()->json(['message' => 'Su categoría esta relacionada, no se puede eliminar.'],409);
        }

        $cateogry->delete();
        return response()->json(['message' => 'su categoría ha sido eliminada con éxito'],200);
    }
}
