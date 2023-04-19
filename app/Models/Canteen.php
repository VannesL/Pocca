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
}
