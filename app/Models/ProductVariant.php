<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductVariant extends Model
{
    protected $fillable = [
        'name',
        'price',
        'discount',
        'img',
        'product_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute(): float
    {
        return max(0, (float) $this->price - (float) $this->discount);
    }

    public function getDiscountPercentAttribute(): int
    {
        return $this->price > 0 ? (int) round(((float) $this->discount / (float) $this->price) * 100) : 0;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->img && Storage::exists($this->img)
            ? Storage::url($this->img)
            : null;
    }
}
    