<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Order extends Model
{
    protected $guarded =[];

    public function products()
    {
      	return $this->belongsToMany(Product::class,'order_details')->withTimestamps()->withPivot(['quantity','size']);
    }

    public function getIdFormat()
    {
		$parameter =['id' => $this->attributes['id'],];
		return Crypt::encrypt($parameter);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
