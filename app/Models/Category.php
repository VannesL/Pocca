<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'name', 'description'];

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
