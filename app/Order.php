<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Jenssegers\Date\Date;
use DB;

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

    public function getCreatedAtAttribute($date)
	{
		return new Date($date);
    }

    public function payment()
	{
	  	return $this->hasOne(Payment::class);
    }

    public function scopeSearch($query,$s)
	{
        if($s)
            return $query->where('name','LIKE',"%$s%")
                        ->orWhere('id','LIKE',"%$s%")
                        ->orWhere('created_at','LIKE',"%$s%")
                        ->orWhereHas('customers', function($q)
                        {
                            $q->where('name', 'like',"%$s%");
                        })->orWhereHas('states', function($q)
                        {
                            $q->where('name', 'like',"%$s%");
                        });
    }

    public static function purchases($f1,$f2)
	{
        return Order::join('customers', 'orders.customer_id', '=', 'customers.id')
        ->join('payments', 'payments.order_id', '=', 'orders.id')
        ->join('states', 'states.id', '=', 'orders.state_id')
        ->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
        ->select(DB::raw("CONCAT(customers.name,customers.surnames) as customer"),'orders.id','orders.created_at','payments.amount','payment_types.name as method','states.name as state')
        ->whereBetween('orders.created_at', [$f1,  $f2]);
    }

    public static function topCustomer($f1,$f2)
	{
		return DB::table('orders')
		->join('customers', 'customers.id', '=', 'orders.customer_id')
		->select('customers.name','customers.surnames','customers.phone','customers.email',DB::raw('count(customer_id) as purchases'))
		->where('state_id','=','2')
		->whereBetween('orders.created_at', [$f1,  $f2])
		->groupBy('customer_id','customers.name','customers.surnames','customers.phone','customers.email')
        ->orderBy(DB::raw('count(customer_id)'), 'desc')
        ->take(10)
		->get();
	}
}
