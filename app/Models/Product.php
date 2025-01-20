<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_item_id',
        'category_size_price_id',
    ];

    /**
     * @return BelongsTo<CategorySizePrice, Product>
     */
    public function categorySizePrice(): BelongsTo
    {
        return $this->belongsTo(CategorySizePrice::class, 'category_size_price_id');
    }

    /**
     * @return BelongsTo<MenuItem, Product>
     */
    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }

    /**
     * @return BelongsToMany<User>
     */
    public function CartUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_products')
            ->withPivot('quantity');
    }

    /**
     * @return HasMany<OrderProduct>
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * @return BelongsToMany<Order>
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
