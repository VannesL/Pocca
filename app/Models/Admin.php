<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id', 'email', 'password', 'name', 'phone_number'];

    public function canteens()
    {
        return $this->hasMany(Canteen::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
}
