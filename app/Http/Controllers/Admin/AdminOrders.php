<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Models\Products;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Http\Controllers\Cms\TableList;
use App\Http\Controllers\Cms\TableEdit;

class AdminOrders extends Controller
{
    public function __construct()
    {

    }
    
    public function showOrdersList(Request $request){
        $requestData = $request->all();
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => '/panel/orders-list',
            'name' => 'Zamówienia'
        ];
        
        
        if (isset($requestData['date-from'])){
            $data_start = $requestData['date-from'];
        } else {
            $data_start = Carbon::now()->subMonths(1)->toDateString();
        }
        if (isset($requestData['date-to'])){
            $data_koniec = $requestData['date-to'];
        } else {
            $data_koniec = Carbon::now()->toDateString();
        }
        
        $viewData['data_start'] = $data_start;
        $viewData['data_koniec'] = $data_koniec;
        
        $searchCondition = '';
        $searchValue = '';
        if (isset($requestData['searchValue']) && $requestData['searchValue'] != '' && $requestData['searchValue'] != null){
            $searchValue = $requestData['searchValue'];
            $searchCondition = " AND (name like '%".$searchValue."%'"
                    . " OR name like '%".$searchValue."%'"
                    . " OR CONCAT_WS(' ', delivery_street, delivery_house_number, delivery_city, delivery_zip_code) LIKE '%".$searchValue."%'"
                    . " OR delivery_street like '%".$searchValue."%'"
                    . " OR delivery_city like '%".$searchValue."%'"
                    . " OR delivery_zip_code like '%".$searchValue."%'"
                    . " OR recipient like '%".$searchValue."%'"
                    . " OR email like '%".$searchValue."%'"
                    . " OR name like '%".$searchValue."%')";
        }
        $viewData['searchValue'] = $searchValue;
        
        $searchStatus = '';
        if (isset($requestData['searchStatus']) && $requestData['searchStatus'] != '' && $requestData['searchStatus'] != null){
            $searchStatus = $requestData['searchStatus'];
            $searchCondition = $searchCondition . " AND status = '".$requestData['searchStatus']."'";
        }
        $viewData['searchStatus'] = $searchStatus;
        
        $searchPaymentStatus = '';
        if (isset($requestData['searchPaymentStatus']) && $requestData['searchPaymentStatus'] != '' && $requestData['searchPaymentStatus'] != null){
            $searchPaymentStatus = $requestData['searchPaymentStatus'];
            if ($requestData['searchPaymentStatus'] == 'CONFIRMED'){
                $searchCondition = $searchCondition . " AND paynow_payment_status = 'CONFIRMED'";
            } else {
                $searchCondition = $searchCondition . " AND paynow_payment_status <> 'CONFIRMED'";
            }
        }
        $viewData['searchPaymentStatus'] = $searchPaymentStatus;
        
        $orders = DB::connection('mysql-esklep')->select("
            SELECT id, name, order_date, status, value_gross,delivery_street, delivery_house_number, delivery_city, delivery_zip_code, recipient, phone, email, paynow_payment_status
            FROM ecommerce_orders where order_date >= ? AND order_date <= ? ".$searchCondition."
            Order BY order_date desc ", [
            $data_start . ' 00:00:00',
            $data_koniec . ' 23:59:59'
        ]);
        $viewData['orders'] = $orders;
        
        return view('admin/orders-list',$viewData);
    }
    
    public function editOrder(Request $request, $id){
        /*$requestData = $request->all();
        $viewData = [];
        
        $viewData['breadCrub1'] = [
            'url' => '/panel/orders-list',
            'name' => 'Zamówienia'
        ];
        
        return view('admin/edit-order',$viewData);*/
        $edit = new TableEdit('AdminOrders');

        return $edit->render($id);
    }
    
    public function downloadCsv($array, $filename = "export.csv", $delimiter=";"){
        header( 'Content-Type: application/csv' );
        header( 'Content-Disposition: attachment; filename="' . $filename . '";' );

        //ob_end_clean();
        $handle = fopen( 'php://output', 'w' );
        
        foreach ( $array as $value ) {
            fputcsv( $handle, $value, $delimiter );
        }

        fclose( $handle );


        exit();
    }
    
    public function preparePharmalinkFile(Request $request){
        $requestData = $request->all();
        
        if (isset($requestData['ids'])){
            $ids = $requestData['ids'];
        } else {
            echo 'brak zmaówień do wyświetlenia';
            die();
        }
        
        $dpdOrdersArray[] = [
            'ID_NADAWCA',
            'NADAWCA_NAZWA',
            'NADAWCA_SKROT_NAZWY',
            'NADAWCA_KOD_POCZTOWY',
            'MIEJSCOWOSC',
            'ULICA',
            'NADAWCA_KRAJ',
            'NADAWCA_KOD_OBCY',
            'NADAWCA_TELEFON',
            'NADAWCA_NIP',
            'ID_ODBIORCY',
            'ODBIORCA_NAZWA',
            'ODBIORCA_SKROT_NAZWY',
            'ODBIORCA_KOD_POCZTOWY',
            'OBDIORCA_MIEJSCOWOSC',
            'ODBIORCA_ULICA',
            'ODBIORCA_KRAJ',
            'ODBIORCA_KOD_OBCY',
            'ODBIORCA_TELEFON',
            'ODBIORCA_NIP',
            'ID_KONTRAHENT_DOSTAWA',
            'K_DOSTAWA_NAZWA',
            'K_DOSTAWA_SKROT_NAZWY',
            'K_DOSTAWA_KOD_POCZTOWY',
            'K_DOSTAWA_MIEJSCOWOSC',
            'K_DOSTAWA_ULICA',
            'K_DOSTAWA_KRAJ',
            'K_DOSTAWA_KOD_OBCY',
            'K_DOSTAWA_TELEFON',
            'K_DOSTAWA_NIP',
            'ID_PLATNIK',
            'PLATNIK_NAZWA',
            'PLATNIK_SKROT_NAZWY',
            'PLATNIK_KOD_POCZTOWY',
            'PLATNIK_MIEJSCOWOSC',
            'PLATNIK_ULICA',
            'PLATNIK_KRAJ',
            'PLATNIK_KOD_OBCY',
            'PLATNIK_TELEFON',
            'PLATNIK_NIP',
            'UWAGI_DOSTAWAA',
            'TOWAR',
            'KL_0',
            'KL_1',
            'KL_2',
            'KL_3',
            'KL_4_KARTONY_30KG',
            'LI_1',
            'LI_2',
            'LI_3',
            'LI_4',
            'PALETY_150',
            'PALETY_400',
            'PALETY_750',
            'PALETY_1000',
            'OPAKOWANIE_IZO_NAD',
            'OPAKOWANIE_ZWR_UST_S',
            'OPAKOWANIE_ZWR_URT_M',
            'OPAKOWANIE_ZWR_URT_L',
            'ZWROT_DOK',
            'ILOSC_DOK',
            'ZWROT_PALET',
            'SM',
            'UBEZPIECZENIE',
            'WARTOSC',
            'KWOTA_FRAHT',
            'KWOTA_POBR',
            'GODZ_DOST',
            'TEMPERATURA_PRZEWOZU',
            'TRASA_UWAGI',
            'DATA_DOSTAWY',
            'MPK',
            'POBR_USLUG_TRANSP',
            'REJESTRATOR',
            'WAGA',
            'PREAWIZACJA_TELEFON',
            'PREAWIZACJA_MAIL',
            'GODZ_DOST_EMAIL',
            'WLNK',
            'EMAIL_POTW_WPL',
            'PALZW',
            'PALEU',
            'TYP',
            'TYP_UWAGI',
            'PIN_POTWIERDZENIE',
            'PIN_TELEFON',
            'PIN_MAIL'

        ];
        
        $orders = DB::connection('mysql-esklep')->select("SELECT ecommerce_orders.*, ecommerce_delivery_method.name as delivery_method
            FROM ecommerce_orders 
            LEFT JOIN ecommerce_delivery_method on ecommerce_delivery_method.id = ecommerce_orders.delivery_method_id
            WHERE ecommerce_orders.id IN ( ".$ids." ) 
            Order BY order_date desc ", [
        ]);
        
        foreach ($orders as $order){
            if ($order->delivery_method_id == 7 ){
                $nameSurname = $order->recipient; 
                $name = explode(' ',$nameSurname)[0];
                $surname = '';
                if (isset(explode(' ',$nameSurname)[1])){
                    $surname = explode(' ',$nameSurname)[1];
                }
                $number = $order->delivery_house_number;
                $houseNumber = explode('/',$number)[0];
                $flatNumber = '';
                if (isset(explode('/',$number)[1])){
                    $flatNumber = explode('/',$number)[1];
                }
                $deliveryType = 'paczkomat';
                if ($order->delivery_method_id == 3){
                    $deliveryType = 'kurier';
                }
                        
                
                $destinationCode = '';
                preg_match('/wybrany punkt: [a-zA-Z0-9]{1,9} /',$order->paczkomat_details,$matches);
                if (count($matches)>0){
                    $destinationCode = $matches[0];
                    $destinationCode = str_replace('wybrany punkt: ','',$destinationCode);
                    $destinationCode = str_replace(' ','',$destinationCode);
                }

                $oneItem = [
                    1,//ID_NADAWCA',
                    'Apteka Internetowa Wracam do Zdrowia',//'NADAWCA_NAZWA',
                    'Apteka Internetowa Wracam do Zdrowia',//'NADAWCA_SKROT_NAZWY',
                    '81-509',//'NADAWCA_KOD_POCZTOWY',
                    'Gdynia',//'MIEJSCOWOSC',
                    'Plac Górnośląski 16',//'ULICA',
                    'Polska',//'NADAWCA_KRAJ',
                    '',//'NADAWCA_KOD_OBCY',
                    '798002314',//'NADAWCA_TELEFON',
                    $order->vat_number,//'NADAWCA_NIP',
                    $order->identity,//'ID_ODBIORCY',
                    $order->recipient . ' ' . $order->company_name,//'ODBIORCA_NAZWA',
                    '',//'ODBIORCA_SKROT_NAZWY',
                    $order->delivery_zip_code,//'ODBIORCA_KOD_POCZTOWY',
                    $order->delivery_city,//'OBDIORCA_MIEJSCOWOSC',
                    $order->delivery_street . ' ' . $order->delivery_house_number,//'ODBIORCA_ULICA',
                    'Polska',//'ODBIORCA_KRAJ',
                    $order->delivery_zip_code,//'ODBIORCA_KOD_OBCY',
                    $order->phone,//'ODBIORCA_TELEFON',
                    $order->vat_number,//'ODBIORCA_NIP',
                    '',//'ID_KONTRAHENT_DOSTAWA',
                    '',//'K_DOSTAWA_NAZWA',
                    '',//'K_DOSTAWA_SKROT_NAZWY',
                    '',//'K_DOSTAWA_KOD_POCZTOWY',
                    '',//'K_DOSTAWA_MIEJSCOWOSC',
                    '',//'K_DOSTAWA_ULICA',
                    '',//'K_DOSTAWA_KRAJ',
                    '',//'K_DOSTAWA_KOD_OBCY',
                    '',//'K_DOSTAWA_TELEFON',
                    '',//'K_DOSTAWA_NIP',
                    1,//'ID_PLATNIK',
                    '',//'PLATNIK_NAZWA',
                    '',//'PLATNIK_SKROT_NAZWY',
                    '',//'PLATNIK_KOD_POCZTOWY',
                    '',//'PLATNIK_MIEJSCOWOSC',
                    '',//'PLATNIK_ULICA',
                    '',//'PLATNIK_KRAJ',
                    '',//'PLATNIK_KOD_OBCY',
                    '',//'PLATNIK_TELEFON',
                    '',//'PLATNIK_NIP',
                    '',//'UWAGI_DOSTAWAA',
                    '',//'TOWAR',
                    '',//'KL_0',
                    1,//'KL_1',
                    0,//'KL_2',
                    0,//'KL_3',
                    0,//'KL_4_KARTONY_30KG',
                    0,//'LI_1',
                    0,//'LI_2',
                    0,//'LI_3',
                    0,//'LI_4',
                    0,//'PALETY_150',
                    0,//'PALETY_400',
                    0,//'PALETY_750',
                    0,//'PALETY_1000',
                    '',//'OPAKOWANIE_IZO_NAD',
                    '',//'OPAKOWANIE_ZWR_UST_S',
                    '',//'OPAKOWANIE_ZWR_URT_M',
                    '',//'OPAKOWANIE_ZWR_URT_L',
                    '',//'ZWROT_DOK',
                    '',//'ILOSC_DOK',
                    '',//'ZWROT_PALET',
                    '',//'SM',
                    '',//'UBEZPIECZENIE',
                    '',//'WARTOSC',
                    '',//'KWOTA_FRAHT',
                    '',//'KWOTA_POBR',
                    '',//'GODZ_DOST',
                    25,//'TEMPERATURA_PRZEWOZU',
                    '',//'TRASA_UWAGI',
                    '',//'DATA_DOSTAWY',
                    '',//'MPK',
                    '',//'POBR_USLUG_TRANSP',
                    '',//'REJESTRATOR',
                    '',//'WAGA',
                    '',//'PREAWIZACJA_TELEFON',
                    '',//'PREAWIZACJA_MAIL',
                    '',//'GODZ_DOST_EMAIL',
                    '',//'WLNK',
                    '',//'EMAIL_POTW_WPL',
                    '',//'PALZW',
                    '',//'PALEU',
                    '',//'TYP',
                    '',//'TYP_UWAGI',
                    '',//'PIN_POTWIERDZENIE',
                    '',//'PIN_TELEFON',
                    '',//'PIN_MAIL
                ];
                $dpdOrdersArray[] = $oneItem;
            }
        }
        
        $this->downloadCsv($dpdOrdersArray, "pharmalink-export.csv", ";");
    }
    
    public function prepareInpostFile(Request $request){
        $requestData = $request->all();
        
        if (isset($requestData['ids'])){
            $ids = $requestData['ids'];
        } else {
            echo 'brak zmaówień do wyświetlenia';
            die();
        }
        
        $dpdOrdersArray[] = [
            'e-mail',
            'telefon',
            'rozmiar',
            'paczkomat',
            'numer_referencyjny',
            'dodatkowa_ochrona',
            'za_pobraniem',
            'imie_i_nazwisko',
            'nazwa_firmy',
            'ulica',
            'kod_pocztowy',
            'miejscowosc',
            'typ_przesylki',
            'paczka_w_weekend',
        ];
        
        $orders = DB::connection('mysql-esklep')->select("SELECT ecommerce_orders.*, ecommerce_delivery_method.name as delivery_method
            FROM ecommerce_orders 
            LEFT JOIN ecommerce_delivery_method on ecommerce_delivery_method.id = ecommerce_orders.delivery_method_id
            WHERE ecommerce_orders.id IN ( ".$ids." ) 
            Order BY order_date desc ", [
        ]);
        
        if (count($orders) > 0){

            foreach ($orders as $order){
                if ($order->delivery_method_id == 3 || $order->delivery_method_id == 5){
                    $nameSurname = $order->recipient; 
                    $name = explode(' ',$nameSurname)[0];
                    $surname = '';
                    if (isset(explode(' ',$nameSurname)[1])){
                        $surname = explode(' ',$nameSurname)[1];
                    }
                    $number = $order->delivery_house_number;
                    $houseNumber = explode('/',$number)[0];
                    $flatNumber = '';
                    if (isset(explode('/',$number)[1])){
                        $flatNumber = explode('/',$number)[1];
                    }
                    $deliveryType = 'paczkomat';
                    if ($order->delivery_method_id == 3){
                        $deliveryType = 'kurier';
                    }


                    $destinationCode = '';
                    preg_match('/wybrany punkt: [a-zA-Z0-9]{1,9} /',$order->paczkomat_details,$matches);
                    if (count($matches)>0){
                        $destinationCode = $matches[0];
                        $destinationCode = str_replace('wybrany punkt: ','',$destinationCode);
                        $destinationCode = str_replace(' ','',$destinationCode);
                    }

                    $oneItem = [
                        $order->email,
                        $order->phone,
                        'A',
                        $destinationCode,
                        'esklep wdoz',
                        0,
                        0,
                        $order->recipient,
                        $order->company_name,
                        $order->delivery_street . ' ' . $order->delivery_house_number,
                        $order->delivery_zip_code,
                        $order->delivery_city,
                        $deliveryType,
                        'NIE'
                    ];
                    $dpdOrdersArray[] = $oneItem;
                }
            }
        } else {
            echo 'brak zamówień spełniających kryteria';
        }
        
        
        if (count($dpdOrdersArray) > 1){
            $this->downloadCsv($dpdOrdersArray, "dpd-export.csv", ";");
        } else {
            echo 'brak zamówień spełniających kryteria';
        }
    }
    
    public function prepareDpdFile(Request $request){
        $requestData = $request->all();
        
        if (isset($requestData['ids'])){
            $ids = $requestData['ids'];
        } else {
            echo 'brak zmaówień do wyświetlenia';
            die();
        }
        
        $dpdOrdersArray[] = [
            'Nazwa',
            'Ulica',
            'Kod pocztowy',
            'Miasto',
            'Telefon',
            'Waga',
            'Kwota COD',
            'Zawartość',
            'Imię i nazwisko odbiorcy',
            'E-mail'
        ];
        
        
        $orders = DB::connection('mysql-esklep')->select("SELECT ecommerce_orders.*, ecommerce_delivery_method.name as delivery_method
            FROM ecommerce_orders 
            LEFT JOIN ecommerce_delivery_method on ecommerce_delivery_method.id = ecommerce_orders.delivery_method_id
            WHERE ecommerce_orders.id IN ( ".$ids." ) 
            Order BY order_date desc ", [
        ]);
        if (count($orders) > 0){

            foreach ($orders as $order){
                if ($order->delivery_method_id == 2){
                    $nameSurname = $order->recipient; 
                    $name = explode(' ',$nameSurname)[0];
                    $surname = '';
                    $exploded = explode(' ',$nameSurname);
                    if (isset($exploded[1])){
                        foreach ($exploded as $i => $part){
                            if ($i > 0){
                                $surname = $surname . $part . ' ';
                            }
                        }
                    }
                    $number = $order->delivery_house_number;
                    $houseNumber = explode('/',$number)[0];
                    $flatNumber = '';
                    if (isset(explode('/',$number)[1])){
                        $flatNumber = explode('/',$number)[1];
                    }

                    $name = $order->company_name;
                    if ($name == '' || $name == null){
                        $name = $order->recipient;
                    }

                    $oneItem = [
                        $name,
                        $order->delivery_street . ' ' . $order->delivery_house_number,
                        $order->delivery_zip_code,
                        $order->delivery_city,
                        $order->phone,
                        1,
                        0,
                        'leki/produkty lecznicze/suplementy diety',
                        $order->recipient,
                        $order->email,

                    ];
                    $dpdOrdersArray[] = $oneItem;
                }
            }
        } else {
            echo 'brak zamówień spełniających kryteria';
        }
        
        
        if (count($dpdOrdersArray) > 1){
            $this->downloadCsv($dpdOrdersArray, "dpd-export.csv", ";");
        } else {
            echo 'brak zamówień spełniających kryteria';
        }
        
    }
    
    public function printOrdersOrlen(Request $request){
        $requestData = $request->all();
        
        if (isset($requestData['ids'])){
            $ids = $requestData['ids'];
        } else {
            echo 'brak zmaówień do wyświetlenia';
            die();
        }
        
        $orders = DB::connection('mysql-esklep')->select("SELECT ecommerce_orders.*, ecommerce_delivery_method.name as delivery_method
            FROM ecommerce_orders 
            LEFT JOIN ecommerce_delivery_method on ecommerce_delivery_method.id = ecommerce_orders.delivery_method_id
            WHERE ecommerce_orders.id IN ( ".$ids." ) 
            Order BY order_date desc ", [
        ]);
        
        $orlenOrdersArray = [];
        $orlenOrdersArray[] = [
            'OrderID',
            'DestinationCode',
            'PSD',
            'EMail',
            'FirstName',
            'LastName',
            'CompanyName',
            'StreetName',
            'BuildingNumber',
            'FlatNumber',
            'City',
            'PostCode',
            'PhoneNumber',
            'CashOnDelivery',
            'CashOnDeliveryValue',
            'TransferDescription',
            'Insurance',
            'InsuranceValue'
        ];
        
        if (count($orders) > 0){
            foreach ($orders as $order){
                if ($order->delivery_method_id == 6){
                    $nameSurname = $order->recipient; 
                    $name = explode(' ',$nameSurname)[0];
                    $surname = '';
                    if (isset(explode(' ',$nameSurname)[1])){
                        $surname = explode(' ',$nameSurname)[1];
                    }
                    $number = $order->delivery_house_number;
                    $houseNumber = explode('/',$number)[0];
                    $flatNumber = '';
                    if (isset(explode('/',$number)[1])){
                        $flatNumber = explode('/',$number)[1];
                    }

                    $DestinationCode = '';
                    preg_match('/[a-zA-Z0-9]{1,5}\-[a-zA-Z0-9]{1,9}\-[a-zA-Z0-9]{1,9}\-[a-zA-Z0-9]{1,9}/',$order->paczkomat_details,$matches);
                    if (count($matches)>0){
                        $DestinationCode = $matches[0];
                    }

                    $oneItem = [
                        $order->name,
                        $DestinationCode,
                        '123456',
                        $order->email,
                        $name,
                        $surname,
                        $order->company_name,

                        $order->delivery_street,
                        $houseNumber,
                        $flatNumber,
                        $order->delivery_city,
                        $order->delivery_zip_code,
                        $order->phone,
                        'NIE',
                        0,
                        'Wracam do Zrowia - zamówienie nr ' . $order->name,
                        'NIE',
                        0,
                    ];
                    $orlenOrdersArray[] = $oneItem;
                }
            }
            
            if (count($orlenOrdersArray) > 1){
                $this->downloadCsv($orlenOrdersArray, "orlen-export.csv", ";");
            } else {
                echo 'brak zamówień spełniających kryteria';
            }

            
        } else {
            echo 'brak zamówień spełniających kryteria';
        }
    }
    
    public function printOrders(Request $request){
        $requestData = $request->all();
        
        if (isset($requestData['ids'])){
            $ids = $requestData['ids'];
        } else {
            echo 'brak zmaówień do wyświetlenia';
            die();
        }
        
        $orders = DB::connection('mysql-esklep')->select("SELECT ecommerce_orders.*, ecommerce_delivery_method.name as delivery_method
            FROM ecommerce_orders 
            LEFT JOIN ecommerce_delivery_method on ecommerce_delivery_method.id = ecommerce_orders.delivery_method_id
            WHERE ecommerce_orders.id IN ( ".$ids." ) 
            Order BY order_date desc ", [
        ]);
        
        
        
        
        
        echo '<style>';
        echo '@page size: A4 landscape;}

          @media print { body,html,#wrapper {
              width: 100%;
            }
            .page-breaker {clear: both;;page-break-after: always; height:2px;}
          }
          .page-breaker {clear: both;;page-break-after: always; height:2px;}
          body,html {
            width: 100%;
            max-width: 900px;
            font-size: 14px;
            font-weight: 100;
          }
          table{
          width: calc(100% - 15px);
          border: 1px solid black;
          colspan: 0px;
          border-collapse: collapse;
          margin-bottom: 40px;
          page-break-inside: avoid;
          }
          td{
          border: 2px solid black;
          padding: 5px 6px;
          }
          .label{
          color: gray;
          }
          .lp{
          width: 15px;
          display: inline-block;
          color: gray
          }
          .count{
          width: 35px;
          display: inline-block;
          text-align:center;
          font-weight: 900
          }
          .price-sumary{
            width: calc( 100% - 175px);
            text-align: right;
            display: inline-block;
            padding-right: 10px;
          }
          .product-content{
          width: calc( 100% - 200px);
          display: inline-block;
          font-size: 17px;
          font-weight: 900;
          }';
        echo '</style>';

        
        foreach ($orders as $order){
            echo '</pre>';
            echo '<table colspan="0">';
            
            $paczkomatDetails = '';
            if ($order->paczkomat_details != null){
                $paczkomatDetails = ', paczkomat ' . $order->paczkomat_details;
            }
            
            if ($order->delivery_method == 'DPD - kurier'
                    || $order->delivery_method == 'InPost - kurier'
                    || $order->delivery_method == 'Pharmalink - kurier'){
                $paczkomatDetails = '';
            }
            
            $paymentType = $order->payment_type;
            if ($paymentType == 'on'){
                $paymentType = 'przelew tradycyjny';
            }
            if ($paymentType == 'przelewpaynow'){
                $paymentType = 'płatność PayNow';
            }
            
            echo "<tr><td>" . $order->order_date . "</td><td colspan='2'><span class='label'>nr: </span> " . $order->name . "</td><td><span class='label'>status płatności:</span> " . $order->paynow_payment_status . "</td></tr>";
            echo "<tr><td colspan='2'><span class='label'>imie i nazwisko:</span> " . $order->recipient . "</td><td colspan='2'><span class='label'>metoda płatności:</span> " .$paymentType. "</td></tr>";
            echo "<tr><td colspan='2'><span class='label'>telefon:</span> " . $order->phone . "</td><td colspan='2'><span class='label'>e-mail:</span> " . $order->email . "</td></tr>";
            echo "<tr><td colspan='2'><span class='label'>metoda dostawy:</span> " . $order->delivery_method . "</td><td colspan='2'><span class='label'>koszt dostway:</span> " . $order->delivery_cost . "zł</td></tr>";
            echo "<tr><td colspan='4'><span class='label'>adres dostawy:</span>" . $order->delivery_data . $paczkomatDetails . "</td></tr>";
            if ($order->with_invoice){
                if ($order->vat_number == '' || $order->vat_number == null){
                    echo "<tr><td colspan='4'><span class='label'>dane do faktury (na osobę fizyczną):</span>".$order->company_name.", ".$order->town." ".$order->postal_code." ".$order->street." ".$order->house_number." "."</td></tr>";
                } else {
                    echo "<tr><td colspan='4'><span class='label'>dane do faktury (na firmę):</span>".$order->company_name.", nip: ".$order->vat_number." ".$order->town." ".$order->postal_code." ".$order->street." ".$order->house_number." "."</td></tr>";
                }
                
            } else{
                echo "<tr><td colspan='4'><span class='label'>faktura:</span>NIE</td></tr>";
            }
            
            $products = DB::connection('mysql-esklep')->select("SELECT ecommerce_order_position.*, ecommerce_products.*
                FROM ecommerce_order_position
                LEFT JOIN ecommerce_products on ecommerce_products.id = ecommerce_order_position.product_id
                WHERE ecommerce_order_position.order_id = ?
                Order BY ecommerce_order_position.id ", [$order->id
            ]);
            
            foreach ($products as $i => $product){
                $licz = $i+1;
                
                $expirationdate = '';
                if ($product->expiration_date != '' && $product->expiration_date != null){
                    $expirationdate = ' <span style="color: gray;">( Data ważności: ' . $product->expiration_date . ' )</span>';
                }
                echo "<tr><td colspan='4'><div class='count'>" .  $product->quantity . ' x</div><div class="product-content"> ' . $product->name . " " . $product->brand . " " . $product->content. " " . $expirationdate . "</div>" . $product->price_gross . ' x ' . $product->quantity . ' = ' . $product->value_gross. "zł</td></tr>";
            }
            echo "<tr><td colspan='4'><div class='price-sumary'>suma brutto (produkty + koszt przesyłki):</div>" . $order->value_gross . "zł</td></tr>";
            echo '</table><br>';
            echo '<br>';
            echo "<div class='page-breaker'></div>";
        }
        die();
    }
    
    public function changeOrdresStatuses(Request $request){
        $requestData = $request->all();
        
        $response = [
            'status' => true,
            'errors' => []
        ];
        if (isset($requestData['ids'])){
            $ids = $requestData['ids'];
        } else {
            $ids = null;
            $response['errors' ]= 'brak zmaówień do zmiany statusu';
        }
        $status = $requestData['status'];
        
        if ($ids != null && $status != null && $status != ''){
            $orders = DB::connection('mysql-esklep')->select("SELECT ecommerce_orders.*
                FROM ecommerce_orders 
                WHERE ecommerce_orders.id IN ( ".implode(', ', $ids)." ) 
                Order BY order_date desc ", [
            ]);

            foreach ($orders as $order){
                if ($status != $order->status){
                    DB::connection('mysql-esklep')->update(
                        "update ecommerce_orders set status=? 
                             WHERE id=? ", //
                        [
                            $status, $order->id
                        ]
                    );
                    $basket = new \stdClass();
                    $basket->basketItems = DB::connection('mysql-esklep')->select("SELECT ecommerce_order_position.*
                        FROM ecommerce_order_position 
                        WHERE ecommerce_orders.order_id = ? 
                        ", [ $order->id
                    ]);
                    $emailVariables = [];
                    $emailVariables['basket'] = $basket;
                    $emailVariables['order'] = $order[0];
                    $emailVariables['delivery'] = $delivery[0];
                    $emailVariables['date'] = date('Y-m-d H:i:s');
                    $emailsArray = [$order->email ]; //'eapteka@wdoz.pl'
                    $email = new Email($emailsArray, 'Zmiana statusu zamówienia', 'emails/order-confirm-mail', $emailVariables);
                    $email->send();
                }
            }
        }
        
        return response()->json($response);
    }

}
