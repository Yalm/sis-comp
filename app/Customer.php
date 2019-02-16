<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomerResetPasswordNotification;
use App\Notifications\CustomerVerifyEmailNotification;
use App\Notifications\CustomerOrderNotification;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verifiedData()
    {
        if($this->attributes['surnames'] === null ||
        $this->attributes['document_number'] === null)
        {
            return false;
        }
        return true;
    }

    public function orders()
    {
      return $this->hasMany(Order::class);
    }

    public function document()
	{
		return $this->belongsTo(Document::class);
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomerVerifyEmailNotification());
    }

    public function sendOrderNotification($order)
    {
        $this->notify(new CustomerOrderNotification($order));
    }
}
