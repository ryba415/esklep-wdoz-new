<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EcommerceRefundProduct extends Model
{
    protected $table = 'ecommerce_refunds_products';

    protected $guarded = [];

    protected $casts = [
        'quantity' => 'integer',
        'price_gross' => 'decimal:2',
        'value_gross' => 'decimal:2',
        'meta' => 'array',
    ];

    public function refund(): BelongsTo
    {
        return $this->belongsTo(EcommerceRefund::class, 'ecommerce_refund_id');
    }
}
