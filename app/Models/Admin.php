<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'email', 'password', 'name', 'phone_number'];

    public function canteen() {
        return $this->hasMany(Canteen::class);
    }

    public function vendor() {
        return $this->hasMany(Vendor::class);
    }

}
