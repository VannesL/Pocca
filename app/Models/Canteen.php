<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function favorite_canteens()
    {
        return $this->belongsToMany(Canteen::class, 'favorite_canteens', 'canteen_id', 'customer_id');
    }
}
