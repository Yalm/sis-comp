<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded =[];

    public function category()
	{
		return $this->belongsTo(Category::class);
    }

    public function scopePrice($query, $min_price,$max_price)
	{
		if($min_price && $max_price)
			return $query->where('price','>=',$min_price)
						->where('price','<=',$max_price);
    }

    public function scopeName($query, $name)
	{
		if($name)
			return $query->where('name','LIKE',"%$name%");
    }
    public function scopeCategorySearch($query, $id)
	{
		if($id)
			return $query->where('category_id',$id);
	}
}
