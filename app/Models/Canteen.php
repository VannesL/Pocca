<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canteen extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['name', 'address', 'favorites'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function favoritedCustomers()
    {
        return $this->belongsToMany(Customer::class, 'favorite_canteens', 'canteen_id', 'customer_id')->withPivot('customer_id');
    }
}
