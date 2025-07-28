<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
       protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'tax',
        'total',
         'delivery_fee',
        'payment_method',
        'status',
        'delivery_address',
        'special_instructions',
    ];
       public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

