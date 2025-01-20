<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Size $size
 */
class CategorySizePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_id',
        'price_category_id',
        'price'
    ];

    /**
     * @return BelongsTo<MenuItem, CategorySizePrice>
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    /**
     * @return BelongsTo<Size, CategorySizePrice>
     */
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    /**
     * @return BelongsTo<PriceCategory, CategorySizePrice>
     */
    public function priceCategory(): BelongsTo
    {
        return $this->belongsTo(PriceCategory::class, 'price_category_id');
    }
}
