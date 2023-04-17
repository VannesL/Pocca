<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['vendor_id', 'category_id', 'name', 'description', 'availability', 'price', 'cook_time', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
