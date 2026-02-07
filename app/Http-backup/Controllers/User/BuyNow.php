<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;

class BuyNow extends Controller
{
    public function __construct()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        } else {
            
        }
    }
    
    public function selectPackage(){
        
        
        $viewData = [];
        /*$legalTasksCount = DB::select('SELECT COUNT(id) AS taskscount FROM legal_tasks', []);
        $viewData['legalTasksCount'] = $legalTasksCount[0]->taskscount;
        $legalTestsCount = DB::select('SELECT COUNT(id) AS taskscount FROM legal_test_questions', []);
        $viewData['legalTestsCount'] = $legalTestsCount[0]->taskscount;
        
        $accesDuration = DB::select('SELECT value FROM settings where name=?', ['pro_acount_durtation_days']);
        $viewData['accesDuration'] = $accesDuration[0]->value;
        
        $accesPrice = DB::select('SELECT value FROM settings where name=?', ['pro_acount_price']);
        $viewData['accesPrice'] = $accesPrice[0]->value;*/
        
         
        return view('buynow.select-package',$viewData);
    }
    
    public function buyForm(){
        $viewData = [];
        $user = Auth::user();
        
        $userId = Auth::id();
        
        $dbUser = DB::select('select email, name, surname, invoice_comapny, invoice_street, invoice_postcode, invoice_city, invoice_nip, street, postcode, city  '
                . 'FROM users where id=?', [$userId]);
        
        $viewData['user'] = $dbUser[0];
        $viewData['isSanbox'] = Config::get('constants.przelewy24_use_sandbox');
        
        return view('buynow.buy-form',$viewData);
    }
    
    public function sendBuyRequest(Request $request){
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

            $needInvoice = $helper->saveDbText($formData["need_invoice"]);
            if ($needInvoice){

                $invoiceComapny = $helper->saveDbText($formData["invoice_comapny"]);
                if ($invoiceComapny == null || $invoiceComapny == ''){
                    $response['status'] = false;
                    $response['errors'][] = 'Żedby otrzymać fakturę, nazwa firmy jest polem obowiązkowym';
                    $response['errorsAreas'][] = 'invoice_comapny';
                }

                $invoiceStreet = $helper->saveDbText($formData["invoice_street"]);
                if ($invoiceStreet == null || $invoiceStreet == ''){
                    $response['status'] = false;
                    $response['errors'][] = 'Żedby otrzymać fakturę, ulica jest polem obowiązkowym';
                    $response['errorsAreas'][] = 'invoice_street';
                }

                $invoicePostcode = $helper->saveDbText($formData["invoice_postcode"]);
                if ($invoicePostcode == null || $invoicePostcode == ''){
                    $response['status'] = false;
                    $response['errors'][] = 'Żedby otrzymać fakturę, kod pocztowy jest polem obowiązkowym';
                    $response['errorsAreas'][] = 'invoice_postcode';
                }

                $invoiceCity = $helper->saveDbText($formData["invoice_city"]);
                if ($invoiceCity == null || $invoiceCity == ''){
                    $response['status'] = false;
                    $response['errors'][] = 'Żedby otrzymać fakturę, miasto jest polem obowiązkowym';
                    $response['errorsAreas'][] = 'invoice_city';
                }

                $invoiceNip = $helper->saveDbText($formData["invoice_nip"]);
                if ($invoiceNip == null || $invoiceNip == ''){
                    $response['status'] = false;
                    $response['errors'][] = 'Żedby otrzymać fakturę, NIP firmy jest polem obowiązkowym';
                    $response['errorsAreas'][] = 'invoice_nip';
                }
            }

            $rules = $helper->saveDbText($formData["accept_rules"]);
            if ($rules != true){
                $response['status'] = false;
                $response['errors'][] = 'Musisz zakaceptować relulamin i politykę prywatności, aby dokonać zakupu';
                $response['errorsAreas'][] = 'accept_rules';
            }

            if ($response['status']){
                $dbUserUpdate = DB::update('UPDATE users SET name=?, surname=?, street=?, postcode=?, city=? WHERE id=?', [$name, $surname, $street, $postcode, $city, $userId]);
                if ($needInvoice){
                    $dbUserUpdate = DB::update('UPDATE users SET invoice_comapny=?, invoice_street=?, invoice_postcode=?, invoice_city=?, invoice_nip=? WHERE id=?', 
                            [$invoiceComapny, $invoiceStreet, $invoicePostcode, $invoiceCity, $invoiceNip, $userId]);
                }
                
                $accesPrice = DB::select('SELECT value FROM settings where name=?', ['pro_acount_price']);
                
                $isSandBox = 0;
                if (Config::get('constants.przelewy24_use_sandbox')){
                    $isSandBox = 1;
                }
                
                $needInvoiceDb = 0;
                if ($needInvoice){
                    $needInvoiceDb = 1;
                }
                $sesionId = rand(10,1000) . time() . rand(10,1000);
                DB::insert('INSERT INTO purchases (user_id, date, buy_type, amount, payment_status, sesion_id, is_sandbox, need_invoice)'
                        . ' VALUES (?,?,?,?,?,?,?,?)', [$userId, date('Y-m-d H:i:s'), 'buy_premium', $accesPrice[0]->value, 0, $sesionId, $isSandBox, $needInvoiceDb]);
                
                $przelewy24Response = $this->preparePrzelewy24Transaction($sesionId,$accesPrice[0]->value, $dbUser[0]->email);
                if ($przelewy24Response == null){
                    $response['status'] = false;
                    $response['errors'][] = 'Wystąpił nieoczekiwany błąd podczas próby przejścia do płatności. Spróbój ponownie, jeżeli błąd będzie się powtarzać, skontaktuj się z obsługą klienta.';
                } else {
                    $response['status'] = true;
                    $response['paymentUrl'] = $przelewy24Response;
                }
            }
            
            
        } else {
            $response['status'] = false;
            $response['errors'][] = 'Aby dokonać zakupu musisz być zalogowany';
        }

        
        
        
        return response()->json($response);
    }
    
    public function getPrzelewy24Domain(){
        if (Config::get('constants.przelewy24_use_sandbox')){
            return Config::get('constants.przelewy24_sandbox_domain');
        } else {
            return Config::get('constants.przelewy24_production_domain');
        }
    }
    
    public function preparePrzelewy24Sign($sesionId, $amount, $currency){
        $jsonArray = [
            "sessionId" => $sesionId,
            "merchantId" => intval(Config::get('constants.przelewy24_merchantId')),
            "amount" => $amount,
            "currency" => $currency,
            "crc" => Config::get('constants.przelewy24_crc')
        ];
        
        return hash('sha384',json_encode($jsonArray,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
    
    
    
    public function isSecure() {
        return
          (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
          || $_SERVER['SERVER_PORT'] == 443;
    }
    
    public function preparePrzelewy24Transaction($sesionId, $amount, $userEmail){
        $curl = curl_init();
        
        $amount = intVal($amount * 100);
        
        $currency = "PLN";
        
        $protocol = 'https://';
        if (!$this->isSecure()){
            $protocol = 'http://';
        }
        
        $transactionArray = [
            "merchantId" => intVal(Config::get('constants.przelewy24_merchantId')),
            "posId" => intVal(Config::get('constants.przelewy24_merchantId')),
            "sessionId" => $sesionId,
            "amount" => $amount,
            "currency" => $currency,
            "description" => "zakup konta premium",
            "email" => $userEmail,
            "country" => "PL",
            "language" => "pl",
            "urlReturn" => $protocol . Config::get('constants.system_domain') . Config::get('constants.przelewy24_return_url'),
            "urlStatus" => $protocol . Config::get('constants.system_domain') . Config::get('constants.przelewy24_return_status_url'), 
            "sign" => $this->preparePrzelewy24Sign($sesionId, $amount, $currency)
            
        ];

        $url = $this->getPrzelewy24Domain() . Config::get('constants.przelewy24_register_transaction_url');

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
        ));
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $transactionArray);
        $headers = array(
            'Authorization: Basic '. base64_encode(Config::get('constants.przelewy24_merchantId').':'.Config::get('constants.przelewy24_klucz_raportow')),
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        /*curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($transactionArray));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);*/
        
        $response = curl_exec($curl);
        $response = json_decode($response, true);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($httpcode == 200){
            if (Config::get('constants.przelewy24_use_sandbox')){
                return Config::get('constants.przelewy24_sandbox_domain') . '/trnRequest/' . $response["data"]["token"];
            } else {
                return Config::get('constants.przelewy24_production_domain') . '/trnRequest/' . $response["data"]["token"];
            }
        } else {
            $emailVariables = [];
            $emailVariables['title'] = 'wystąpił błąd podczas próby płatności';
            $emailVariables['date'] = date('Y-m-d H:i:s');
            $emailVariables['content'] = 'wystąpił błąd podczas próby płatności, kod odpowiedzi: ' . $httpcode;
            $email = new Email(Config::get('constants.technical_admins_mails'), 'blad','short-info-mail', $emailVariables);
            $email->send();
            
            return null;
        }
    }
    
    public function setPrzelewy24PaymentStatus(Request $request){

        $request = $request->all();
        $formData = '';
        
        foreach ($request as $key => $val){
            $formData = $formData . ' ' . $key .'=' . $val . '   |    ';
        }

        $verifyArray = [
            "merchantId" => intVal(Config::get('constants.przelewy24_merchantId')),
            "posId" => intVal(Config::get('constants.przelewy24_merchantId')),
            "sessionId" => $request["sessionId"],
            "amount" => intVal($request["amount"]),
            "currency" => $request["currency"],
            "orderId" => intVal($request["orderId"]),
            "sign" => $this->preparePrzelewy24Sign2($request["sessionId"], $request["orderId"], intVal($request["amount"]), $request["currency"])
        ];
        
        $url = $this->getPrzelewy24Domain() . Config::get('constants.przelewy24_register_verify_url');

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "PUT",
        ));
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($verifyArray));
        $headers = array(
            'Authorization: Basic '. base64_encode(Config::get('constants.przelewy24_merchantId').':'.Config::get('constants.przelewy24_klucz_raportow')),
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        
        $accesDuration = DB::select('SELECT value FROM settings where name=?', ['pro_acount_durtation_days']);
        if (isset($accesDuration[0])){
            $duration = $accesDuration[0]->value;
            
            $purchaseInDb = DB::select('SELECT user_id, sesion_id FROM purchases WHERE sesion_id=?', [$request["sessionId"]]);
            
            if (isset($purchaseInDb[0])){
                
                $purchaseUser = DB::select('SELECT id, name, email FROM users WHERE id=?', [$purchaseInDb[0]->user_id]);
                
                if (isset($purchaseUser[0])){
                
                    $date = date('Y-m-d', strtotime('+'.$accesDuration[0]->value.' days'));    
                    $dbUserUpdate = DB::update('UPDATE users SET pro_user_for=? WHERE id=?', [$date, $purchaseUser[0]->id]);

                    $dbPurchaseUpdate = DB::update('UPDATE purchases SET payment_status=? WHERE sesion_id=?', [5, $request["sessionId"]]);
                    
                    $emailVariables = [];
                    $emailVariables['title'] = 'Potwierdzeni zakupyu konta PRO - Legesfera';
                    $emailVariables['date'] = date('Y-m-d H:i:s');
                    $emailVariables['content'] = 'Dziękujemy za zakup konta Pro w systemie Legesfera. Życzymy owocnej nauki i powodzenia podczas egzaminu.';
                    $email = new Email($purchaseUser[0]->email, 'Potwierdzeni zakupyu konta PRO - Legesfera','short-info-mail', $emailVariables);
                    $email->send();
                    
                    
                    $emailVariables = [];
                    $emailVariables['title'] = 'Ktoś kupił konto PRO w Legesfera!';
                    $emailVariables['date'] = date('Y-m-d H:i:s');
                    $emailVariables['content'] = 'Udało się ktoś kupił!! ';
                    $email = new Email(Config::get('constants.technical_admins_mails'), 'Ktoś kupił konto PRO w Legesfera!','short-info-mail', $emailVariables);
                    $email->send();
                }
            }
        }

        if ($httpcode == 200){
            
            

        } else {
            $emailVariables = [];
            $emailVariables['title'] = 'wystąpił błąd podczas próby weryfikacji płatności';
            $emailVariables['date'] = date('Y-m-d H:i:s');
            $emailVariables['content'] = 'wystąpił błąd podczas próby weryfikacji płatności, kod odpowiedzi: ' . $httpcode;
            $email = new Email(Config::get('constants.technical_admins_mails'), 'blad','short-info-mail', $emailVariables);
            $email->send();
            
            return null;
        }
        
    }
    
    public function preparePrzelewy24Sign2($sesionId, $orderId, $amount, $currency){
        $jsonArray = [
            "sessionId" => $sesionId,
            "orderId" => intval($orderId),
            "amount" => $amount,
            "currency" => $currency,
            "crc" => Config::get('constants.przelewy24_crc')
        ];
        return hash('sha384',json_encode($jsonArray,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
    
    public function thankYouPage(){
        
        $viewData = [];
        
        return view('buynow.thank-you-page',$viewData);
        
    }
}
