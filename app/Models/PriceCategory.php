<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $slug
 */
class PriceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
    ];

    /**
     * @return HasMany<CategorySizePrice>
     */
    public function category_size_prices(): HasMany
    {
        return $this->hasMany(CategorySizePrice::class);
    }

    /**
     * @return HasMany<MenuItem>
     */
    public function menu_items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
