<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Order extends Model
{
    protected $guarded =[];

    public function products()
    {
      	return $this->belongsToMany(Product::class,'order_details')->withTimestamps()->withPivot(['quantity']);
    }

    public function getIdFormat()
    {
		$parameter =['id' => $this->attributes['id'],];
		return Crypt::encrypt($parameter);
    }

    public function customer()
    {
      return $this->belongsTo(Customer::class);

    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function getColorState()
    {
		switch ($this->attributes['state_id'] )
		{
			case 1:
				return 'text-danger';
				break;
			case 2:
				return 'text-success';
				break;
			case 3:
				return 'text-warning';
				break;
			case 4:
				return 'text-primary';
				break;
			default:
				echo "text-danger";
		}
	}
}
