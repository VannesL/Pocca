<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vendor extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['email', 'password', 'name', 'store_name', 'canteen_id', 'phone_number', 'address', 'description', 'favorites', 'qris', 'image', 'rejection_reason', 'upcoming_deletion_date'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'approved_by', 'id');
    }

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function priceRange()
    {
        return $this->belongsTo(PriceRange::class, 'range_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favoritedCustomers()
    {
        return $this->belongsToMany(Customer::class, 'favorite_vendors', 'vendor_id', 'customer_id');
    }
}
