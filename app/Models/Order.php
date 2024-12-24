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
    ];

    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function orderProduct(): HasMany
    {
        return  $this->hasMany(OrderProduct::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
