<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Product;

class BasketItem extends Product
{
    public $id;
    public $productId;

    public $expiration_date;
    public $quantity;
    public $priceNet;
    public $priceGross;
    public $vatRate;
    public $valueNet;
    public $valueGross;
    public $currentlyOnOffer = false;
    
    function __construct() {
        
    }
    
    function loadItemById($id)
    {
        $id = preg_replace("/[^0-9]/", '', $id);
        $this->id = $id;

        $existBasketItem = DB::connection('mysql-esklep')->select(
            'SELECT * FROM ecommerce_basket_position WHERE id = ?',
            [$id]
        );

        if (count($existBasketItem) > 0) {
            $row = $existBasketItem[0];

            $this->productId = $row->product_id;

            $existProduct = DB::connection('mysql-esklep')->select(
                'SELECT id FROM ecommerce_products WHERE id = ?',
                [$this->productId]
            );

            if (count($existProduct) > 0) {
                $this->currentlyOnOffer = true;
                $this->loadProductId($this->productId);
            }

            $this->expiration_date = $row->expiration_date;
            $this->quantity = $row->quantity;
            $this->priceNet = $row->priceNet;
            $this->priceGross = $row->priceGross;
            $this->vatRate = $row->vatRate;
            $this->valueNet = $row->valueNet;
            $this->valueGross = $row->valueGross;
        }
    }

    
}
