<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $fillable = ['email', 'password', 'name', 'phone_number','dob'];
}
