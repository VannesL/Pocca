<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['email', 'password', 'name', 'store_name', 'phone_number', 'address', 'description', 'favorites', 'qris', 'image'];

    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    public function canteen() {
        return $this->belongsTo(Canteen::class);
    }

    public function priceRange() {
        return $this->belongsTo(PriceRange::class);
    }
}
