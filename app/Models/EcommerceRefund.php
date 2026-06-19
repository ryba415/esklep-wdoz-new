<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EcommerceRefund extends Model
{
    protected $table = 'ecommerce_refunds';

    protected $guarded = [];

    protected $casts = [
        'total_value_gross' => 'decimal:2',
        'meta' => 'array',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(EcommerceRefundProduct::class, 'ecommerce_refund_id');
    }
}
