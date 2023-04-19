<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id'];
    protected $fillable = ['email', 'password', 'name', 'store_name', 'canteen_id', 'phone_number', 'address', 'description', 'favorites', 'qris', 'image'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }

    public function priceRange()
    {
        return $this->belongsTo(PriceRange::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
