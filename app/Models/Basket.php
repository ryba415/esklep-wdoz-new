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


    public function removeItemByProductVariant($productId, $expirationDate = null)
    {
        $response = [
            'status' => true,
            'errors' => [],
            'errorCode' => ''
        ];

        $productId = intval($productId);
        $expirationDate = $this->normalizeExpirationDate($expirationDate);

        $found = false;

        foreach ($this->basketItems as $i => $item) {
            $itemExp = $this->normalizeExpirationDate($item->expiration_date ?? null);

            $sameVariant = (intval($item->productId) === $productId) && ($itemExp === $expirationDate);

            if ($sameVariant) {
                $found = true;

                DB::connection('mysql-esklep')->delete(
                    'DELETE FROM ecommerce_basket_position WHERE id = ?;',
                    [$item->id]
                );

                unset($this->basketItems[$i]);
                break;
            }
        }

        if (!$found) {
            $response['status'] = false;
            $response['errors'][] = 'Nie istnieje taka pozycja koszyka (wariant produktu).';
            return $response;
        }

        $this->recalculateBasket();
        return $response;
    }


    private function normalizeExpirationDate($value)
    {
        if ($value === null) return null;

        $v = trim((string)$value);
        if ($v === '') return null;

        $lv = strtolower($v);
        if ($lv === 'null' || $lv === 'undefined' || $lv === 'none') return null;

        if ($v === '0000-00-00') return null;

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
            return null;
        }

        return $v;
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
    
    
    public function addItemById($productId, $quantity, $changeQuantity = false, $expirationDate = null)
    {
        $response = [
            'status' => true,
            'errors' => [],
            'errorCode' => ''
        ];

        $productId = intval($productId);
        $quantity  = intval($quantity);

        if ($expirationDate !== null) {
            $expirationDate = trim((string)$expirationDate);
            if ($expirationDate === '' || strtolower($expirationDate) === 'null' || strtolower($expirationDate) === 'undefined') {
                $expirationDate = null;
            }
            if ($expirationDate === '0000-00-00') {
                $expirationDate = null;
            }
        }

        $isShort = ($expirationDate !== null);

        $product = DB::connection('mysql-esklep')->select(
            'SELECT id,
                    price, price_gross, vat_rate,
                    availability, one_purchase_availability,
                    short_expiration_stock, short_expiration_date,
                    short_price_net, short_price_gross
            FROM ecommerce_products
            WHERE id = ?',
            [$productId]
        );

        if (count($product) <= 0) {
            $response['status'] = false;
            $response['errors'][] = 'Produkt nie jest już dostępny w ofercie';
            return $response;
        }

        $p = $product[0];

        if ($isShort) {
            $shortDate = $p->short_expiration_date;
            if ($shortDate !== null) {
                $shortDate = trim((string)$shortDate);
                if ($shortDate === '' || $shortDate === '0000-00-00') $shortDate = null;
            }

            if ($shortDate === null || $shortDate !== $expirationDate) {
                $response['status'] = false;
                $response['errors'][] = 'Nieprawidłowa data ważności dla produktu z krótką datą.';
                return $response;
            }

            $availableStock = intval($p->short_expiration_stock);
            $priceNet       = floatval($p->short_price_net);
            $priceGross     = floatval($p->short_price_gross);
        } else {
            $availableStock = intval($p->availability);
            $priceNet       = floatval($p->price);
            $priceGross     = floatval($p->price_gross);
        }

        if ($availableStock <= 0) {
            $response['status'] = false;
            $response['errors'][] = $isShort
                ? 'Produkt z krótką datą jest wyprzedany.'
                : 'Produkt wyprzedany, w tym momencie nie ma ani jednej dostępnej sztuki w magazynie';
            return $response;
        }

        if ($quantity <= 0) {
            $response['status'] = false;
            $response['errors'][] = 'Nieprawidłowa ilość produktu.';
            return $response;
        }

        if ($quantity > $availableStock) {
            $response['status'] = false;
            $response['errors'][] =
                'Nie można dodać: ' . $quantity . ' sztuk produktu do koszyka. W tym momencie dostępnych jest: <strong>'
                . $availableStock . ' sztuk</strong>. Zmień ilość na maksymalnie: ' . $availableStock . ', żeby dodać produkt do koszyka.';
            return $response;
        }

        $onePurchase = intval($p->one_purchase_availability);
        if (!($quantity <= $onePurchase || $onePurchase < 0)) {
            $response['status'] = false;
            $response['errors'][] =
                'Nie można dodać: ' . $quantity . ' sztuk produktu do koszyka. Ustalono limit zakupu: <strong>'
                . $onePurchase . ' sztuk podczas jednorazowego zakupu</strong>. Zmień ilość na maksymalnie: '
                . $onePurchase . ', żeby dodać produkt do koszyka.';
            return $response;
        }

        $existing = DB::connection('mysql-esklep')->select(
            'SELECT id, quantity
            FROM ecommerce_basket_position
            WHERE basket_id = ?
            AND product_id = ?
            AND (expiration_date <=> ?)
            LIMIT 1',
            [$this->id, $productId, $expirationDate]
        );

        if (count($existing) > 0) {
            $posId      = intval($existing[0]->id);
            $currentQty = intval($existing[0]->quantity);
            $newQty     = $changeQuantity ? $quantity : ($currentQty + $quantity);

            if ($newQty <= 0) {
                DB::connection('mysql-esklep')->delete('DELETE FROM ecommerce_basket_position WHERE id = ?', [$posId]);

                foreach ($this->basketItems as $i => $it) {
                    if (intval($it->id) === $posId) {
                        unset($this->basketItems[$i]);
                        break;
                    }
                }

                $this->recalculateBasket();
                return $response;
            }

            if ($newQty > $availableStock) {
                $response['status'] = false;
                $response['errors'][] =
                    'Nie można dodać produktu do koszyka. W tym momencie dostępnych jest: <strong>'
                    . $availableStock . ' sztuk</strong>. W koszyku masz już: ' . $currentQty . ' sztuk.';
                return $response;
            }

            if (!($onePurchase < 0 || $newQty <= $onePurchase)) {
                $response['status'] = false;
                $response['errors'][] =
                    'Nie można dodać produktu do koszyka. Ustalono limit zakupu: <strong>'
                    . $onePurchase . ' sztuk podczas jednorazowego zakupu</strong>. W koszyku masz już: '
                    . $currentQty . ' sztuk.';
                return $response;
            }

            $valueNet   = $newQty * $priceNet;
            $valueGross = $newQty * $priceGross;

            DB::connection('mysql-esklep')->update(
                'UPDATE ecommerce_basket_position
                SET quantity=?, priceNet=?, priceGross=?, valueNet=?, valueGross=?
                WHERE id=?',
                [$newQty, $priceNet, $priceGross, $valueNet, $valueGross, $posId]
            );

            foreach ($this->basketItems as $it) {
                if (intval($it->id) === $posId) {
                    $it->quantity   = $newQty;
                    $it->priceNet   = $priceNet;
                    $it->priceGross = $priceGross;
                    $it->valueNet   = $valueNet;
                    $it->valueGross = $valueGross;
                    $it->expiration_date = $expirationDate;
                    break;
                }
            }
        } else {
            $valueNet   = $quantity * $priceNet;
            $valueGross = $quantity * $priceGross;

            DB::connection('mysql-esklep')->insert(
                'INSERT INTO ecommerce_basket_position
                (basket_id, product_id, quantity, priceNet, priceGross, vatRate, valueNet, valueGross, expiration_date)
                VALUES (?,?,?,?,?,?,?,?,
                    CASE
                    WHEN ? IS NULL THEN NULL
                    ELSE STR_TO_DATE(?, "%Y-%m-%d")
                    END
                )',
                [$this->id, $productId, $quantity, $priceNet, $priceGross, $p->vat_rate, $valueNet, $valueGross, $expirationDate, $expirationDate]
            );

            $newId = DB::connection('mysql-esklep')->getPdo()->lastInsertId();

            $newItem = new BasketItem();
            $newItem->id = $newId;
            $newItem->productId = $productId;
            $newItem->quantity = $quantity;
            $newItem->priceNet = $priceNet;
            $newItem->priceGross = $priceGross;
            $newItem->vatRate = $p->vat_rate;
            $newItem->valueNet = $valueNet;
            $newItem->valueGross = $valueGross;
            $newItem->expiration_date = $expirationDate;

            $this->basketItems[] = $newItem;
        }

        $this->recalculateBasket();
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
        
        $this->valueNet = $valueNet;
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
