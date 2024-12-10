<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'orders_products';

    protected $fillable = [
        'orders_id',
        'products_id',
        'quantity',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}
