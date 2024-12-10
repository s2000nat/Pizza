<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'category_size_price_id',
    ];

    public function categorySizePrice(): BelongsTo
    {
        return $this->belongsTo(CategorySizePrice::class, 'category_size_price_id');
    }

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }

    public function CartUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_products')
            ->withPivot('quantity');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
