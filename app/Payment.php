<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Payment extends Model
{
    protected $guarded =[];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function getCreatedAtAttribute($date)
	{
		return new Date($date);
    }
}
