<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model
{
    public $timestamps = false;

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
