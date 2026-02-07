<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;

class UserAcountController extends Controller
{
    public function __construct()
    {

    }
    

    
    public function showDashboard(Request $request){
        $viewData = [];
        $user = Auth::user();
        
        $userId = Auth::id();
        
        $viewData['userdata'] = AuthController::getUserData($request, Auth::id(), true);
        
        $viewData['globalHelper'] = new globalHelper();
        
        $orders = DB::connection('mysql-esklep')->Select('SELECT * FROM ecommerce_orders  WHERE user_id = ?  ORDER BY order_date DESC', 
                    [Auth::id()]);
        
        $ordersArchive = DB::connection('mysql-esklep')->Select('SELECT * FROM  ecommerce_archive_orders  WHERE user_id = ?  ORDER BY order_date DESC', 
                    [Auth::id()]);
        
        $allOrders = array_merge($orders,$ordersArchive);
        foreach ($allOrders as $i => $order){
            $postions = DB::connection('mysql-esklep')->Select('SELECT ecommerce_order_position.*, image.image_name, ecommerce_products.slug, ecommerce_products.name, ecommerce_products.id, ecommerce_products.brand, ecommerce_products.content '
                    . ' FROM  ecommerce_order_position '
                    . ' LEFT JOIN ecommerce_products ON ecommerce_order_position.product_id = ecommerce_products.id '
                    . ' LEFT JOIN ecommerce_product_images ON ecommerce_product_images.product_id = ecommerce_products.id '
                    . ' LEFT JOIN ecommerce_product_image as image ON ecommerce_product_images.product_image_id = image.id '
                    . ' WHERE ecommerce_order_position.order_id =?', 
                    [$order->id]);
            //var_dump($order->id);
            //var_dump($allOrders[$i]->positions);
            
            if (count($postions) == 0){
                $postions = DB::connection('mysql-esklep')->Select('SELECT ecommerce_archive_order_position.*, image.image_name, ecommerce_products.slug, ecommerce_products.name, ecommerce_products.id, ecommerce_products.brand, ecommerce_products.content '
                    . ' FROM  ecommerce_archive_order_position'
                    . ' LEFT JOIN ecommerce_products ON ecommerce_archive_order_position.product_id = ecommerce_products.id '
                    . ' LEFT JOIN ecommerce_product_images ON ecommerce_product_images.product_id = ecommerce_products.id '
                    . ' LEFT JOIN ecommerce_product_image as image ON ecommerce_product_images.product_image_id = image.id '
                    . 'WHERE ecommerce_archive_order_position.order_id =?', 
                    [$order->id]);
            }
            
            $allOrders[$i]->positions = $postions;
        }
        
        $viewData['allOrders'] = $allOrders;
        
        return view('user-acount.dashboard',$viewData);
    }
    
    public function editUserData(){
        $viewData = [];
        $user = Auth::user();
       
        $userId = Auth::id();
        $viewData['globalHelper'] = new globalHelper();
        
        
        $viewData['userdata'] = Auth::user()->getAttributes();
        
       

        
        return view('user-acount.edit-user-data',$viewData);
    }
    
    public function saveUserData(Request $request){
        
        
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        
        $user = Auth::user();
        if ($user != null){
            $name = '';
            $surname = '';
            $phone = '';
            $street = '';
            $houseNumber = ''; 
            $city = '';
            $zipCode = '';        
                    
                    
            if (isset($request['formdata']['user-data-name']) && !empty($request['formdata']['user-data-name'])){
                $name = $request['formdata']['user-data-name'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Imię jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-name';
            }

            if (isset($request['formdata']['user-data-surname']) && !empty($request['formdata']['user-data-surname'])){
                $surname = $request['formdata']['user-data-surname'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Nazwisko jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-surname';
            }

            if (isset($request['formdata']['user-data-phone']) && !empty($request['formdata']['user-data-phone'])){
                $phone = $request['formdata']['user-data-phone'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Numer telefonu jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-phone';
            }

            if (isset($request['formdata']['user-data-street']) && !empty($request['formdata']['user-data-street'])){
                $street = $request['formdata']['user-data-street'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Ulica jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-street';
            }

            if (isset($request['formdata']['user-data-house-number']) && !empty($request['formdata']['user-data-house-number'])){
                $houseNumber = $request['formdata']['user-data-house-number'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Numer domu / mieszkania jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-house-number';
            }

            if (isset($request['formdata']['user-data-city']) && !empty($request['formdata']['user-data-city'])){
                $city = $request['formdata']['user-data-city'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Miasto jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-city';
            }

            if (isset($request['formdata']['user-data-zipcode']) && !empty($request['formdata']['user-data-zipcode'])){
                $zipCode = $request['formdata']['user-data-zipcode'];
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Kod pocztowy jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'user-data-form-zipcode';
            }

            if ($returnData['status']){
                DB::connection('mysql-esklep')->update('UPDATE fos_user SET first_name = ? , last_name = ? WHERE id = ?', 
                    [$name,$surname,Auth::id()]);
                
                $user = DB::connection('mysql-esklep')->Select('SELECT shipping_address_id FROM fos_user  WHERE id = ?', 
                    [Auth::id()]);
                if (count($user) > 0 && $user[0]->shipping_address_id != null){
                    DB::connection('mysql-esklep')->update('UPDATE fos_user_shipping_address SET firstName = ? , lastName = ?, street=?, house_number = ?, city = ?, phoneNumber = ?, zipCode = ?  WHERE id = ?', 
                        [$name,$surname,$street,$houseNumber,$city,$phone,$zipCode,$user[0]->shipping_address_id]);
                } else {
                    DB::connection('mysql-esklep')->insert('INSERT INTO fos_user_shipping_address '
                        . '(firstName, lastName, street, house_number, city, zipCode, phoneNumber, state)'
                        . ' VALUES (?,?,?,?,?,?,?,?)', 
                        [$name,$surname,$street,$houseNumber,$city,$zipCode,$phone,'']);
                }
            }
        }
        
        
        return \Response::json($returnData, 200);
    }
    
    
}
