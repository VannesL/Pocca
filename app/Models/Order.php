<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['customer_id', 'vendor_id', 'status_id', 'total', 'type', 'date', 'reviewed', 'payment_image', 'rejection_reason', 'finish_time'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withTrashed();
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
}
