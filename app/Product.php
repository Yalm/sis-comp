<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
    protected $guarded =[];

    public function category()
	{
		return $this->belongsTo(Category::class);
    }

    public function scopePrice($query, $min_price,$max_price)
	{
		if($min_price && $max_price && $min_price != 'undefined')
			return $query->where('price','>=',$min_price)
						->where('price','<=',$max_price);
    }

    public function orders()
    {
      	return $this->belongsToMany(Order::class,'order_details');
    }

    public function scopeName($query, $name)
	{
		if($name)
			return $query->whereRaw('LOWER(name) LIKE ? ',[trim(strtolower($name)).'%']);
    }
    public function scopeCategorySearch($query, $id)
	{
		if($id != 'false' && $id != 'null' && $id){
            return $query->where('category_id',$id);
        }
    }

    public function scopeSearch($query,$s)
	{
        if($s != 'false' && $s != 'null' && $s)
            return $query->where('name','LIKE',"%$s%")
                        ->orWhere('price','LIKE',"%$s%")
                        ->orWhere('url','LIKE',"%$s%");
    }

    public static function top7Product($f1,$f2)
	{
		return DB::table('order_details')
		->join('products', 'order_details.product_id', '=', 'products.id')
		->join('orders', 'order_details.order_id', '=', 'orders.id')
		->select('products.id','products.name' ,DB::raw('sum(quantity) as TotalQuantity') )
		->whereBetween('orders.created_at', [$f1,  $f2])
		->where('orders.state_id','=','2')
		->groupBy('products.id','products.name')
		->orderBy(DB::raw('sum(quantity)'), 'desc')
		->take(10)
		->get();
	}
}
