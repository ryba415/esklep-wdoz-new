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
    
    public function printOrders(){

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
        $orders = $this->getOrders($ids);
        
        foreach ($orders as $order){
            echo '</pre>';
            echo '<table colspan="0">';
            
            $paczkomatDetails = '';
            if ($order->getPaczkomatDetails() != null){
                $paczkomatDetails = ', paczkomat ' . $order->getPaczkomatDetails();
            }
            
            if ($order->getDeliveryMethod() == 'DPD - kurier'
                    || $order->getDeliveryMethod() == 'InPost - kurier'
                    || $order->getDeliveryMethod() == 'Pharmalink - kurier'){
                $paczkomatDetails = '';
            }
            
            $paymentType = $order->getPaymentType();
            if ($paymentType == 'on'){
                $paymentType = 'przelew tradycyjny';
            }
            if ($paymentType == 'przelewpaynow'){
                $paymentType = 'płatność PayNow';
            }
            
            echo "<tr><td>" . $order->getOrderDate()->format('Y-m-d H:i:s') . "</td><td colspan='2'><span class='label'>nr: </span> " . $order->getOrderNumber() . "</td><td><span class='label'>status płatności:</span> " . $order->getPaynowPaymentStatus() . "</td></tr>";
            echo "<tr><td colspan='2'><span class='label'>imie i nazwisko:</span> " . $order->getRecipient() . "</td><td colspan='2'><span class='label'>metoda płatności:</span> " .$paymentType. "</td></tr>";
            echo "<tr><td colspan='2'><span class='label'>telefon:</span> " . $order->getPhone() . "</td><td colspan='2'><span class='label'>e-mail:</span> " . $order->getEmail() . "</td></tr>";
            echo "<tr><td colspan='2'><span class='label'>metoda dostawy:</span> " . $order->getDeliveryMethod() . "</td><td colspan='2'><span class='label'>koszt dostway:</span> " . $order->getDeliveryCost() . "zł</td></tr>";
            echo "<tr><td colspan='4'><span class='label'>adres dostawy:</span>" . $order->getDeliveryData() . $paczkomatDetails . "</td></tr>";
            if ($order->getWithInvoice()){
                if ($order->getNipNumber() == '' || $order->getNipNumber() == null){
                    echo "<tr><td colspan='4'><span class='label'>dane do faktury (na osobę fizyczną):</span>".$order->getCompanyName().", ".$order->getTown()." ".$order->getPostalCode()." ".$order->getStreet()." "."</td></tr>";
                } else {
                    echo "<tr><td colspan='4'><span class='label'>dane do faktury (na firmę):</span>".$order->getCompanyName().", nip: ".$order->getNipNumber()." ".$order->getTown()." ".$order->getPostalCode()." ".$order->getStreet()." "."</td></tr>";
                }
                
            } else{
                echo "<tr><td colspan='4'><span class='label'>faktura:</span>NIE</td></tr>";
            }
            foreach ($order->getOrderPositions() as $i => $product){
                $licz = $i+1;
                
                $expirationdate = '';
                if ($product->getExpirationDate() != '' && $product->getExpirationDate() != null){
                    $expirationdate = ' <span style="color: gray;">( Data ważności: ' . $product->getExpirationDate() . ' )</span>';
                }
                echo "<tr><td colspan='4'><div class='count'>" .  $product->getQuantity() . ' x</div><div class="product-content"> ' . $product->getProduct()->getName() . " " . $product->getProduct()->getBrand() . " " . $product->getProduct()->getContent(). $expirationdate . "</div>" . $product->getPriceGross() . ' x ' . $product->getQuantity() . ' = ' . $product->getValueGross(). "zł</td></tr>";
            }
            echo "<tr><td colspan='4'><div class='price-sumary'>suma brutto (produkty + koszt przesyłki):</div>" . $order->getValueGross() . "zł</td></tr>";
            echo '</table><br>';
            echo '<br>';
            echo "<div class='page-breaker'></div>";
        }
        die();
    }

}
