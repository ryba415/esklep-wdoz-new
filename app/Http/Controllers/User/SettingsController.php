<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\globalHelper\globalHelper;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function __construct()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        } else {

        }
    }

    
    public function setSettings(){
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => null,
            'name' => 'Ustawienia'
        ];
        
        $user = Auth::user();

        $userId = Auth::id();

        $dbUser = DB::select('select email, name, surname, pro_user_for, invoice_comapny, invoice_street, invoice_postcode, invoice_city, invoice_nip, street, postcode, city'
                . ' FROM users where id=?', [$userId]);
        
        $viewData['isPro'] = false;
        if (Auth::user()->isPro()){
            $viewData['isPro'] = true;
        }
                
                
        $viewData['user'] = $dbUser[0];
        return view('settings.settings-form',$viewData);
        
    }
    
    public function saveUserData(Request $request){
        $response = [
            'status' => true,
            'errors' => [],
            'errorsAreas' => [],
            'paymentUrl' => ''
        ];
        
        $user = Auth::user();
        $userId = Auth::id();

        $dbUser = DB::select('select email, name, surname, invoice_comapny, invoice_street, invoice_postcode, invoice_city, invoice_nip FROM users where id=?', [$userId]);
        
        if (count($dbUser)> 0){


            $request = $request->all();
            $formData = json_decode($request["data"],true);

            $helper = new globalHelper();

            $name = $helper->saveDbText($formData["user_name"]);
            if ($name == null || $name == ''){
                $response['status'] = false;
                $response['errors'][] = 'Imię jest polem obowiązkowym';
                $response['errorsAreas'][] = 'user_name';
            }

            $surname = $helper->saveDbText($formData["user_surname"]);
            if ($surname == null || $surname == ''){
                $response['status'] = false;
                $response['errors'][] = 'Nazwisko jest polem obowiązkowym';
                $response['errorsAreas'][] = 'user_surname';
            }
            
            $street = $helper->saveDbText($formData["user_street"]);
            if ($street == null || $street == ''){
                $response['status'] = false;
                $response['errors'][] = 'Ulica jest polem obowiązkowym';
                $response['errorsAreas'][] = 'user_street';
            }
            
            $postcode = $helper->saveDbText($formData["user_postcode"]);
            if ($postcode == null || $postcode == ''){
                $response['status'] = false;
                $response['errors'][] = 'Kod pocztowy jest polem obowiązkowym';
                $response['errorsAreas'][] = 'user_postcode';
            }
            
            $city = $helper->saveDbText($formData["user_city"]);
            if ($city == null || $city == ''){
                $response['status'] = false;
                $response['errors'][] = 'Miasto jest polem obowiązkowym';
                $response['errorsAreas'][] = 'user_city';
            }

            $invoiceComapny = $helper->saveDbText($formData["invoice_comapny"]);
            $invoiceStreet = $helper->saveDbText($formData["invoice_street"]);
            $invoicePostcode = $helper->saveDbText($formData["invoice_postcode"]);
            $invoiceCity = $helper->saveDbText($formData["invoice_city"]);
            $invoiceNip = $helper->saveDbText($formData["invoice_nip"]);

            if ($response['status']){
                $dbUserUpdate = DB::update('UPDATE users SET name=?, surname=? , street=?, postcode=?, city=? WHERE id=?', [$name, $surname, $street, $postcode, $city, $userId]);
                
                $dbUserUpdate = DB::update('UPDATE users SET invoice_comapny=?, invoice_street=?, invoice_postcode=?, invoice_city=?, invoice_nip=? WHERE id=?', 
                            [$invoiceComapny, $invoiceStreet, $invoicePostcode, $invoiceCity, $invoiceNip, $userId]);

            }
            
            
        } else {
            $response['status'] = false;
            $response['errors'][] = 'Aby dokonać zmiany ustawień musisz być zalogowany';
        }

        return response()->json($response);
    }
    
    public function updatePassword(Request $request){
        $response = [
            'status' => true,
            'errors' => [],
            'errorsAreas' => [],
            'paymentUrl' => ''
        ];
        
        $user = Auth::user();
        $userId = Auth::id();

        $dbUser = DB::select('select email, name, surname, invoice_comapny, invoice_street, invoice_postcode, invoice_city, invoice_nip FROM users where id=?', [$userId]);
        
        if (count($dbUser)> 0){


            $request = $request->all();
            $formData = json_decode($request["data"],true);

            $helper = new globalHelper();

            $newPasswored = $helper->saveDbText($formData["new_passwored"]);
            if ($newPasswored == null || $newPasswored == ''){
                $response['status'] = false;
                $response['errors'][] = 'Wprowadź nowe hasło - pole nie może być puste';
                $response['errorsAreas'][] = 'new_passwored';
            }
            
            if (strlen($newPasswored) < 8){
                $response['status'] = false;
                $response['errors'][] = 'Hasło musi mieć conajmniej 8 znaków';
                $response['errorsAreas'][] = 'new_passwored';
            }

            $newPassworedRepeat = $helper->saveDbText($formData["new_passwored_repeat"]);
            
            if ($newPassworedRepeat == null || $newPassworedRepeat == ''){
                $response['status'] = false;
                $response['errors'][] = 'Powtórz hasło - pole nie może być puste';
                $response['errorsAreas'][] = 'new_passwored_repeat';
            }
            
            if ($newPasswored != $newPassworedRepeat){
                $response['status'] = false;
                $response['errors'][] = 'Podane hasła są różne';
                $response['errorsAreas'][] = 'new_passwored_repeat';
            }

            if ($response['status']){
                $dbUserUpdate = DB::update('UPDATE users SET password=?, reset_password_date=? WHERE id=?', 
                            [Hash::make($newPasswored), null, $userId]);

            }
            
            
        } else {
            $response['status'] = false;
            $response['errors'][] = 'Aby dokonać zmiany hasła musisz być zalogowany';
        }

        return response()->json($response);
    }

}
