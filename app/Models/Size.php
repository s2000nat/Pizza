<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    protected $fillable = [
        'slug',
    ];

    use HasFactory;

    /**
     * @return HasMany<CategorySizePrice>
     */
    public function categorySizePrices(): HasMany
    {
        return $this->hasMany(CategorySizePrice::class);
    }
}
