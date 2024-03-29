<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

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
