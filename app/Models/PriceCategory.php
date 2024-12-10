<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
    ];

    public function category_size_prices(): HasMany
    {
        return $this->hasMany(CategorySizePrice::class);
    }

    public function menu_items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
