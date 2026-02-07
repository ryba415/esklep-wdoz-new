<?php

use Illuminate\Support\Facades\Facade;

return [
    'przelewy24_use_sandbox' => true,
    'przelewy24_sandbox_domain' => 'https://sandbox.przelewy24.pl',
    'przelewy24_production_domain' => 'https://secure.przelewy24.pl',
    'przelewy24_register_transaction_url' => '/api/v1/transaction/register',
    'przelewy24_register_verify_url' => '/api/v1/transaction/verify',
    'przelewy24_merchantId' => 268636,
    'przelewy24_crc' => '7a4d546aa75db44d',
    'przelewy24_return_url' => '/payment-thank-you-page',
    'przelewy24_return_status_url' => '/paymentsetstatus',
    'przelewy24_klucz_raportow' => 'fc968253c398feda0f01c06c63233de9',
    'przelewy24_klucz_zamowien' => 'fc968253c398feda0f01c06c63233de9',
    
    'technical_admins_mails' => ['ryba415@gmail.com'],
    //'system_domain' => 'http://esklep-checkout.local/',
    'system_domain' => 'http://drogeria.wdoz.pl/',
    
    /*'paynow_url' => 'https://api.paynow.pl/v1/payments',
    'paynow_api_key' => '38addf1b-c455-4c80-98ff-b4a7e6dad83d',
    'paynow_signature_key' => '926c2d54-88ca-4dad-8937-248ef63ae016',
    'paynow_host' => 'api.paynow.pl',
    'paynow_thankyou_page' => 'https://esklep.wdoz.pl/dziekujemy-za-zakup',*/
    
    'paynow_url' => 'https://api.sandbox.paynow.pl/v3/payments',
    'paynow_api_key' => 'b29f5a05-2b7a-44e2-84e1-3a6ec395b86a',
    'paynow_signature_key' => 'f56b96b7-35e1-4242-a44c-91dfa54f3684',
    'paynow_host' => 'api.sandbox.paynow.pl',
    'paynow_thankyou_page' => 'https://test.wracamdozdrowia.pl/dziekujemy-za-zakup',
    
    'use_ssl' => false,
    'shop_name' => 'Apteka Wracam Do Zdrowia',
    'bank_acount_number' => '31 1140 1052 0000 4188 6500 1004',
    'bank_acount_recipent' => 'Wracam do zdrowia 8 Sp. z z o.o.',
    //'drogeria_domain' => 'esklep-checkout.local',
    'drogeria_domain' => 'esklep-checkout.local',
    //'apteka_domin' => 'esklep-checkout.local',
    'apteka_domin' => 'esklep-checkout2.local',
    'shop_domain' => 'test-esklep.wdoz.pl',
    
    'admin-panel-url' => 'https://esklep.wdoz.pl/',
    'camsoft-user' => '938674',
    'camsoft-pass' => 'adm_pass',
];
