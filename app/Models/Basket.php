<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\BasketItem;

class Basket
{
    private $hash;
    public $id;
    public $valueNet = 0.00;
    public $valueGross = 0.00;
    public $itemsCount = 0;
    public $createdAt;
    public $basketItems = [];
    public $cosmeticsCout = 0;
    public $cosmeticsValueGross = 0.00;
    public $medicamentsCount = 0;
    public $medicamentsValueGross = 0.00;
    public $drugsCount = 0;
    
    public $freeDeliveryFromValue = null;
    public $promoDeliveryFromValue = null;
    public $promoNewsletterDeliveryFromValue = null;
    public $defaultOnePurchaseAvailability = null;
    
    function __construct($hash) {
        if ($hash != null && $hash != '' && strlen($hash) > 5){
            $hash = preg_replace("/[^A-Za-z0-9 ]/", '', $hash);
            $this->hash = $hash;
            $existBasket = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_basket WHERE basketIdentity = ?', [$hash]);
            if (count($existBasket) > 0){
                $this->id = $existBasket[0]->id;
                $this->valueNet = $existBasket[0]->valueNet;
                $this->valueGross = $existBasket[0]->valueGross;
                $this->itemsCount = $existBasket[0]->itemsCount;
                $this->createdAt = $existBasket[0]->createdAt;
                
                
                $existBasketItems = DB::connection('mysql-esklep')->select('SELECT id FROM ecommerce_basket_position WHERE basket_id = ?', [$this->id]);
                
                foreach ($existBasketItems as $item){
                    $loadItem = new BasketItem;
                    $loadItem->loadItemById($item->id);
                    $this->basketItems[] = $loadItem;
                }

            } else {
                
                
                DB::connection('mysql-esklep')->insert('INSERT INTO ecommerce_basket (basketIdentity, valueNet, valueGross, itemsCount, createdAt, updatedAt)'
                    . ' VALUES (?,?,?,?,?,?)', [$this->hash,0.00,0.00,0,Date('y-m-d H:i:s'),Date('y-m-d H:i:s')]);
                
                $existBasket = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_basket WHERE basketIdentity = ?', [$this->hash]);
                $this->id = $existBasket[0]->id;
            }
            
            $this->calculateCosmetics();
        } else {
            $this->hash = $this->generateHash();
            DB::connection('mysql-esklep')->insert('INSERT INTO ecommerce_basket (basketIdentity, valueNet, valueGross, itemsCount, createdAt, updatedAt)'
                    . ' VALUES (?,?,?,?,?,?)', [$this->hash,0.00,0.00,0,Date('y-m-d H:i:s'),Date('y-m-d H:i:s')]);
            
            $existBasket = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_basket WHERE basketIdentity = ?', [$this->hash]);
            $this->id = $existBasket[0]->id;
        }
        
        $basketSettings = DB::connection('mysql-esklep')->select('SELECT code, value FROM settings WHERE code = ? OR code = ? OR code = ? OR code = ?', 
                ['free_delivery_from_value','promo_delivery_from_value','promo_newsletter_delivery_from_value','default_one_purchase_availability']);
        
        foreach ($basketSettings as $setting){
            if ($setting->code === 'free_delivery_from_value'){
                $this->freeDeliveryFromValue = $setting->value;
            }
            if ($setting->code === 'promo_delivery_from_value'){
                $this->promoDeliveryFromValue = $setting->value;
            }
            if ($setting->code === 'promo_newsletter_delivery_from_value'){
                $this->promoNewsletterDeliveryFromValue = $setting->value;
            }
            if ($setting->code === 'default_one_purchase_availability'){
                $this->defaultOnePurchaseAvailability = $setting->value;
            }
        }

    }
    
    private function generateHash(){
        do {
            $hash = Str::random(23);
            $hash = preg_replace("/[^A-Za-z0-9 ]/", '', $hash);
            $existHash = DB::connection('mysql-esklep')->select('SELECT basketIdentity FROM ecommerce_basket WHERE basketIdentity = ?', [$hash]);
        } while (count($existHash) > 0);

        return $hash;
    }
    
    public function getHash(){
        return $this->hash;
    }
    
    public function removeItemById($itemId){
        $response = [
            'status' => true,
            'errors' => [],
            'errorCode' => ''
        ];
        
        
        $findedItem = false;
        foreach ($this->basketItems as $i => $item){ //update existing item
            if ($item->id == $itemId){
                $findedItem = true;
                DB::connection('mysql-esklep')->delete('DELETE FROM ecommerce_basket_position WHERE id = ?;',[$item->id]);
                unset($this->basketItems[$i]);
                break;
            }
        }
        if ($findedItem){
            $response['status'] = true;
        } else {
            $response['errors'][] = 'Nie istanieje taka pozycja koszyka';
        }
        
        $this->recalculateBasket();
        
        return $response;
    }
    
    public function addItemById($productId, $quantity, $changeQuantity = false){
        $response = [
            'status' => true,
            'errors' => [],
            'errorCode' => ''
        ];
        
        $quantity = intVal($quantity);
        
        $product = DB::connection('mysql-esklep')->select('SELECT id, price, availability, one_purchase_availability, price_gross, vat_rate FROM ecommerce_products WHERE id = ?', [$productId]);
        if (count($product) > 0){
            //var_dump($product[0]->availability);
            if ($product[0]->availability > 0){
                if ($quantity <= $product[0]->availability){
                    if ($quantity <= $product[0]->one_purchase_availability || $product[0]->one_purchase_availability < 0){
                        $productAlreadyExistInBasket = false;
                        foreach ($this->basketItems as $item){ //update existing item
                            if ($item->productId == $productId){
                                $productAlreadyExistInBasket = true;
                                if ((!$changeQuantity && intVal($item->quantity) + $quantity > 0) || ($changeQuantity && $quantity > 0)){
                                    if (intVal($item->quantity) + $quantity <= $product[0]->availability || ($changeQuantity && $quantity <= $product[0]->availability)){
                                        if ($product[0]->one_purchase_availability < 0 || intVal($item->quantity) + $quantity <= $product[0]->one_purchase_availability || ($changeQuantity && $quantity <= $product[0]->one_purchase_availability)){
                                            if ($changeQuantity){
                                                $item->quantity = $quantity;
                                            } else {
                                                $item->quantity = intVal($item->quantity) + $quantity;
                                            }

                                            $item->valueNet = $item->quantity*$item->priceNet;
                                            $item->valueGross = $item->quantity*$item->priceGross;

                                            $updateItemDb = DB::connection('mysql-esklep')->update('UPDATE ecommerce_basket_position SET quantity=?, valueNet=?, valueGross=? WHERE id=?', 
                                                        [$item->quantity, $item->valueNet, $item->valueGross, $item->id]);
                                        } else { // przekroczony limit jednorazowego zakupu
                                           if ($item->quantity < $product[0]->one_purchase_availability){ // 
                                                $response['status'] = false;
                                                $response['errors'][] = 'Nie można dodać: ' . $quantity  . ' sztuk produktu do koszyka. Ustalono limit zakupu: <strong>' . $product[0]->one_purchase_availability . ' sztuk podczas jednorazowego zakupu</strong>. Zmień ilość na maksymalnie: ' . $product[0]->one_purchase_availability - $item->quantity . ', żeby dodać produkt do kowszyka.';
                                            } else {
                                                $response['status'] = false;
                                                $response['errors'][] = 'Nie można dodać produktu do koszyka. Ustalono limit zakupu: <strong>' . $product[0]->one_purchase_availability . ' sztuk podczas jednorazowego zakupu</strong>. W koszyku masz już: ' . $item->quantity . ' sztuk.';
                                            } 
                                        }
                                    } else { // przekroczona dostepnosc na magazynie
                                        if ($item->quantity < $product[0]->availability){ // 
                                            $response['status'] = false;
                                            $response['errors'][] = 'Nie można dodać: ' . $quantity  . ' sztuk produktu do koszyka. W tym momencie dostępnych jest: <strong>' . $product[0]->availability . ' sztuk</strong>. Zmień ilość na maksymalnie: ' . $product[0]->availability - $item->quantity . ', żeby dodać produkt do kowszyka.';
                                        } else {
                                            $response['status'] = false;
                                            $response['errors'][] = 'Nie można dodać produktu do koszyka. W tym momencie dostępnych jest: <strong>' . $product[0]->availability . ' sztuk</strong>. W koszyku masz już: ' . $item->quantity . ' sztuk.';
                                        }
                                    }
                                } else {
                                    $this->removeItemById($item->id);
                                }


                                break;
                            }
                        }

                        if (!$productAlreadyExistInBasket){ //add new item
                            $newItem = new BasketItem();
                            $newItem->productId = $productId;
                            $newItem->quantity = $quantity;
                            $newItem->priceNet = $product[0]->price;
                            $newItem->priceGross = $product[0]->price_gross;
                            $newItem->vatRate = $product[0]->vat_rate;
                            $newItem->valueNet = $quantity * $product[0]->price;
                            $newItem->valueGross = $quantity * $product[0]->price_gross;

                            $this->basketItems[] = $newItem;

                            DB::connection('mysql-esklep')->insert('INSERT INTO ecommerce_basket_position (basket_id, product_id, quantity, priceNet, priceGross, vatRate, valueNet, valueGross)'
                                        . ' VALUES (?,?,?,?,?,?,?,?)', [$this->id,$productId,$quantity,$newItem->priceNet,$newItem->priceGross,$newItem->vatRate,$newItem->valueNet,$newItem->valueGross]);

                        }

                        $this->recalculateBasket();
                        } else {
                            $response['status'] = false;
                            $response['errors'][] = 'Nie można dodać: ' . $quantity  . ' sztuk produktu do koszyka. Ustalono limit zakupu: <strong>' . $product[0]->one_purchase_availability . ' sztuk podczas jednorazowego zakupu</strong>. Zmień ilość na maksymalnie: ' . $product[0]->one_purchase_availability . ', żeby dodać produkt do kowszyka.';
                        }
                } else {
                    $response['status'] = false;
                    $response['errors'][] = 'Nie można dodać: ' . $quantity  . ' sztuk produktu do koszyka. W tym momencie dostępnych jest: <strong>' . $product[0]->availability . ' sztuk</strong>. Zmień ilość na maksymalnie: ' . $product[0]->availability . ', żeby dodać produkt do kowszyka.';
                }
            } else {
                $response['status'] = false;
                $response['errors'][] = 'Produkt wyprzedany, w tym momencie nie ma ani jednej dostępnej sztuki w magazynie'; 
            }
        } else {
            $response['status'] = false;
            $response['errors'][] = 'Produkt nie jest już dostępny w ofercie';
        }
        return $response;
    }
    
    public function recalculateBasket(){
        $valueNet = 0;
        $valueGross = 0;
        $itemsCount = 0;
        
        foreach ($this->basketItems as $item){
            $valueNet = $valueNet + floatval($item->valueNet);
            $valueGross = $valueGross + floatval($item->valueGross);
            $itemsCount++;
        }
        
        $this->$valueNet = $valueNet;
        $this->valueGross = $valueGross;
        $this->itemsCount = $itemsCount;
        
        $updateItemDb = DB::connection('mysql-esklep')->update('UPDATE ecommerce_basket SET valueNet=?, valueGross=?, itemsCount=?, updatedAt=? WHERE id=?', 
                            [$valueNet, $valueGross, $itemsCount, date('Y-m-d H:i:s'), $this->id]);
        
        $this->calculateCosmetics();

    }
    
    private function calculateCosmetics()
    {
        $cosmeticsCout = 0;
        $cosmeticsValueGross = 0.00;
        $medicamentsCount = 0;
        $medicamentsValueGross = 0.00;
        $drugsCount = 0;
        foreach ($this->basketItems as $item){
            if ($item->is_cosmetic == 1){
                $cosmeticsCout++;
                $cosmeticsValueGross = $cosmeticsValueGross + floatval($item->valueGross);
            } else {
                $medicamentsCount++;
                $medicamentsValueGross = $medicamentsValueGross + floatval($item->valueGross);
            }
            
            //var_dump($item->type_of_preparation);
            if ($item->type_of_preparation == 'Lek bez recepty'){
                $drugsCount++;
            }
        }
            
        $this->drugsCount = $drugsCount;
        $this->cosmeticsCout = $cosmeticsCout;
        $this->cosmeticsValueGross = $cosmeticsValueGross;
        $this->medicamentsCount = $medicamentsCount;
        $this->medicamentsValueGross = $medicamentsValueGross;
    }
    
    function diplayPrice($price){
        return number_format(floatval($price), 2,',',' ');
    }
}
