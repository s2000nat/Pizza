<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'phone_number',
        'location_id',
        'status',
    ];

    /**
     * @return BelongsToMany<Product>
     */
    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return HasMany<OrderProduct>
     */
    public function orderProduct(): HasMany
    {
        return  $this->hasMany(OrderProduct::class);
    }

    /**
     * @return BelongsTo<User, Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Location, Order>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
