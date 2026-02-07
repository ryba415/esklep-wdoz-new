<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product
{
    public $productId;
    public $name;
    public $brand;
    public $content;
    public $images;
    public $is_cosmetic;
    public $type_of_preparation;
    public $vat_rate;     
    
    function __construct() {
        
    }
    
    function loadProductId($id) {
        $id = preg_replace("/[^0-9]/", '', $id);
        $this->productId = $id;
            
        $existProduct = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_products WHERE id = ?', [$id]);

        if (count($existProduct) > 0){
            foreach($existProduct[0] as $key => $productData){
                if (property_exists($this, $key)){
                    if ($key != 'id'){
                        $this->{$key} = $productData;
                    }
                }
            }
            
            $this->images = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_product_images '
                    . ' LEFT JOIN ecommerce_product_image ON ecommerce_product_images.product_image_id = ecommerce_product_image.id WHERE ecommerce_product_images.product_id = ? '
                    . ' ORDER BY position', [$id]);
        }
    }
    
    function diplayPrice($price){
        return number_format(floatval($price), 2,',',' ');
    }
    
    
    
}
