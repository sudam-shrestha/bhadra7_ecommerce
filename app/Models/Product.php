<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'img',
        'description',
        'merchant_id',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query
            ->whereHas('merchant', fn($m) => $m->where('status', 'approve'))
            ->has('product_variants');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->img && Storage::exists($this->img)
            ? Storage::url($this->img)
            : null;
    }

    // Cheapest variant after discount (load product_variants first to avoid extra queries)
    public function getStartingVariantAttribute(): ?ProductVariant
    {
        return $this->product_variants->sortBy('final_price')->first();
    }
}
