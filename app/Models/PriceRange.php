<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'value', 'min', 'max'];

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
}
