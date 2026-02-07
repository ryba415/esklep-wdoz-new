<?php

namespace App\Http\Controllers\Basket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;
use Config;
use App\Models\Basket;
use App\Models\Email;
use Illuminate\Support\Facades\Auth;

class BasketApiController extends Controller
{

    public function addToBasket(Request $request)
    {
        $requestData = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "hash" => ""
        ];
        
        $changeQuantity = false;
        if (isset($requestData['changeQuantity']) && $requestData['changeQuantity'] == true){
            $changeQuantity = true;
        }
        
        if (isset($requestData['hash']) && $requestData['hash'] != null && $requestData['hash'] != ''){
            $basket = new Basket($requestData['hash']);
        } else {
            $basket = new Basket(null);
        }
            $returnData['hash'] = $basket->getHash();
            $request['hash'] = $basket->getHash();
            if (isset($requestData['id']) && isset($requestData['quantity'])){
                $addItemResponse = $basket->addItemById($requestData['id'],$requestData['quantity'],$changeQuantity);
                $returnData['status'] = $addItemResponse['status'];
                $returnData['errors'] = array_merge($returnData['errors'], $addItemResponse['errors']);
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Id and Quantity are requiere';
            }

        $returnData['basketData'] = $this->getBasketData($request,false);
        
        
        return \Response::json($returnData, 200);
    }
    
    public function removeFromBasket(Request $request)
    {
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "hash" => ""
        ];
        
        if (isset($request['hash'])){
            $basket = new Basket($request['hash']);
            $returnData['hash'] = $basket->getHash();
            if (isset($request['id'])){
                $removeStatus = $basket->removeItemById($request['id']);
                if (!$removeStatus['status']){
                    $returnData['status'] = false;
                    $returnData['errors'] = arra_merge($returnData['errors'],$removeStatus['errors']);
                }
            } else {
                $returnData['status'] = false;
                $returnData['errors'][] = 'Id is requiere';
            }
        } else {
            $returnData['status'] = false;
            $returnData['errors'][] = 'Hash is require';
        }
        
        
        return \Response::json($returnData, 200);
    }
    
    public function getBasketData(Request $request, $returnJson = true)
    {
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "hash" => "",
            "basket" => null
        ];
        
        if (isset($request['hash'])){
            $basket = new Basket($request['hash']);
            $returnData['hash'] = $basket->getHash();
            $returnData['basket'] = $basket;
        } else {
            $returnData['status'] = false;
            $returnData['errors'][] = 'Hash is require';
        }
        
        if ($returnJson){
            return \Response::json($returnData, 200);
        } else {
            return $returnData;
        }
    }
    
    /*public function validateDeliveryData(Request $request){
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        
        $buyFormName = '';
        $buyFormSurname = '';
        $buyFormEmail = '';         
        $buyFormPhone = '';         
        $needInvoiceCheckbox = '';         
        $invoiceTypeSelect = '';         
        $buyFormCompany = '';        
        $buyFormNip = '';         
        $buyFormInvoiceStreet = '';         
        $buyFormInvoiceHuseNumber = '';         
        $buyFormInvoiceCity = '';         
        $buyFormInvoiceZipcode = '';  
        $selectDeliveyMethod = '';
        $selectDeliveyMethodId = '';
        $buyFormStreet = '';
        $buyFormChouseNumber = '';
        $buyFormCity = '';         
        $buyFormZipcode = '';  
        $selectPaymentMethod = ''; 
        $useOrlenWidget = false;
        $selectedOrlen = '';
        $useInpostWidget = false;
        $selectedPaczkomat = '';
        $acceptRulesNewsletter = false;
        $acceptRules1 = false;
        $basketHash = '';
  
        if (isset($request['formdata']['buy-form-name'])){
            $buyFormName = $request['formdata']['buy-form-name'];
        }
        if (isset($request['formdata']['buy-form-surname'])){
            $buyFormSurname = $request['formdata']['buy-form-surname'];
        }
        if (isset($request['formdata']['buy-form-email'])){
            $buyFormEmail = $request['formdata']['buy-form-email'];
        }
        if (isset($request['formdata']['buy-form-phone'])){
            $buyFormPhone = $request['formdata']['buy-form-phone'];
        }
        if (isset($request['formdata']['need-invoice-checkbox'])){
            $needInvoiceCheckbox = $request['formdata']['need-invoice-checkbox'];
        }
        if (isset($request['formdata']['invoice-type-select'])){
            $invoiceTypeSelect = $request['formdata']['invoice-type-select'];
        }
        if (isset($request['formdata']['buy-form-company'])){
            $buyFormCompany = $request['formdata']['buy-form-company'];
        }
        if (isset($request['formdata']['buy-form-nip'])){
            $buyFormNip = $request['formdata']['buy-form-nip'];
        }
        if (isset($request['formdata']['buy-form-invoice-street'])){
            $buyFormInvoiceStreet = $request['formdata']['buy-form-invoice-street'];
        }
        if (isset($request['formdata']['buy-form-invoice-house-number'])){
            $buyFormInvoiceHuseNumber = $request['formdata']['buy-form-invoice-house-number'];
        }
        if (isset($request['formdata']['buy-form-invoice-city'])){
            $buyFormInvoiceCity = $request['formdata']['buy-form-invoice-city'];
        }
        if (isset($request['formdata']['buy-form-invoice-zipcode'])){
            $buyFormInvoiceZipcode = $request['formdata']['buy-form-invoice-zipcode'];
        }
        if (isset($request['formdata']['select-delivey-method'])){
            $selectDeliveyMethod = $request['formdata']['select-delivey-method'];
        }
        if (isset($request['formdata']['select-delivey-method-id'])){
            $selectDeliveyMethodId = $request['formdata']['select-delivey-method-id'];
        }
        if (isset($request['formdata']['buy-form-street'])){
            $buyFormStreet = $request['formdata']['buy-form-street'];
        }
        if (isset($request['formdata']['buy-form-chouse-number'])){
            $buyFormChouseNumber = $request['formdata']['buy-form-chouse-number'];
        }
        if (isset($request['formdata']['buy-form-city'])){
            $buyFormCity = $request['formdata']['buy-form-city'];
        }
        if (isset($request['formdata']['buy-form-zipcode'])){
            $buyFormZipcode = $request['formdata']['buy-form-zipcode'];
        }
        if (isset($request['formdata']['select-payment-method'])){
            $selectPaymentMethod = $request['formdata']['select-payment-method'];
        }
        if (isset($request['formdata']['use-orlen-widget'])){
            if ($request['formdata']['use-orlen-widget'] == 1){
                $useOrlenWidget = true;
            } else {
                $useOrlenWidget = false;
            }
        }
        if (isset($request['formdata']['selected-orlen'])){
            $selectedOrlen = $request['formdata']['selected-orlen'];
        }
        if (isset($request['formdata']['use-inpost-widget'])){
            if ($request['formdata']['use-inpost-widget'] == 1){
                $useInpostWidget = true;
            } else {
                $useInpostWidget = false;
            }
        }
        if (isset($request['formdata']['selected-paczkomat'])){
            $selectedPaczkomat = $request['formdata']['selected-paczkomat'];
        }
        if (isset($request['formdata']['accept-rules1'])){
            $acceptRules1 = boolval($request['formdata']['accept-rules1']);
        }
        if (isset($request['formdata']['accept-rules-newsletter'])){
            $acceptRulesNewsletter = boolval($request['formdata']['accept-rules-newsletter']);
        }
        if (isset($request['formdata']['basket-hash'])){
            $basketHash = $request['formdata']['basket-hash'];
        }
        
        $basket = new Basket($basketHash);
            
        if ($basket->itemsCount <= 0){
            $returnData['errors'][] = 'Nie można zrealizować zakupu - koszyk jest pusty ' . $basketHash;
            $returnData['errorsAreas'][] = '';
            $returnData['status'] = false;
        }

        if ($buyFormName == ''){
            $returnData['errors'][] = 'Imię jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-name';
            $returnData['status'] = false;
        }
        
        if ($buyFormSurname == ''){
            $returnData['errors'][] = 'Nazwisko jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-surname';
            $returnData['status'] = false;
        }
        
        if ($buyFormEmail == ''){
            $returnData['errors'][] = 'Adres e-mail jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-email';
            $returnData['status'] = false;
        } else {
            if (!str_contains($buyFormEmail,'@')){
                $returnData['errors'][] = 'Adres e-mail ma niewłaściwy format';
                $returnData['errorsAreas'][] = 'buy-form-email';
                $returnData['status'] = false; 
            }
        }
        
        if ($buyFormPhone == ''){
            $returnData['errors'][] = 'Telefon jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-phone';
            $returnData['status'] = false;
        } else {
            if (strlen($buyFormPhone) < 9){
                $returnData['errors'][] = 'Telefon musi mieć co najmniej 9 znaków';
                $returnData['errorsAreas'][] = 'buy-form-phone';
                $returnData['status'] = false;
            }
        }
        
        if ($needInvoiceCheckbox == 1){
            if (!in_array($invoiceTypeSelect,['company','person'])){
                $returnData['errors'][] = 'Nieprawidłowy typ faktury';
                $returnData['errorsAreas'][] = 'invoice-type-select';
                $returnData['status'] = false;
            }
            if ($buyFormCompany == ''){
                $returnData['errors'][] = 'Nazwa firmy jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-company';
                $returnData['status'] = false;
            }
            if ($buyFormNip == ''){
                $returnData['errors'][] = 'NIP jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-nip';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceStreet == ''){
                $returnData['errors'][] = 'Ulica do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-street';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceHuseNumber == ''){
                $returnData['errors'][] = 'Nr domu / mieszkania do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-house-number';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceHuseNumber == ''){
                $returnData['errors'][] = 'Nr domu / mieszkania do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-house-number';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceCity == ''){
                $returnData['errors'][] = 'Miejscowość do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-city';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceZipcode == ''){
                $returnData['errors'][] = 'Kod pocztowy do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-zipcode';
                $returnData['status'] = false;
            }
        }
        
        if ($selectDeliveyMethod == ''){
            $returnData['errors'][] = 'Sposób dostawy nie został wybrany';
            $returnData['errorsAreas'][] = ' ';
            $returnData['status'] = false;
        }

        if (!$useOrlenWidget && !$useInpostWidget){
            if ($buyFormStreet == ''){
                $returnData['errors'][] = 'Ulica jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-street';
                $returnData['status'] = false;
            }
            if ($buyFormChouseNumber == ''){
                $returnData['errors'][] = 'Numer domu / mieszkania jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-chouse-number';
                $returnData['status'] = false;
            }
            if ($buyFormCity == ''){
                $returnData['errors'][] = 'Miejscowość jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-city';
                $returnData['status'] = false;
            }
            if ($buyFormZipcode == ''){
                $returnData['errors'][] = 'Kod pocztowy jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-zipcode';
                $returnData['status'] = false;
            }
        } else {
            foreach ($basket->basketItems as $i => $item){ 
                if ($item->type_of_preparation == 'Lek bez recepty'){
                    $returnData['errors'][] = 'Twój koszyk zawiera produkt leczniczy: '.$item->name.' – możliwa wysyłka kurierem, zmień metodę dostawy';
                    $returnData['errorsAreas'][] = '';
                    $returnData['status'] = false;
                    break;
                }
            }
        }
        
        if ($useOrlenWidget){
            if ($selectedOrlen == ''){
                $returnData['errors'][] = 'Nie został wybrany punkt odbioru Orlen paczki';
                $returnData['errorsAreas'][] = 'selected-orlen';
                $returnData['status'] = false;
            }  
        }
        
        
        if ($useInpostWidget){
            if ($selectedPaczkomat == ''){
                $returnData['errors'][] = 'Nie został wybrany paczkomat Inpost';
                $returnData['errorsAreas'][] = 'selected-paczkomat';
                $returnData['status'] = false;
            }  
        }
        
        if ($selectPaymentMethod == ''){
            $returnData['errors'][] = 'Metoda płatności nie została wybrana';
            $returnData['errorsAreas'][] = 'select-payment-method';
            $returnData['status'] = false;
        }
        
        if (!$acceptRules1){
            $returnData['errors'][] = 'Akceptacja regulaminu jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'accept-rules1';
            $returnData['status'] = false;
        }
        
        if ($basketHash == ''){
            $returnData['errors'][] = 'Nie można zrealizować zakupu - koszyk wygasł';
            $returnData['errorsAreas'][] = '';
            $returnData['status'] = false;
        }
        
        if ($returnData['status']){

            
        }
        
        return \Response::json($returnData, 200);
    }*/
    
    public function buyNow(Request $request){
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => [],
        ];
        
        $buyFormName = '';
        $buyFormSurname = '';
        $buyFormEmail = '';         
        $buyFormPhone = '';         
        $needInvoiceCheckbox = '';         
        $invoiceTypeSelect = '';         
        $buyFormCompany = '';        
        $buyFormNip = '';         
        $buyFormInvoiceStreet = '';         
        $buyFormInvoiceHuseNumber = '';         
        $buyFormInvoiceCity = '';         
        $buyFormInvoiceZipcode = '';  
        $selectDeliveyMethod = '';
        $selectDeliveyMethodId = '';
        $buyFormStreet = '';
        $buyFormChouseNumber = '';
        $buyFormCity = '';         
        $buyFormZipcode = '';  
        $selectPaymentMethod = ''; 
        $useOrlenWidget = false;
        $selectedOrlen = '';
        $useInpostWidget = false;
        $selectedPaczkomat = '';
        $acceptRulesNewsletter = false;
        $acceptRules1 = false;
        $basketHash = '';
        
        $buyNow = false;
        
        if (isset($request['formdata']['buyNow'])){
            $buyNow = $request['formdata']['buyNow'];
        }
  
        if (isset($request['formdata']['buy-form-name'])){
            $buyFormName = $request['formdata']['buy-form-name'];
        }
        if (isset($request['formdata']['buy-form-surname'])){
            $buyFormSurname = $request['formdata']['buy-form-surname'];
        }
        if (isset($request['formdata']['buy-form-email'])){
            $buyFormEmail = $request['formdata']['buy-form-email'];
        }
        if (isset($request['formdata']['buy-form-phone'])){
            $buyFormPhone = $request['formdata']['buy-form-phone'];
        }
        if (isset($request['formdata']['need-invoice-checkbox'])){
            $needInvoiceCheckbox = $request['formdata']['need-invoice-checkbox'];
        }
        if (isset($request['formdata']['invoice-type-select'])){
            $invoiceTypeSelect = $request['formdata']['invoice-type-select'];
        }
        if (isset($request['formdata']['buy-form-company'])){
            $buyFormCompany = $request['formdata']['buy-form-company'];
        }
        if (isset($request['formdata']['buy-form-nip'])){
            $buyFormNip = $request['formdata']['buy-form-nip'];
        }
        if (isset($request['formdata']['buy-form-invoice-street'])){
            $buyFormInvoiceStreet = $request['formdata']['buy-form-invoice-street'];
        }
        if (isset($request['formdata']['buy-form-invoice-house-number'])){
            $buyFormInvoiceHuseNumber = $request['formdata']['buy-form-invoice-house-number'];
        }
        if (isset($request['formdata']['buy-form-invoice-city'])){
            $buyFormInvoiceCity = $request['formdata']['buy-form-invoice-city'];
        }
        if (isset($request['formdata']['buy-form-invoice-zipcode'])){
            $buyFormInvoiceZipcode = $request['formdata']['buy-form-invoice-zipcode'];
        }
        if (isset($request['formdata']['select-delivey-method'])){
            $selectDeliveyMethod = $request['formdata']['select-delivey-method'];
        }
        if (isset($request['formdata']['select-delivey-method-id'])){
            $selectDeliveyMethodId = $request['formdata']['select-delivey-method-id'];
        }
        if (isset($request['formdata']['buy-form-street'])){
            $buyFormStreet = $request['formdata']['buy-form-street'];
        }
        if (isset($request['formdata']['buy-form-chouse-number'])){
            $buyFormChouseNumber = $request['formdata']['buy-form-chouse-number'];
        }
        if (isset($request['formdata']['buy-form-city'])){
            $buyFormCity = $request['formdata']['buy-form-city'];
        }
        if (isset($request['formdata']['buy-form-zipcode'])){
            $buyFormZipcode = $request['formdata']['buy-form-zipcode'];
        }
        if (isset($request['formdata']['select-payment-method'])){
            $selectPaymentMethod = $request['formdata']['select-payment-method'];
        }
        if (isset($request['formdata']['use-orlen-widget'])){
            if ($request['formdata']['use-orlen-widget'] == 1){
                $useOrlenWidget = true;
            } else {
                $useOrlenWidget = false;
            }
        }
        if (isset($request['formdata']['selected-orlen'])){
            $selectedOrlen = $request['formdata']['selected-orlen'];
        }
        if (isset($request['formdata']['use-inpost-widget'])){
            if ($request['formdata']['use-inpost-widget'] == 1){
                $useInpostWidget = true;
            } else {
                $useInpostWidget = false;
            }
        }
        if (isset($request['formdata']['selected-paczkomat'])){
            $selectedPaczkomat = $request['formdata']['selected-paczkomat'];
        }
        if (isset($request['formdata']['accept-rules1'])){
            $acceptRules1 = boolval($request['formdata']['accept-rules1']);
        }
        if (isset($request['formdata']['accept-rules-newsletter'])){
            $acceptRulesNewsletter = boolval($request['formdata']['accept-rules-newsletter']);
        }
        if (isset($request['formdata']['basket-hash'])){
            $basketHash = $request['formdata']['basket-hash'];
        }
        
        $basket = new Basket($basketHash);
            
        if ($basket->itemsCount <= 0){
            $returnData['errors'][] = 'Nie można zrealizować zakupu - koszyk jest pusty ' . $basketHash;
            $returnData['errorsAreas'][] = '';
            $returnData['status'] = false;
        }

        if ($buyFormName == ''){
            $returnData['errors'][] = 'Imię jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-name';
            $returnData['status'] = false;
        }
        
        if ($buyFormSurname == ''){
            $returnData['errors'][] = 'Nazwisko jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-surname';
            $returnData['status'] = false;
        }
        
        if ($buyFormEmail == ''){
            $returnData['errors'][] = 'Adres e-mail jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-email';
            $returnData['status'] = false;
        } else {
            if (!str_contains($buyFormEmail,'@')){
                $returnData['errors'][] = 'Adres e-mail ma niewłaściwy format';
                $returnData['errorsAreas'][] = 'buy-form-email';
                $returnData['status'] = false; 
            }
        }
        
        if ($buyFormPhone == ''){
            $returnData['errors'][] = 'Telefon jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'buy-form-phone';
            $returnData['status'] = false;
        } else {
            if (strlen($buyFormPhone) < 9){
                $returnData['errors'][] = 'Telefon musi mieć co najmniej 9 znaków';
                $returnData['errorsAreas'][] = 'buy-form-phone';
                $returnData['status'] = false;
            }
        }
        
        if ($needInvoiceCheckbox == 1){
            if (!in_array($invoiceTypeSelect,['company','person'])){
                $returnData['errors'][] = 'Nieprawidłowy typ faktury';
                $returnData['errorsAreas'][] = 'invoice-type-select';
                $returnData['status'] = false;
            }
            if ($buyFormCompany == ''){
                $returnData['errors'][] = 'Nazwa firmy jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-company';
                $returnData['status'] = false;
            }
            if ($buyFormNip == ''){
                $returnData['errors'][] = 'NIP jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-nip';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceStreet == ''){
                $returnData['errors'][] = 'Ulica do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-street';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceHuseNumber == ''){
                $returnData['errors'][] = 'Nr domu / mieszkania do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-house-number';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceHuseNumber == ''){
                $returnData['errors'][] = 'Nr domu / mieszkania do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-house-number';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceCity == ''){
                $returnData['errors'][] = 'Miejscowość do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-city';
                $returnData['status'] = false;
            }
            if ($buyFormInvoiceZipcode == ''){
                $returnData['errors'][] = 'Kod pocztowy do faktury jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-invoice-zipcode';
                $returnData['status'] = false;
            }
        }
        
        if ($selectDeliveyMethod == ''){
            $returnData['errors'][] = 'Sposób dostawy nie został wybrany';
            $returnData['errorsAreas'][] = ' ';
            $returnData['status'] = false;
        }

        if (!$useOrlenWidget && !$useInpostWidget){
            if ($buyFormStreet == ''){
                $returnData['errors'][] = 'Ulica jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-street';
                $returnData['status'] = false;
            }
            if ($buyFormChouseNumber == ''){
                $returnData['errors'][] = 'Numer domu / mieszkania jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-chouse-number';
                $returnData['status'] = false;
            }
            if ($buyFormCity == ''){
                $returnData['errors'][] = 'Miejscowość jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-city';
                $returnData['status'] = false;
            }
            if ($buyFormZipcode == ''){
                $returnData['errors'][] = 'Kod pocztowy jest polem obowiązkowym';
                $returnData['errorsAreas'][] = 'buy-form-zipcode';
                $returnData['status'] = false;
            }
        } else {
            foreach ($basket->basketItems as $i => $item){ 
                if ($item->type_of_preparation == 'Lek bez recepty'){
                    $returnData['errors'][] = 'Twój koszyk zawiera produkt leczniczy: '.$item->name.' – możliwa wysyłka kurierem, zmień metodę dostawy';
                    $returnData['errorsAreas'][] = '';
                    $returnData['status'] = false;
                    break;
                }
            }
        }
        
        if ($useOrlenWidget){
            if ($selectedOrlen == ''){
                $returnData['errors'][] = 'Nie został wybrany punkt odbioru Orlen paczki';
                $returnData['errorsAreas'][] = 'selected-orlen';
                $returnData['status'] = false;
            }  
        }
        
        
        if ($useInpostWidget){
            if ($selectedPaczkomat == ''){
                $returnData['errors'][] = 'Nie został wybrany paczkomat Inpost';
                $returnData['errorsAreas'][] = 'selected-paczkomat';
                $returnData['status'] = false;
            }  
        }
        
        if ($selectPaymentMethod == ''){
            $returnData['errors'][] = 'Metoda płatności nie została wybrana';
            $returnData['errorsAreas'][] = 'select-payment-method';
            $returnData['status'] = false;
        }
        
        if (!$acceptRules1){
            $returnData['errors'][] = 'Akceptacja regulaminu jest polem obowiązkowym';
            $returnData['errorsAreas'][] = 'accept-rules1';
            $returnData['status'] = false;
        }
        
        if ($basketHash == ''){
            $returnData['errors'][] = 'Nie można zrealizować zakupu - koszyk wygasł';
            $returnData['errorsAreas'][] = '';
            $returnData['status'] = false;
        }
        
        foreach ($basket->basketItems as $item){
            $changeAvariabilityString = '';
            $product = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_products WHERE id = ?', [$item->productId]);
            if ($product){
                if ($product[0]->availability < $item->quantity ){
                    $changeAvariabilityString = $changeAvariabilityString . 'Produkt ' . $product[0]->name . ' ' .  $product[0]->brand . ' ' . $product[0]->content . ' ma dostępnych: ' . $product[0]->availability . ' sztuk w magazynie. Ilość produktów w koszyku została automatycznie zmieniona.<br>';
                    $basket->addItemById($item->productId, $product[0]->availability, true);
                }
                if ($product[0]->one_purchase_availability > 0 && $product[0]->one_purchase_availability < $item->quantity ){
                    $changeAvariabilityString = $changeAvariabilityString . 'Produkt ' . $product[0]->name . ' ' .  $product[0]->brand . ' ' . $product[0]->content . ' ma ustalony limit ilości sztuk podczas jednorazowego zakupu na: ' . $product[0]->one_purchase_availability . ' sztuk. Ilość produktów w koszyku została automatycznie zmieniona.<br>';
                    $basket->addItemById($item->productId, $product[0]->one_purchase_availability, true);
                }
            } else {
                $basket->removeItemById($item->id);
                $changeAvariabilityString = $changeAvariabilityString . 'Produkt o id: ' . $item->productId . ' został wycofany z oferty i został usunięty z koszyka.<br>';
            }
            
        }
        if ($changeAvariabilityString != ''){
            $returnData['errors'][] = 'Wystąpiły limity w ilościach sztuk kupowanych produktów. Sprawdź czy pomimo poniżej wymienionych zmian nadal chcesz dokonać zakupu?<br>'.$changeAvariabilityString;
            $returnData['errorsAreas'][] = '';
            $returnData['status'] = false;
        }

        

        if ($returnData['status']){
            
            //$basket = new Basket($basketHash);
            
            //if ($basket->itemsCount > 0){
                
                
                $delivery = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_delivery_method WHERE id = ?', [$selectDeliveyMethodId]);
                
                if (count($delivery) > 0){

                    $freeDeliveryFromValue = 9999999;    
                    $basketSettings = DB::connection('mysql-esklep')->select('SELECT code, value FROM settings WHERE code = ?', 
                            ['free_delivery_from_value']);
                    if (count($basketSettings) > 0 ){
                        $freeDeliveryFromValue = $basketSettings[0]->value;
                    }
            
                    $vatValue = floatval($basket->valueGross) - floatval($basket->valueNet);
                    $fullDelivery = $buyFormStreet . ' ' . $buyFormChouseNumber . ' ' . $buyFormCity . ' ' . $buyFormZipcode;
                    if (floatval($basket->valueGross) > $freeDeliveryFromValue){
                        $deliveryPrice = 0;
                    } else {
                        $deliveryPrice = $delivery[0]->payu_price;
                    }
                    
                    
                    $priceGross = $basket->valueGross + $deliveryPrice;
                    $priceNet = $basket->valueNet + round(($deliveryPrice*0.77),2);
                    $vatValue = floatval($priceGross) - floatval($priceGross);
                    
                    $annyPaczkomat = null;
                    if ($selectedOrlen != '' && $selectedOrlen != null){
                        $annyPaczkomat = $selectedOrlen;
                    }
                    if ($selectedPaczkomat != '' && $selectedPaczkomat != null){
                        $annyPaczkomat = $selectedPaczkomat;
                    }
                    $userId = null;
                    if (Auth::user() !== null){
                        $userId = Auth::id();
                    }
                    
                    $existedData = DB::connection('mysql-esklep')->select('SELECT id, basket_id FROM ecommerce_basket_data WHERE basket_id = ?', [$basket->id]);
                    $basketDataId = null;
                    if (count($existedData) > 0){
                        $basketDataId = $existedData[0]->id;
                    }
                    $saveOrder = DB::connection('mysql-esklep')->insert('REPLACE INTO ecommerce_basket_data '
                            . '(id, basket_id, identity, user_id, name, save_date, status, value_gross, value_net, value_vat, delivery_method_id, payment_type, delivery_data,'
                            . 'delivery_street, delivery_house_number, delivery_city, delivery_zip_code, with_invoice, company_name, vat_number, town, street,'
                            . 'house_number, postal_code, recipient, delivery_cost, phone, email, external_id, paczkomat_details,send_status_email)'
                            . ' VALUES (?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', 
                            [$basketDataId, $basket->id, $basketHash,$userId,preg_replace("/[^A-Za-z0-9]/", '', base64_encode(random_bytes(2))) . preg_replace("/[^A-Za-z0-9]/", '', base64_encode(random_bytes(2))) . preg_replace("/[^A-Za-z0-9]/", '', base64_encode(random_bytes(6))) . '/'.date('Y').date('m').date('d'),date('Y-m-d H:i:s'),
                            'inprogress',$priceGross,$basket->valueNet,$vatValue,$selectDeliveyMethodId,$selectPaymentMethod,$fullDelivery,
                            $buyFormStreet, $buyFormChouseNumber, $buyFormCity, $buyFormZipcode, $needInvoiceCheckbox, $buyFormCompany, $buyFormNip,
                            $buyFormInvoiceCity, $buyFormInvoiceStreet, $buyFormInvoiceHuseNumber, $buyFormInvoiceZipcode, $buyFormName . ' ' . $buyFormSurname,
                            $deliveryPrice, $buyFormPhone, $buyFormEmail, null, $annyPaczkomat, null]);
                    
                    if (!$buyNow){
                        return \Response::json($returnData, 200);
                        die();
                    }
                    
                    $saveOrder = DB::connection('mysql-esklep')->insert('INSERT INTO ecommerce_orders '
                            . '(identity, user_id, name, order_date, status, value_gross, value_net, value_vat, delivery_method_id, payment_type, delivery_data,'
                            . 'delivery_street, delivery_house_number, delivery_city, delivery_zip_code, with_invoice, company_name, vat_number, town, street,'
                            . 'house_number, postal_code, recipient, delivery_cost, phone, email, external_id, paczkomat_details,send_status_email)'
                            . ' VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', 
                            [$basketHash,$userId,preg_replace("/[^A-Za-z0-9]/", '', base64_encode(random_bytes(2))) . preg_replace("/[^A-Za-z0-9]/", '', base64_encode(random_bytes(2))) . preg_replace("/[^A-Za-z0-9]/", '', base64_encode(random_bytes(6))) . '/'.date('Y').date('m').date('d'),date('Y-m-d H:i:s'),
                            'inprogress',$priceGross,$basket->valueNet,$vatValue,$selectDeliveyMethodId,$selectPaymentMethod,$fullDelivery,
                            $buyFormStreet, $buyFormChouseNumber, $buyFormCity, $buyFormZipcode, $needInvoiceCheckbox, $buyFormCompany, $buyFormNip,
                            $buyFormInvoiceCity, $buyFormInvoiceStreet, $buyFormInvoiceHuseNumber, $buyFormInvoiceZipcode, $buyFormName . ' ' . $buyFormSurname,
                            $deliveryPrice, $buyFormPhone, $buyFormEmail, null, $annyPaczkomat, null]);

                    $orderId = DB::connection('mysql-esklep')->getPdo()->lastInsertId();
                    if ($saveOrder){
                        
                        foreach ($basket->basketItems as $item){
                            DB::connection('mysql-esklep')->insert('INSERT INTO ecommerce_order_position '
                                . '(product_id, order_id, price_net, price_gross, vat_rate, quantity, value_net, value_gross, weight)'
                                . ' VALUES (?,?,?,?,?,?,?,?,?)', 
                                [$item->productId,$orderId,$item->priceNet,$item->priceGross, $item->vat_rate, $item->quantity, $item->valueNet, $item->valueGross, 0]);
                        }
                        
                        $order = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_orders WHERE id = ?', [$orderId]);
                        
                        if (count($order) == 0){
                            $returnData['error'] = 'Wystąpił nieoczekiwany błąd podczas próby zapisu zamówienia. Spróbuj ponownie lub skontaktuj się z obsługą klienta w celu rozwiązania problemu. ';
                            $returnData['errorsAreas'][] = '';
                            $returnData['status'] = false; 
                        } else {
                            $returnData['orderId'] = $order[0]->id;
                            $returnData['basket'] = $basket;
                        }
                        if ($selectPaymentMethod == 'przelewpaynow'){
                            $paynowResponse = $this->payNowAction($orderId);
                            if ($paynowResponse["status"]){
                                $returnData["redirectUrl"] = $paynowResponse["url"];
                            } else {
                                $returnData['errors'][] = $paynowResponse["error"];
                                $returnData['errorsAreas'][] = '';
                                $returnData['status'] = false;
                                
                                /*$returnData['status'] = true; //tymaczowo do testów
                                $returnData['errors'] = []; //tymaczowo do testów
                                $returnData['errorsAreas'] = []; //tymaczowo do testów
                                $returnData['redirectUrl'] = "/test-przelewy-payment"; //tymaczowo do testów*/
                            }
                        } else {
                            if (count($order) > 0){
                                $returnData["redirectUrl"] = '/dziekujemy-za-zakup?orderIdentity=' . $order[0]->identity;
                            }
                        }
                        
                        if ($returnData['status']){
                            $emailVariables = [];
                            $emailVariables['basket'] = $basket;
                            $emailVariables['order'] = $order[0];
                            $emailVariables['delivery'] = $delivery[0];
                            $emailVariables['date'] = date('Y-m-d H:i:s');
                            $emailsArray = [$buyFormEmail];
                            $email = new Email($emailsArray, 'Potwierdzenie złożenia nowego zamówienia', 'emails/order-confirm-mail', $emailVariables);
                            $email->send();
                            
                            
                            DB::connection('mysql-esklep')->table('ecommerce_basket_position')->where('basket_id', $basket->id)->delete();
                            DB::connection('mysql-esklep')->table('ecommerce_basket')->where('id', $basket->id)->delete();
                            
                        }
                    } else {
                        $returnData['errors'][] = 'Nie można zrealizować zakupu - metoda dostawy nie istnieje. Odśwież stronę i spróbuj ponownie, jeżeli problem będzie się powtarzać skontaktuj się z obsługą klienta';
                        $returnData['errorsAreas'][] = '';
                        $returnData['status'] = false;
                    }
                } else {
                    $returnData['errors'][] = 'Nie można zrealizować zakupu - metoda dostawy nie istnieje. Odśwież stronę i spróbuj ponownie, jeżeli problem będzie się powtarzać skontaktuj się z obsługą klienta';
                    $returnData['errorsAreas'][] = '';
                    $returnData['status'] = false;
                }
                
            
        }
        
        return \Response::json($returnData, 200);
    }
    
    
    public function payNowAction($orderId){
        
        $response = [
            'status' => false,
            'error' => '',
            'redirectUrl' => ''
        ];
        
        $order = DB::connection('mysql-esklep')->select('SELECT * FROM ecommerce_orders WHERE id = ?', [$orderId]);
        if (count($order) > 0){
            
            $order = $order[0];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,Config::get('constants.paynow_url'));
            curl_setopt($ch, CURLOPT_POST, 1);

            $postArray = [];
            $priceGross = round(floatval($order->value_gross) * 100);

            $priceGross = intVal($priceGross);

            $postArray['amount'] = $priceGross;
            $postArray['currency'] = 'PLN';
            $postArray['externalId'] = $order->name;
            $postArray['description'] = 'Opłata za zamówienie nr ' . $order->name;
            $postArray['continueUrl'] = Config::get('constants.paynow_thankyou_page') . '?orderIdentity=' . $order->identity;
            $postArray['buyer'] = [
                'email' => $order->email
            ];
            /*$postArray['transfers'] = [
                [
                    "sellerId" => "MB9-CWR-7R9-QMP",
                    "grossAmount" => $priceGross,
                    "feeAmount" => "0"
                ]
            ];*/


            $postString = json_encode($postArray, JSON_UNESCAPED_SLASHES);

            //old signature v1
            /*$signature = hash_hmac('SHA256', $postString, Config::get('constants.paynow_signature_key'), true);
            $signature = base64_encode($signature);*/
            
            $signatureBody = [
                'headers' => [
                    'Api-Key' => Config::get('constants.paynow_api_key'),
                    'Idempotency-Key' => $order->name,
                ],
                'parameters' => new \stdClass(),
                'body' => json_encode($postArray, JSON_UNESCAPED_SLASHES)
            ];

            $signature = base64_encode(hash_hmac('sha256', json_encode($signatureBody, JSON_UNESCAPED_SLASHES), Config::get('constants.paynow_signature_key'), true));

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Api-Key: ' . Config::get('constants.paynow_api_key'),
                'Signature: ' . $signature,
                'Idempotency-Key: ' . $order->name,
                'Host: ' . Config::get('constants.paynow_host'),
                'Accept: ' . '*/*',
                'Content-Type: ' . 'application/json',
            ));

            //curl_setopt($ch, CURLOPT_USERPWD, 'esklep' . ":" . 'b*&4[Hv@');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            
            /*var_dump($httpcode);
            var_dump(curl_error($ch));
            var_dump($server_output);die();*/

            
            $errorDetails = '';

            if ($httpcode == 201){
                if ($this->isJson($server_output)){
                    $details = json_decode($server_output,true);
                    if (isset($details["redirectUrl"]) && isset($details["paymentId"]) && isset($details["status"])){
                        $response['status'] = true;
                        $response['url'] = $details["redirectUrl"];
                        $updateOrder = DB::connection('mysql-esklep')->update('UPDATE ecommerce_orders SET paynow_id=?, paynow_error=?, paynow_payment_status=? WHERE id=?', 
                                [$details["paymentId"], '', $details["status"],  $orderId]);
                    }
                }
            } else {
                if ($this->isJson($server_output)){
                    $details = json_decode($server_output,true);
                    if (isset($details["errors"]) && is_array($details["errors"])){
                        foreach ($details["errors"] as $error){
                            if (isset($error["errorType"])){
                                $errorDetails = $errorDetails . ' ' . $error["errorType"];
                            }
                            if (isset($error["message"])){
                                $errorDetails = $errorDetails . ' - ' . $error["message"] . ' ;';
                            }
                        }
                    } else if (isset($details["errors"]) && is_string($details["errors"])){
                        $errorDetails = $details["errors"];
                    }
                }

                $response['error'] = 'Wystąpił nieoczekiwany błąd podczas próby komunikacji z pośrednikiem płatności. Spróbuj ponownie lub skontaktuj się z obsługą klienta w celu rozwiązania problemu. ' . $httpcode;
            }

            if (!$response['status']){
                if ($errorDetails == ''){
                    $errorDetails = 'Nieznany błąd';
                }
                
                $updateOrder = DB::connection('mysql-esklep')->update('UPDATE ecommerce_orders SET paynow_error=? WHERE id=?', 
                                [$errorDetails,  $orderId]);
            }

        } else {
            $response['error'] = 'Nie udało się wygenerować linku do płatności';
        }

        return $response;
    }
    
    private function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
    
    public function signToNewsletter(Request $request){
        $request = $request->all();
        $returnData = [
            "status" => true,
            "errors" => [],
            "errorsAreas" => []
        ];
        
        if (isset($request['rules']) && $request['rules'] == 1) {
        
            if (isset($request['email'])){
                $email = $request['email'];
                if (!str_contains($email,'@')){
                    $returnData['errors'][] = 'Adres e-mail ma niewłaściwy format';
                    $returnData['errorsAreas'][] = 'footer-newsletter-email';
                    $returnData['status'] = false; 
                } else {
                    $exitEmail = DB::connection('mysql-esklep')->select('SELECT * FROM newsletter WHERE email = ?', [$email]);

                    if (count($exitEmail) == 0){

                        DB::connection('mysql-esklep')->insert('INSERT INTO newsletter '
                                        . '(email, created, updated, is_agree)'
                                        . ' VALUES (?,?,?,?)', 
                                        [$email, date('Y-m-d H:i:s'),date('Y-m-d H:i:s'), 1]);

                    } else {
                        $returnData["status"] = false;
                        $returnData["errors"][]= 'Adres e-mail jest już zapisany na newsletter';
                        $returnData[][] = "footer-newsletter-email"; 
                    }
                }
            } else {
                $returnData["status"] = false;
                $returnData["errors"][]= 'Adres e-mail jest polem obowiązkowym';
                $returnData[][] = "footer-newsletter-email";
            }
        } else {
            $returnData["status"] = false;
            $returnData["errors"][]= 'Akceptacja regulaminu jest polem obowiązkowym';
            $returnData[][] = "footer-newsletter-email";
        }
        
        return \Response::json($returnData, 200);
    }
    
}
