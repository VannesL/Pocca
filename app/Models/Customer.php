<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $fillable = ['email', 'password', 'name', 'phone_number', 'dob'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function favoritedCanteens()
    {
        return $this->belongsToMany(Canteen::class, 'favorite_canteens', 'customer_id', 'canteen_id');
    }

    public function favoritedVendors()
    {
        return $this->belongsToMany(Vendor::class, 'favorite_vendors', 'customer_id', 'vendor_id');
    }
}
