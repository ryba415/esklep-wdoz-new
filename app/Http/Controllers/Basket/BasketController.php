<?php

namespace App\Http\Controllers\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;
use Config;
use App\Models\Basket;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Auth;

class BasketController extends Controller
{

    
    public function showBasket(Request $request){
        
       // var_dump(Auth::check('auth:usercustom'));
        //echo '<pre>';
        //var_dump(Auth::user()->getAttributes());die();
        
        $requestParams = $request->all();
        $viewData = [];
        
        if (Auth::user() == null){
            $viewData['isLoggedUser'] = false;
            $viewData['userdata'] = null;
        } else {
            $viewData['isLoggedUser'] = true;
            $viewData['userdata'] = Auth::user()->getAttributes();
        }
        
        if (isset($requestParams['go-to-step'])){
            $viewData['goToStep'] = intval($requestParams['go-to-step']);
        } else {
            $viewData['goToStep'] = null;
        }
        
        if (isset($requestParams['newsletterAgree']) && $requestParams['newsletterAgree'] == 1){
            $viewData['newsletterSetAgree'] = 1;
        } else {
            $viewData['newsletterSetAgree'] = 0;
        }
        
        if (isset($requestParams['sumbitBuy']) && $requestParams['sumbitBuy'] == 1){
            $viewData['sumbitBuy'] = 1;
        } else {
            $viewData['sumbitBuy'] = 0;
        }
        
        
        
        //
        
       // var_dump($this->middleware('auth:usercustom'));die();
        
        
        $basket = null;
        if (isset($requestParams['basket-identifier']) && $requestParams['basket-identifier'] != null && $requestParams['basket-identifier'] != ''){
            $basket = new Basket($request['basket-identifier']);
        } else {
            if (isset($_COOKIE['basket-identifier']) && $_COOKIE['basket-identifier'] != null && $_COOKIE['basket-identifier'] != ''){
                $basket = new Basket($_COOKIE['basket-identifier']);
            }
        }
        
        if ($basket == null){
            $basket = new Basket(null);
        }
        setcookie('basket-identifier',$basket->getHash(),time()+10*3600*30,'/');
        
        $viewData['basket'] = $basket;
        
        /*if ($basket->medicamentsCount > 0){
            if ($_SERVER['SERVER_NAME'] != Config::get('constants.apteka_domin')){
                if (Config::get('constants.use_ssl')){
                    $prarmacyUrl = 'https://' . Config::get('constants.apteka_domin') . '/koszyk?basket-identifier=' . $basket->getHash();
                } else {
                    $prarmacyUrl = 'http://' . Config::get('constants.apteka_domin') . '/koszyk?basket-identifier=' . $basket->getHash();
                }
                header("Location: " .  $prarmacyUrl);
            }
        } else {
            if ($_SERVER['SERVER_NAME'] != Config::get('constants.drogeria_domain')){
                if (Config::get('constants.use_ssl')){
                    $prarmacyUrl = 'https://' . Config::get('constants.drogeria_domain') . '/koszyk?basket-identifier=' . $basket->getHash();
                } else {
                    $prarmacyUrl = 'http://' . Config::get('constants.drogeria_domain') . '/koszyk?basket-identifier=' . $basket->getHash();
                }
                header("Location: " .  $prarmacyUrl);
            }
        }*/
        
        $medicamentsInBasket = false;
        $pharmacyItemsInBasket = false;
        $drogeryItemsInBasket = false;
        foreach ($basket->basketItems as $i => $item){ 
            if ($item->type_of_preparation == 'Lek bez recepty'){
                $medicamentsInBasket = 'true';
                
            }
            if ($item->is_cosmetic != 1){
                $pharmacyItemsInBasket = true;
            } else {
                $drogeryItemsInBasket = true;
            }
        }
        $viewData['pharmacyItemsInBasket'] = $pharmacyItemsInBasket;
        $viewData['drogeryItemsInBasket'] = $drogeryItemsInBasket;
        $viewData['medicamentsInBasket'] = $medicamentsInBasket;
        
        $deliveryMethods = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_delivery_method ORDER BY display_order', []);
        
        if (Config::get('constants.use_ssl')){
            $shopUrl = 'https://' . Config::get('constants.shop_domain');
        } else {
            $shopUrl = 'http://' . Config::get('constants.shop_domain');
        }
        $viewData['deliveryMethods'] = $deliveryMethods;
        
        $savedData = DB::connection('mysql-esklep')->select('SELECT id, basket_id FROM ecommerce_basket_data WHERE basket_id = ?', [$basket->id]);
        $viewData['existSavedData'] = false;
        if (count($savedData) > 0){
            $viewData['savedData'] = $savedData;
            $viewData['existSavedData'] = true;
        }

        return view('basket/basket',$viewData);
    }
    
    private function get_web_page( $url )
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(

            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }
    
    public function thankYouPage(Request $request){
        $requestParams = $request->all();
        $viewData = [];
        
        $findedOrder = false;
        if (isset($request['orderIdentity'])){
            $orderIdentity = preg_replace("/[^A-Za-z0-9 ]/", '', $request['orderIdentity']);

            $order = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_orders WHERE identity = ?', [$orderIdentity]);
            
            if (count($order) > 0){
                $findedOrder = true;
                $viewData['order'] = $order[0];
            }
        }
        
        $viewData['findedOrder'] = $findedOrder;

        return view('basket/thank-you-page',$viewData);
    }
    
    public function showPharmacyConfirmation(Request $request){
        
        $requestParams = $request->all();
        
        if (isset($requestParams['basket-identifier'])){
            $viewData = [];
            $basketIdentifier = $requestParams['basket-identifier'];
            $basket = new Basket($request['basket-identifier']);
            
            //echo '<pre>';
            //var_dump($basket); die();
            
            $medicamentsInBasket = false;
            $pharmacyItemsInBasket = false;
            $drogeryItemsInBasket = false;
            foreach ($basket->basketItems as $i => $item){ 
                if ($item->type_of_preparation == 'Lek bez recepty'){
                    $medicamentsInBasket = 'true';

                }
                if ($item->is_cosmetic != 1){
                    $pharmacyItemsInBasket = true;
                } else {
                    $drogeryItemsInBasket = true;
                }
            }
            $deliveryPrice = 20;
            if (isset($requestParams['d'])){
                $deliveryPrice = floatval($requestParams['d']);
            }
            
            if (isset($requestParams['summary'])){
                $summaryData = json_decode($requestParams['summary'], true);
            } else {
                $summaryData = [
                    'p' => '',
                    'i' => '',
                    'd' => '',
                    'm' => '',
                ];
            }
            //echo '<pre>';
            //var_dump($requestParams['d']);var_dump($deliveryPrice);die();
            $viewData['summaryData'] = $summaryData;
            $viewData['deliveryPrice'] = $deliveryPrice;
            $viewData['pharmacyItemsInBasket'] = $pharmacyItemsInBasket;
            $viewData['drogeryItemsInBasket'] = $drogeryItemsInBasket;
            $viewData['medicamentsInBasket'] = $medicamentsInBasket;
            
            
            $viewData['isLoggedUser'] = false;
            $viewData['goToStep'] = null;
            
            
            $viewData['basket'] = $basket;
            return view('basket/basket-pharmacy-confirmation',$viewData);
        } else {
            echo 'Wystąpił wewnętrzny błąd, nie można zidentyfikować koszyka. ';
        }
        
        
        
    }
    
}
