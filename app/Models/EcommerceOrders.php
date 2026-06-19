<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EcommerceOrders extends Model
{
    protected $table = 'ecommerce_orders';

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'order_date' => 'datetime',
        'value_gross' => 'decimal:2',
        'value_net' => 'decimal:2',
        'value_vat' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'with_invoice' => 'boolean',
        'send_status_email' => 'boolean',
        'sended_to_camsoft' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(EcommerceOrderProducts::class, 'order_id', 'id');
    }
}
