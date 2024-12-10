<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price_category_id',
    ];

    public function priceCategory(): BelongsTo
    {
        return $this->belongsTo(PriceCategory::class, 'price_category_id');
    }

    public function categorySizePrices(): HasMany
    {
        return $this->hasMany(CategorySizePrice::class, 'price_category_id', 'price_category_id');
    }

    public function getPricesWithSizes()
    {
        return $this->categorySizePrices->map(function ($categorySizePrice) {
            return [
                'Price_category_size_id' => $categorySizePrice->id,
                'size' => $categorySizePrice->size->slug,
                'price' => $categorySizePrice->price,
                ];
        });
    }
}
