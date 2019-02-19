<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Payment extends Model
{
    protected $guarded =[];
    protected $primaryKey = 'order_id';

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function getCreatedAtAttribute($date)
	{
		return new Date($date);
    }
}
