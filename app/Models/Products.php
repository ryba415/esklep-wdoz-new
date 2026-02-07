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

class Products
{
    public $products = [];   
    
    function __construct() {
        
    }
    
    function getProducts($conditions = '', $conditionsValues = [], $limit = 99) {
        $this->products = DB::connection('mysql-esklep')->select('SELECT ecommerce_products.*, image.image_name as image_name FROM ecommerce_products'
                . ' LEFT JOIN ecommerce_product_images ON ecommerce_product_images.product_id = ecommerce_products.id'
                . ' LEFT JOIN ecommerce_product_image as image ON ecommerce_product_images.product_image_id = image.id'
                . ' WHERE '.$conditions.' LIMIT ' . $limit, $conditionsValues);
        
    /*$this->products = DB::connection('mysql-esklep')->select('
        SELECT 
            ecommerce_products.*,
            (
                SELECT image.image_name
                FROM ecommerce_product_images as images
                LEFT JOIN ecommerce_product_image AS image 
                    ON images.product_image_id = image.id
                WHERE images.product_id = ecommerce_products.id
                ORDER BY image.position
                LIMIT 1
            ) AS image_name
        FROM 
            ecommerce_products
        WHERE '.$conditions, $conditionsValues);*/
    }
    
    function diplayPrice($price){
        return number_format(floatval($price), 2,',',' ');
    }
    
    
    
}
