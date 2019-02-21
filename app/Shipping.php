<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Shipping extends Model
{
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id','address', 'departament_id', 'province_id','district_id','price'
    ];

    public function getCreatedAtAttribute($date)
	{
		return new Date($date);
    }

    public function getUpdatedAtAttribute($date)
	{
		return new Date($date);
    }
}
