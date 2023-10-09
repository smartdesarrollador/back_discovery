<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Seo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    use Seo, SoftDeletes;
    

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return string
     */
    public function getSlugAttribute(): string
    {
        return $this->seo_friendly_url($this->attributes['name']);
    }


    protected $appends = ['slug'];
}
