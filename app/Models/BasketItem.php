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
    public $quantity;
    public $priceNet;
    public $priceGross;
    public $vatRate;
    public $valueNet;
    public $valueGross;
    public $currentlyOnOffer = false;
    
    function __construct() {
        
    }
    
    function loadItemById($id) {
        $id = preg_replace("/[^0-9]/", '', $id);
        $this->id = $id;
        $existBasketItem = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_basket_position WHERE id = ?', [$id]);
        if (count($existBasketItem) > 0){
            
            $this->productId = $existBasketItem[0]->product_id;
            
            $existProduct = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_products WHERE id = ?', [$this->productId]);
            
            if (count($existBasketItem) > 0){
                $this->currentlyOnOffer = true;
                $this->loadProductId($this->productId);
            }
            
            $this->quantity = $existBasketItem[0]->quantity;
            $this->priceNet = $existBasketItem[0]->priceNet;
            $this->priceGross = $existBasketItem[0]->priceGross;
            $this->vatRate = $existBasketItem[0]->vatRate;
            $this->valueNet = $existBasketItem[0]->valueNet;
            $this->valueGross = $existBasketItem[0]->valueGross;
        }
    }
    
}
