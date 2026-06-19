<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EcommerceOrderProducts extends Model
{
    protected $table = 'ecommerce_order_position';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'expiration_date' => 'date',
        'price_net' => 'decimal:2',
        'price_gross' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'quantity' => 'integer',
        'value_net' => 'decimal:2',
        'value_gross' => 'decimal:2',
        'weight' => 'float',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(EcommerceOrders::class, 'order_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(EcommerceProducts::class, 'product_id', 'id');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->product?->name
            ?? $this->name
            ?? $this->product_name
            ?? 'Produkt #' . $this->product_id;
    }

    public function getDisplayImageUrlAttribute(): ?string
    {
        return $this->image_url
            ?? $this->image
            ?? null;
    }
}
