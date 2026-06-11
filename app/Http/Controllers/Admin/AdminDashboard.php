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

class AdminDashboard extends Controller
{
    public function __construct()
    {

    }



    public function showDashboard(Request $request){
//        phpinfo();
//        dd([
//            'gd_loaded' => extension_loaded('gd'),
//            'imagewebp' => function_exists('imagewebp'),
//            'imagecreatefromjpeg' => function_exists('imagecreatefromjpeg'),
//            'imagecreatefrompng' => function_exists('imagecreatefrompng'),
//            'gd_info' => function_exists('gd_info') ? gd_info() : null,
//        ]);
        return view('admin.dashboard');
    }

    public function slidersList(Request $request){
        $list = new TableList('AdminSliders');

        return $list->render($request);
    }

    public function editSlide($id){
        $edit = new TableEdit('AdminSliders');

        return $edit->render($id);
    }

    public function articlesList(Request $request){
        $list = new TableList('AdminArticles');

        return $list->render($request);
    }

    public function editArticle($id){
        $edit = new TableEdit('AdminArticles');

        return $edit->render($id);
    }

    public function articlesCategoryList(Request $request)
    {
        $list = new TableList('AdminArticlesCategory');
        return $list->render($request);
    }

    public function editArticlesCategory($id)
    {
        $edit = new TableEdit('AdminArticlesCategory');
        return $edit->render($id);
    }

    public function newsletterList(Request $request)
    {
        $list = new TableList('AdminNewsletter');
        return $list->render($request);
    }

    public function editNewsletter($id)
    {
        $edit = new TableEdit('AdminNewsletter');
        return $edit->render($id);
    }


    public function settingsList(Request $request)
    {
        $list = new TableList('AdminSettings');
        return $list->render($request);
    }

    public function editSetting($id)
    {
        $edit = new TableEdit('AdminSettings');
        return $edit->render($id);
    }

    public function usersList(Request $request)
    {
        $list = new TableList('AdminUsers');
        return $list->render($request);
    }

    public function editUser($id)
    {
        $edit = new TableEdit('AdminUsers');
        return $edit->render($id);
    }

    public function adminsList(Request $request)
    {
        $list = new TableList('AdminAdmins');
        return $list->render($request);
    }

    public function editAdmin($id)
    {
        $edit = new TableEdit('AdminAdmins');
        return $edit->render($id);
    }
    
    public function showStatistics(Request $request){
        $requestData = $request->all();
        
        $viewData = [];
        if (isset($requestData['date-from'])){
            $data_start = $requestData['date-from'];
        } else {
            $data_start = Carbon::now()->subMonths(6)->toDateString();
        }
        if (isset($requestData['date-to'])){
            $data_koniec = $requestData['date-to'];
        } else {
            $data_koniec = Carbon::now()->toDateString();
        }
        
        $statisticType = 'day';
        $letCondition = ' LEFT(order_date, 10) AS dzien, ';
        $gropByCondition = ' GROUP BY LEFT(order_date, 10) ';
        if (isset($requestData['type']) && $requestData['type'] == 'month'){
            $statisticType = $requestData['type'];
            $letCondition = ' LEFT(order_date, 7) AS dzien, ';
            $gropByCondition = ' GROUP BY LEFT(order_date, 7) ';
        }
        //$data_start = '2026-03-01';
        //$data_koniec = '2026-03-31';
        
        $viewData['data_start'] = $data_start;
        $viewData['data_koniec'] = $data_koniec;
        $viewData['statisticType'] = $statisticType;
        
        $allOrders = 0;
        $payyedOrders = 0;
        $payOrdersSumm = 0;

        // 1. Szybkie zapytanie w czystym SQL
        // Używamy "od - do" bezpośrednio na order_date, aby MySQL użył indeksu.
        $wyniki = DB::connection('mysql-esklep')->select("
            SELECT 
                ".$letCondition."
                COUNT(*) AS ilosc
            FROM ecommerce_orders
            WHERE order_date >= :start 
              AND order_date <= :koniec
            ".$gropByCondition."
        ", [
            'start' => $data_start . ' 00:00:00',
            'koniec' => $data_koniec . ' 23:59:59'
        ]);
        
        $wyniki2 = DB::connection('mysql-esklep')->select("
            SELECT 
                ".$letCondition."
                COUNT(*) AS ilosc
            FROM ecommerce_orders
            WHERE order_date >= :start 
              AND order_date <= :koniec
              AND  paynow_payment_status = 'CONFIRMED'
            ".$gropByCondition."
        ", [
            'start' => $data_start . ' 00:00:00',
            'koniec' => $data_koniec . ' 23:59:59'
        ]);
        
        $wyniki3 = DB::connection('mysql-esklep')->select("
            SELECT 
                ".$letCondition."
                SUM(value_gross) AS suma_wartosci
            FROM ecommerce_orders
            WHERE order_date >= :start 
              AND order_date <= :koniec
              AND paynow_payment_status = 'CONFIRMED'
            ".$gropByCondition."
        ", [
            'start' => $data_start . ' 00:00:00',
            'koniec' => $data_koniec . ' 23:59:59'
        ]);
        
        $wyniki4 = DB::connection('mysql-esklep')->select("
            SELECT 
                o.delivery_method_id,
                m.name AS nazwa_dostawy, 
                COUNT(o.id) AS ilosc_zamowien
            FROM ecommerce_orders o
            LEFT JOIN ecommerce_delivery_method m ON o.delivery_method_id = m.id 
            WHERE o.order_date >= :start 
              AND o.order_date <= :koniec
              AND paynow_payment_status = 'CONFIRMED'
            GROUP BY o.delivery_method_id, m.name 
            ORDER BY ilosc_zamowien DESC
        ", [
            'start' => $data_start . ' 00:00:00',
            'koniec' => $data_koniec . ' 23:59:59'
        ]);
        
        $viewData['deliveriesData'] = $wyniki4;

        // 2. Przekształcamy wyniki na tablicę asocjacyjną [data => ilosc]
        $wyniki_z_bazy = [];
        foreach ($wyniki as $row) {
            $wyniki_z_bazy[$row->dzien] = [];
            $wyniki_z_bazy[$row->dzien]['all'] = $row->ilosc;
            $allOrders = $allOrders + $row->ilosc;
        }
        foreach ($wyniki2 as $row) {
            $wyniki_z_bazy[$row->dzien]['payed'] = $row->ilosc;
            $payyedOrders = $payyedOrders + $row->ilosc;

        }
        foreach ($wyniki3 as $row) {
            $wyniki_z_bazy[$row->dzien]['summ'] = $row->suma_wartosci;
            $payOrdersSumm = $payOrdersSumm + $row->suma_wartosci;
        }

        if ($statisticType == 'day'){
            $okres = CarbonPeriod::create($data_start, $data_koniec);
        } else {
            $okres = CarbonPeriod::create($data_start, '1 month', $data_koniec);
        }
        $ordersByDays = [];

        foreach ($okres as $date) {
            if ($statisticType == 'day'){
                $klucz_dnia = $date->format('Y-m-d');
            } else {
                $klucz_dnia = $date->format('Y-m');;
            }
            $ordersByDays[$klucz_dnia]['all'] = $wyniki_z_bazy[$klucz_dnia]['all'] ?? 0;
            $ordersByDays[$klucz_dnia]['payed'] = $wyniki_z_bazy[$klucz_dnia]['payed'] ?? 0;
            $ordersByDays[$klucz_dnia]['summ'] = $wyniki_z_bazy[$klucz_dnia]['summ'] ?? 0;
        }

        $viewData['ordersByDays'] = $ordersByDays;
        
        $viewData['allOrders'] = $allOrders;
        $viewData['payyedOrders'] = $payyedOrders;
        $viewData['payOrdersSumm'] = $payOrdersSumm;
       //echo '<pre>';
        //var_dump($viewData['deliveriesData']);die();
        
        return view('admin/statistics',$viewData);
    }

}
