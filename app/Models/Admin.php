<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guarded = ['id', 'email', 'password', 'name', 'phone_number'];

    public function canteen()
    {
        return $this->hasMany(Canteen::class);
    }

    public function vendor()
    {
        return $this->hasMany(Vendor::class);
    }
}
