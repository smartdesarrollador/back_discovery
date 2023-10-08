<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function getStockAttribute()
    {
        $stock = 0;


        foreach ($this->variations as $variation) {
            $stock += $variation['stock'];

        }
        return $stock;


    }

    public function getImageAttribute()
    {


        return $this->productImages->first()['file_name'];


    }

    public function getPriceAttribute()
    {
        $preciosVariacion = [];

        foreach ($this->variations as $variation) {
            array_push($preciosVariacion, (float)$variation['price']);

        }
        if (empty($preciosVariacion)) {
            return 0;

        } else {
            $precioMinimo = min($preciosVariacion);
            $precioMaximo = max($preciosVariacion);
            return $precioMinimo;
        }

    }

    /**
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return $this->seo_friendly_url($this->attributes['name']);
    }

    protected $appends = ['price', 'stock', 'slug', 'image'];
}
