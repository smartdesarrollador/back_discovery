<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productFeatures()
    {
        return $this->hasMany(ProductFeatures::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    public function getPriceattribute()
    {
        $store = Store::where('id', 1)->get()->first()->toArray();
        return round($store['exchange_rate']*$this->attributes['price'],2);


    }

    protected $appends = ['price'];
}
