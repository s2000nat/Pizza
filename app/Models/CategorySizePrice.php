<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategorySizePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_id',
        'price_category_id',
        'price'
    ];

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function priceCategory(): BelongsTo
    {
        return $this->belongsTo(PriceCategory::class, 'price_category_id');
    }
}
