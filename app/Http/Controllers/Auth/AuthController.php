<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Email;
use Symfony\Component\HttpFoundation\JsonResponse;
use Config;
use \stdClass;


class AuthController extends Controller
{
    public function login(Request $request){       
        $requestData = $request->all();
        
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];

  
        $credentials=[
            'email' => $requestData['email'],
            'password' => $requestData['password']
        ];
        $user = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE username_canonical = ?', [$requestData['email']]);
        if (count($user) > 0){
            if ($user[0]->enabled == 0){
                $returnData["status"] = false;
                $returnData["errors"][] = 'Użytkownik nie został aktywowany. Na Twój adres e-mail została wysłana wiadomość z linkiem aktywacyjnym. Jeżeli nie możesz odnależć e-maila aktywacyjnego sprawdź folder spam lub <a target="blank" href="/repeat-send-activate-user-email/'.$requestData['email'].'" style="color:#38900D">wyślij ponownie e-mail aktywacyjny.</a>';
            }
        }

        if ($returnData["status"]){
            if (Auth::guard('usercustom')->attempt($credentials)){
                $request->session()->regenerate();
                if (Auth::user() !== null){ 
                    $userData = Auth::user()->getAttributes();
                    $returnData['userId'] = $userData['id'];
                }
                $returnData["status"] = true;
            }else {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $returnData["status"] = false;
                $returnData["errors"][] = 'Błędny login i/lub hasło';
            }
        }
        
        $jsonResponse = new JsonResponse($returnData);

        return $jsonResponse;
    }
    
    public function registerNewUer(Request $request){
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        $email = '';
        $password = '';
        $passwordRepeat = '';
        $acceptRules = '';
        $acceptCookies = '';
        $acceptNewsletter = '';
        
        if (isset($request['email'])){
            $email = $request['email'];
        }
        if (isset($request['password'])){
            $password = $request['password'];
        }
        if (isset($request['passwordRepeat'])){
            $passwordRepeat = $request['passwordRepeat'];
        }
        if (isset($request['acceptRules'])){
            $acceptRules = $request['acceptRules'];
        }
        if (isset($request['acceptCookies'])){
            $acceptCookies = $request['acceptCookies'];
        }
        if (isset($request['acceptNewsletter'])){
            $acceptNewsletter = $request['acceptNewsletter'];
        }
        
        if ($email == ''){
            $returnData['errors'][] = 'Adres e-mail jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'checkout-register-email';
            $returnData['status'] = false;
        } elseif (!str_contains($email,'@') || !str_contains($email,'.')){
            $returnData['errors'][] = 'Adres e-mail ma niewłaściwy format';
            $returnData['errorsAreas'][] = 'checkout-register-email';
            $returnData['status'] = false;
        }
        
        $user = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE username_canonical = ? OR username = ? OR email = ?', [$email,$email,$email]);
        
        if (count($user)>0){
            $returnData['errors'][] = 'Użytkownik z takim adresem e-mail już istnieje';
            $returnData['errorsAreas'][] = 'checkout-register-email';
            $returnData['status'] = false;
        }
        
        if ($password == ''){
            $returnData['errors'][] = 'Hasło jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'checkout-register-passwordd';
            $returnData['status'] = false;
        }
        if (strlen($password) < 7 ){
            $returnData['errors'][] = 'Hasło musi miec conajmniej 7 znaków';
            $returnData['errorsAreas'][] = 'checkout-register-password';
            $returnData['status'] = false;
        }
        if (strlen(preg_replace('/[^A-Z]/','', $password)) < 1 ){
            $returnData['errors'][] = 'Hasło musi miec conajmniej jedną wielką literę';
            $returnData['errorsAreas'][] = 'checkout-register-password';
            $returnData['status'] = false;
        }
        if (strlen(preg_replace('/[^a-z]/','', $password)) < 1 ){
            $returnData['errors'][] = 'Hasło musi miec conajmniej jedną małą literę';
            $returnData['errorsAreas'][] = 'checkout-register-password';
            $returnData['status'] = false;
        }
        if ($password !== $passwordRepeat){
            $returnData['errors'][] = 'Hasło i powtórzenie hasła różnią się';
            $returnData['errorsAreas'][] = 'checkout-register-password-repeat';
            $returnData['status'] = false;
        }
        
        if ($acceptRules != 1){
            $returnData['errors'][] = 'Akceptacja regulaminu jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'register-accept-rules1';
            $returnData['status'] = false;
        }
        
        if ($acceptCookies != 1){
            $returnData['errors'][] = 'Akceptacja polityki prywatności jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'register-accept-rules2';
            $returnData['status'] = false;
        }
        
        
        
        if ($returnData['status']){
            
            $salt = $this->generateRandomString(35);
            $confirmationToken = $this->generateRandomString(45);
            $salted = $password . "{" . $salt  . "}";
            $digiest = hash('sha512', $salted, true);


            for ($i=1; $i<5000; $i++){
              $digiest = hash('sha512', $digiest.$salted, true);
            }

            $hash = base64_encode($digiest);
            
            
            
            DB::connection('mysql-esklep')->insert('INSERT INTO fos_user '
                . '(username, username_canonical, email, email_canonical, enabled, salt, password, locked, expired, confirmation_token, roles, credentials_expired)'
                . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?)', 
                [$email,$email,$email,$email,0,$salt,$hash,0,0,$confirmationToken,'a:0:{}',0]);
            
            $this->sendActivateUserEmail($email);
            
            if ($acceptNewsletter == 1){
                $userNewsletter = DB::connection('mysql-esklep')->select('SELECT * FROM newsletter WHERE email = ? ', [$email]);
                if (count($userNewsletter) > 0){
                    DB::connection('mysql-esklep')->update('UPDATE newsletter SET is_agree = 1, updated = ? WHERE email = ?', 
                                [date('Y-m-d H:i:s'),$email]);
                } else {
                    DB::connection('mysql-esklep')->insert('INSERT INTO newsletter '
                        . '(email, created, updated, is_agree )'
                        . ' VALUES (?,?,?,?)', 
                        [$email,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),1]);
                }
            }
        }
        
        return \Response::json($returnData, 200);
    }
    
    public function activateUserAcount($hash){
        $user = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE confirmation_token = ? AND enabled = 0', [$hash]);
        
        $viewdata = [];
        $message = '';
        $status = false;
        if (count($user) > 0){
            $updateUser = DB::connection('mysql-esklep')->update('UPDATE fos_user SET enabled = 1 WHERE id=?', 
                                [$user[0]->id]);
            $status = true;
            $message = 'Użytkownik aktywowany pomyślnie.';
        } else {
            $status = false;
            $message = 'Nie można aktywować użytkownika. Użytkownik został już aktywowany wcześniej lub nie istnieje.';
        }
        
        $viewdata['message'] = $message;
        $viewdata['status'] = $status;
        
        return view('auth.user-activate',$viewdata);
    }
    
    public function resendActivateUserEmail($email){
        if ($this->sendActivateUserEmail($email)){
            echo 'e-mail aktywacyjny ponownie wysłany';
        } else {
            echo 'nie można wysłac ponownie e-maila aktywacyjnego';
        }
    }
    
    public function sendActivateUserEmail($email){
        $user = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE username_canonical = ?', [$email]);
        if (count($user) > 0){
            if ($user[0]->enabled == 0){
                $emailVariables = [];
                $activateLink = 'https://' . $_SERVER['SERVER_NAME'] . '/activate-acount/' . $user[0]->confirmation_token;
                $emailVariables['activateLink'] = $activateLink;
                $emailsArray = [$user[0]->email];
                $email = new Email($emailsArray, 'Aktywacja konta - ' . Config::get('constants.shop_name'), 'emails/activate-acount-mail', $emailVariables);
                $email->send();
                return true;
            }
        }
        
        return false;
    }
    
    private function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
    
    public static function getUserData(Request $request, $id, $getArray = false){
        $request = $request->all();
        
        $returnData = [
            "status" => false,
            "errors" => [],
            "errorsAreas" => [],
            "deliveryAdressFinded" => false,
            "deliveryAdress" => null
        ];
        
        if (Auth::user() !== null){ 
            $returnData['userData'] = Auth::user()->getAttributes();
            if ($returnData['userData']['shipping_address_id'] != null){
                $deliveryAdress = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user_shipping_address WHERE id = ?', [$returnData['userData']['shipping_address_id']]);
                if (count($deliveryAdress) > 0){
                    $returnData['deliveryAdressFinded'] = true;
                    $returnData['deliveryAdress'] = $deliveryAdress[0];
                } else {
                    $returnData['deliveryAdress'] = new \stdClass();
                    $returnData['deliveryAdress']->phoneNumber = '';
                    $returnData['deliveryAdress']->street = '';
                    $returnData['deliveryAdress']->house_number = '';
                    $returnData['deliveryAdress']->city = '';
                    $returnData['deliveryAdress']->zipCode = '';
                }
            }        
            
        }
        
        $jsonResponse = new JsonResponse($returnData);
        
        if (!$getArray){
            return $jsonResponse;
        } else {
            return $returnData;
        }

        
    }
    
    public function logout(Request $request)
    {
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        Auth::logout();
        $request->session()->invalidate();
        
        if ($request->isMethod('get')){
            return redirect()->to('/');
        }

        $jsonResponse = new JsonResponse($returnData);

        return $jsonResponse;
    }
    
    public function resetPassword(Request $request){
        return view('auth.reset-client-password');
    }
    
    public function resetPasswordConfirm(Request $request){
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        
        $request = $request->all();
        $email = preg_replace('/[\'\"\?\,\/\` \;]/','', $request['email']);
        
        $returnData["eee"] = $email;
        
        if (strlen($email) <= 0){
            $returnData["errors"][] = 'adres e-mail nie może być pusty';
            $returnData["errorsAreas"][] = 'reset-password-email';
            $returnData["status"] = false;
        }

        $userAcount = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE email = ?', [$email]);
        
        if ($returnData["status"] && count($userAcount) == 0){
            $returnData["errors"][] = 'podany użytkownik nie istnieje';
            $returnData["errorsAreas"][] = 'reset-password-email';
            $returnData["status"] = false;
        } 

        if (count($userAcount) > 0){
            if (intval($userAcount[0]->enabled) == 1){
                $emailVariables = [];
                $confirmationToken = $this->generateRandomString(45);
                $updateUser = DB::connection('mysql-esklep')->update('UPDATE fos_user SET confirmation_token = ?, password_requested_at = ? WHERE id=?', 
                                [$confirmationToken, date('Y-m-d H:i:s'), $userAcount[0]->id]);
                
                $activateLink = 'https://' . $_SERVER['SERVER_NAME'] . '/set-new-password/' . $confirmationToken;
                $emailVariables['activateLink'] = $activateLink;
                $emailsArray = [$userAcount[0]->email];
                $email = new Email($emailsArray, 'Reset hasła  - esklep wdoz.pl', 'emails/reset-password', $emailVariables);
                $email->send();
                $returnData["status"] = true;
            } else {
                $returnData["errors"][] = 'podany użytkownik nie został aktywowany';
                $returnData["errorsAreas"][] = 'reset-password-email';
                $returnData["status"] = false;
            }
        }

        

        $jsonResponse = new JsonResponse($returnData);

        return $jsonResponse;
    }
    
    public function setNewPassword(Request $request, $hash){
        $userAcount = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE confirmation_token = ?', [$hash]);
        
        $resetEnabled = false;
        $resetErrorMessage = '';
        $viewData = [
            'resetEnabled' => false,
            'resetErrorMessage' => '',
            'hash' => $hash
        ];
        if (count($userAcount) > 0){
            if (intval($userAcount[0]->enabled) == 1){
                if (\DateTime::createFromFormat('Y-m-d H:i:s', $userAcount[0]->password_requested_at) !== false) {
                    $time_difference = strtotime('now') - strtotime($userAcount[0]->password_requested_at);
                    if ($time_difference < 60 * 60 * 2.1){
                        $viewData['resetEnabled'] = true; 
                    } else {
                        $resetErrorMessage = 'Link do resetu hasła wygasł.';
                    }
                    
                } else {
                    $resetErrorMessage = 'Wewnętrzny błąd podczas próby resetu hasła 1';
                }
                
            } else {
                $resetErrorMessage = 'Użytkonik nie został aktywowany, aktywuj użytkownika żeby zresetować hasło.'; 
            }
        } else {
            $resetErrorMessage = 'Niepoprawny link do resetu hasła lub link wygasł.';
        }
        $viewData['resetErrorMessage'] = $resetErrorMessage;
        return view('auth.set-client-new-password',$viewData);
    }
    
    public function setClientPasswordConfirm(Request $request){
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        
        $request = $request->all();
        $newPassword = $request['newPassword'];
        $newPasswordRepeat = $request['newPasswordRepeat'];
        $hash = preg_replace('/[\'\"\?\,\/\` \;]/','', $request['userHash']);
        
        
        if ($newPassword == '' || $newPassword == null){
            $returnData["errors"][] = 'hasło nie może być puste';
            $returnData["errorsAreas"][] = 'new-password';
            $returnData["status"] = false;
        }
        if ($newPasswordRepeat == '' || $newPasswordRepeat == null){
            $returnData["errors"][] = 'powtórzenie hasła nie może być puste';
            $returnData["errorsAreas"][] = 'new-password-repeat';
            $returnData["status"] = false;
        }
        if ($newPassword !== $newPasswordRepeat){
            $returnData["errors"][] = 'hasło i jego powtórzenie nie mogą się różnić';
            $returnData["errorsAreas"][] = 'new-password-repeat';
            $returnData["status"] = false;
        }
        if (strlen($newPassword) < 8){
            $returnData["errors"][] = 'hasło musi mięc conajmniej 8 znaków';
            $returnData["errorsAreas"][] = 'new-password-repeat';
            $returnData["status"] = false;
        }
                

        $userAcount = DB::connection('mysql-esklep')->select('SELECT * FROM fos_user WHERE confirmation_token = ?', [$hash]);
        
        if ($returnData["status"] && count($userAcount) == 0){
            $returnData["errors"][] = 'podany użytkownik nie istnieje';
            $returnData["errorsAreas"][] = 'reset-password-email';
            $returnData["status"] = false;
        } 

        if ($returnData["status"] && count($userAcount) > 0){
            if (intval($userAcount[0]->enabled) == 1){
                if (\DateTime::createFromFormat('Y-m-d H:i:s', $userAcount[0]->password_requested_at) !== false) {
                    $time_difference = strtotime('now') - strtotime($userAcount[0]->password_requested_at);
                    if ($time_difference < 60 * 60 * 2.1){
                        $salted = $newPassword . "{" . $userAcount[0]->salt  . "}";
                        $digiest = hash('sha512', $salted, true);
                        for ($i=1; $i<5000; $i++){
                          $digiest = hash('sha512', $digiest.$salted, true);
                        }
                        $newHash = base64_encode($digiest);
                        $confirmationToken = $this->generateRandomString(45);
                        $updateUser = DB::connection('mysql-esklep')->update('UPDATE fos_user SET password = ?, confirmation_token = ? WHERE id=?', 
                                [$newHash, $confirmationToken, $userAcount[0]->id]);
                        
                    } else {
                        $returnData["errors"][] = 'Link do resetu hasła wygasł.';
                        $returnData["errorsAreas"][] = 'reset-password-email';
                        $returnData["status"] = false;
                    }
                    
                } else {
                    $returnData["errors"][] = 'Wewnętrzny błąd podczas próby resetu hasła.';
                    $returnData["errorsAreas"][] = 'reset-password-email';
                    $returnData["status"] = false;
                }
                
            } else {
                $returnData["errors"][] = 'Użytkonik nie został aktywowany, aktywuj użytkownika żeby zresetować hasło.';
                $returnData["errorsAreas"][] = 'reset-password-email';
                $returnData["status"] = false;
            }
        } else {
            $returnData["status"] = false;
        }

        

        $jsonResponse = new JsonResponse($returnData);

        return $jsonResponse;
    }
    
    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAdmin()
    {
        return view('auth.login-admin');
    }
    
    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticateAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //if(Auth::attempt($credentials))
        if (Auth::guard('usercustom-admin')->attempt($credentials)){
            
            //if (Auth::user()->isActive()){
                $request->session()->regenerate();
                return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
            /*} else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Konto w serwisie nie zostało jeszcze aktywowane. Sprawdź swoją skrzynkę e-mail i kilkinij w link aktywacyjny. '
                    . 'Jeżeli nie możesz znaleźć e-maila aktywacyjnego sprawdź folder spam, lub wygeneruj nowy link aktywacyjny: <a href="/resend-activate-email">tutaj</a> ',
                ])->onlyInput('email');
            }*/
            
            //echo 'okok';die();
            
        } else {
            //echo 'jail';die();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return back()->withErrors([
            'email' => 'Błędny login i/lub hasło',
        ])->onlyInput('email');

    } 
}
