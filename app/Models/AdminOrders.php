<?php

namespace App\Models;

use App\Services\Cms\AdminArticlesSaveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrders extends CmsObject
{
    
    
    function __construct() {
        $this->deliveries = [];
        
        $this->getDeliveries();
    }
    
    public function getDeliveries(){
        $deliveries = DB::connection('mysql-esklep')->select("SELECT id, name
            FROM ecommerce_delivery_method ", []);
        
        $deliveriesArray = [];
        foreach ($deliveries as $delivery){
            $deliveriesArray[$delivery->id] = $delivery->name;
        }
        
        $this->areas[7]['options'] = $deliveriesArray;
    }
    
    public $objectName = 'AdminOrders';
    public $dbTableName = 'ecommerce_orders';
    public $listName = 'Lista zamówień';
    public $editItemUrl = '/panel/order/';
    public $addNewItemButtonName = 'Dodaj zamówienie';
    public $itemTitle = 'Zamówienie';
    public $breadCrub1 = [
        'url' => '/panel/orders-list',
        'name' => 'lista zamówień'
    ];
    public $breadCrub2 = [
        'url' => '/panel/order-new',
        'name' => 'zamówienie'
    ];
    public $deliveries = [];
    
    public $areas = [

        0 => [
            'name' => 'Status zamówienia',
            'type' => 'select',
            'field' => 'status',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 299
            ],
            'options' => [
                'inprogress' => 'Nowe zamówienie',
                'payed_failed' => 'nowe zamówienie - nieudana płatność',
                'payed_accept' => 'zapłacone',
                'to_fulfilled' => 'Przekazane do realizacji',
                'redy_to_send' => 'Gotowe do wysłania',
                'send' => 'Wysłane',
            ]
        ],
        1 => [
            'name' => 'Status płatności',
            'type' => 'select',
            'field' => 'status',
            'editable' => true,
            'onList' => true,
            'onFilter' => true,
            'validations' => [
                'require' => true,
                'nimLength' => 2,
                'maxLength' => 299
            ],
            'options' => [
                'PENDING' => 'W trakcie płatności',
                'CONFIRMED' => 'Zapłacone',
                'REJECTED' => 'Płatność nieudana',
                'ERROR' => 'Błąd podczas płatności',
            ]
        ],
        2 => [
            'name' => 'Numer zamówienia',
            'type' => 'text',
            'field' => 'name',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        3 => [
            'name' => 'Numer zamówienia',
            'type' => 'text',
            'field' => 'name',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        4 => [
            'name' => 'Data zamówienia',
            'type' => 'text',
            'field' => 'order_date',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        5 => [
            'name' => 'Wartość zamówienia (brutto)',
            'type' => 'text',
            'field' => 'value_gross',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        6 => [
            'name' => 'Imię i nazwisko',
            'type' => 'text',
            'field' => 'recipient',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        7 => [
            'name' => 'Telefon',
            'type' => 'text',
            'field' => 'phone',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        8 => [
            'name' => 'E-mail',
            'type' => 'text',
            'field' => 'email',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        /*9 => [
            'name' => '',
            'type' => 'text',
            'field' => '',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        10 => [
            'name' => '',
            'type' => 'text',
            'field' => '',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],*/
        
        
        11 => [
            'name' => 'Metoda dostawy',
            'type' => 'select',
            'field' => 'delivery_method_id',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
            'options' => [],
        ],
        12 => [
            'name' => 'Metoda płatności',
            'type' => 'text',
            'field' => 'payment_type',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        13 => [
            'name' => 'Ulica',
            'type' => 'text',
            'field' => 'delivery_street',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        14 => [
            'name' => 'Numer domu/mieszkania',
            'type' => 'text',
            'field' => 'delivery_house_number',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        15 => [
            'name' => 'Miasto',
            'type' => 'text',
            'field' => 'delivery_city',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        16 => [
            'name' => 'Kod pocztowy',
            'type' => 'text',
            'field' => 'delivery_zip_code',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        17 => [
            'name' => 'Czy wymagana faktura?',
            'type' => 'select',
            'field' => 'with_invoice',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
            'options' => [
                '1' => 'TAK',
                '0' => 'NIE',
            ]
        ],
        18 => [
            'name' => 'Nazwa firmy',
            'type' => 'text',
            'field' => 'company_name',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        19 => [
            'name' => 'NIP',
            'type' => 'text',
            'field' => 'vat_number',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        20 => [
            'name' => 'Ulica (do faktury)',
            'type' => 'text',
            'field' => 'street',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        21 => [
            'name' => 'Numer domu/mieszkania (do faktury)',
            'type' => 'text',
            'field' => 'house_number',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        22 => [
            'name' => 'Miasta (do faktury)',
            'type' => 'text',
            'field' => 'town',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        23 => [
            'name' => 'Kod pocztowy (do faktury)',
            'type' => 'text',
            'field' => 'postal_code',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        24 => [
            'name' => 'Koszt dostawy',
            'type' => 'text',
            'field' => 'delivery_cost',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],
        /*25 => [
            'name' => '',
            'type' => 'text',
            'field' => '',
            'editable' => true,
            'onList' => false,
            'onFilter' => false,
            'readonly' => true,
        ],*/
         
    ];

}
