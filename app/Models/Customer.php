<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['email', 'password', 'name', 'phone_number', 'dob'];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $deletedItems = Order::where('customer_id', $model->id)
                ->whereNotIn('status_id', [5, 6])
                ->get();

            foreach ($deletedItems as $deletedItem) {
                $deletedItem->status_id = 6;
                $deletedItem->rejection_reason = 'Customer deleted from database';
                $deletedItem->save();
            }
        });
    }


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
