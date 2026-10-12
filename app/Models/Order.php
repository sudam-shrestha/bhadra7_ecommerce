<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'merchant_id',
        'status',
        'payment_status',
        'payment_method',
        'total_amount',
        'contact_no',
        'address',
    ];

    public function getOrderNumberAttribute(): string
    {
        return 'ORD-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return $this->payment_method === 'khalti' ? 'Khalti' : 'Cash on delivery';
    }

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
