<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceProducts extends Model
{
    protected $table = 'ecommerce_products';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'price_gross' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'short_expiration_date' => 'date',
        'is_active' => 'boolean',
        'is_natural' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_special_offer' => 'boolean',
        'is_cosmetic' => 'boolean',
    ];
}
