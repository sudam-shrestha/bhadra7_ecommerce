<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_variant_id',
        'merchant_id',
        'qty',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
