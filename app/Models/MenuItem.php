<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = ['vendor_id', 'category_id', 'name', 'description', 'availability', 'price', 'cook_time', 'recommended', 'image', 'deleted'];

    protected static function booted(){

        static::deleting(function($model){
            $deletedItems = OrderItems::where('menu_id', $model->id)
                            ->with('order', function($q){
                                $q->whereNot('status_id', 5);
                            })
                            ->get();

            foreach ($deletedItems as $deletedItem) {
                if(!is_null($deletedItem->order)){
                    $deletedItem->order->status_id = 6;
                    $deletedItem->order->save();
                }
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function menuItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
