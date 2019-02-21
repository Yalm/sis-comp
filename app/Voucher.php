<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded =[];
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    public function voucherType()
    {
        return $this->belongsTo(VoucherType::class, 'payment_voucher_id');
    }
}
