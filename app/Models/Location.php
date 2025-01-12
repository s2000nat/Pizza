<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable =[
        'city',
        'street',
        'house_number',
        'floor',
        'apartment',
        'user_id',
        'deleted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'orders_products');
    }
}
