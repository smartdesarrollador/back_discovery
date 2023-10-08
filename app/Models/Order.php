<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'address',
        'address2',
        'first_name',
        'last_name',
        'state_id',
        'state',
        'city',
        'zip_code',
        'phoneNumber',
        'shipping_cost',
        'is_free_shipping',
        'total',
        'additionalInformation',
        'tracking_code',
        'paypal_order_id',
        'unix_timestamp',
        'status'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
