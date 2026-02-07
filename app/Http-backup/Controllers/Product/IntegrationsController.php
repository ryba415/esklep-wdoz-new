<?php

namespace App\Http\Controllers\Product;
use Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SoapServer as CustomSoapServer;
use App\Models\Email;


class IntegrationsController extends Controller
{
    
    private $serverDomainUrl = '';
    public function __construct()
    {
        if (Config::get('constants.use_ssl')){
            $this->serverDomainUrl = 'https://' . Config::get('constants.drogeria_domain');
        } else {
            $this->serverDomainUrl = 'http://' . Config::get('constants.drogeria_domain');
        }
    }
    
    public function wsdl()
    {
        return response()->file(storage_path('app/wsdl/products.wsdl'), [
            'Content-Type' => 'text/xml'
        ]);
    }
    
    public function server(Request $request)
    {
        /*$options = [
            //'login'    => 'esklep',
            //'password' => 'b*&4[Hv@',
            'uri' => url('/soap/server'),
            'cache_wsdl' => WSDL_CACHE_NONE,
        ];*/
        
        $options = array(
            'login'    => 'esklep',
            'password' => 'b*&4[Hv@',
            'cache_wsdl' => WSDL_CACHE_NONE,
            'uri' => $this->serverDomainUrl.'/soap/server' // URI serwera
        );
        
        $server = new \SoapServer($this->serverDomainUrl.'/soap/spec.wsdl', $options); //storage_path('app/wsdl/products.wsdl');
        $data = Carbon::now()->toDateTimeString();
        $data = $data . '  - server';

        Storage::append('data-wsdl-log.txt', $data);
        $server->setClass('App\Http\Controllers\Product\IntegrationsController');
        $server->handle();
        
        
    }
    
    public function updateShopData(){

        $client = new \SoapClient($this->serverDomainUrl.'/soap/spec.wsdl',[
            //'login'    => 'esklep',
            //'password' => 'b*&4[Hv@',
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => 1,
        ]);

        //$auth         = new ChannelAdvisorAuth($devKey, $password);
        //$header     = new SoapHeader("http://www.example.com/webservices/", "APICredentials", $auth, false);




        $result = $client->getOrders('eeee','eeee','eeeee2');
        echo $result;
    }
    
    private function arrayToJson(\SimpleXMLElement $object, array $data) {
        foreach ($data as $key => $value) {
            // if the key is an integer, it needs text with it to actually work.
            $valid_key  = is_numeric($key) ? "key_$key" : $key;
            $new_object = $object->addChild( 
                $valid_key, 
                is_array($value) ? null : htmlspecialchars($value) 
            );

            if (is_array($value)) {
                $this->arrayToJson($new_object, $value);
            }
        }
    }
    
    public function setOfferTest(){
        $offerSting = file_get_contents('https://test.wracamdozdrowia.pl/offer-test.txt');
        $this->setOffer('938674','adm_pass', $offerSting);
    }
    
    public function setOffer(string $AUserName,string $APassword,string $AOffer)
    {
        
        if ($AUserName == Config::get('constants.camsoft-user') && $APassword = Config::get('constants.camsoft-pass')){

            $AOffer = str_replace('<?xml version="1.0" encoding="windows-1250"?>','',$AOffer);
            $xml = simplexml_load_string($AOffer, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $productsArray = json_decode($json,TRUE);
            
            $licz = 0;
            $errorsString = '';
            $errorsStringCritical = '';
            $updatedSucess = '';
            $updatesBloz = [];
            $sucessUpdated = 0;
            $wrongUpdated = 0;
            $unexistUpdated = 0;
            if (isset($productsArray['items']) && isset($productsArray["items"]["item"])){
                foreach ($productsArray["items"]["item"] as $item){
                    $licz++;
                    $productExist = DB::connection('mysql-esklep')->select('SELECT bloz7 FROM ecommerce_products '
                        . 'WHERE bloz7 = ?'
                        , [$item['bloz07']]);
                    if (count($productExist) > 0){
                        $sucessUpdated++;
                        $priceGross = $item['price'];
                        $price = round($item['price'] * 100 / (100 + $item['vat']),2);
                        $vatRate = $item['vat']/100;
                        DB::connection('mysql-esklep')->update('UPDATE ecommerce_products SET availability = ?, price = ?, price_gross = ?, vat_rate = ?  WHERE bloz7 = ?', //price = ?
                                [$item['supplyamount'],$price,$priceGross,$vatRate,$item['bloz07']]);
                        $updatedSucess = $updatedSucess . '<span style="color: green">Produkt '.$item["name"]. ' bloz: '. $item['bloz07']  . ' został zaktualizowany</span><br>';
                        
                        //echo '<span style="color: green">Produkt '.$item["name"]. ' bloz: '. $item['bloz07']  . ' został zaktualizowany</span><br>';        
                        $updatesBloz[] = $item['bloz07'];
                    } else {
                        $unexistUpdated++;
                        $errorsString = $errorsString . '<span style="color: #b07302">produkt: '.$item["name"]. ' bloz: '. $item['bloz07']  . ' nie występuje w aptece internetowej</span><br>';
                    }
                }
            }

            $unupdatedProductsBlozArray = [];
            $allProductsBloz = DB::connection('mysql-esklep')->select('SELECT ecommerce_products.bloz7 '
                    . ' FROM ecommerce_products '
                    . '', []);
            
            foreach ($allProductsBloz as $bloz){
                if (!in_array($bloz->bloz7,$updatesBloz)){
                    $unupdatedProductsBlozArray[] = $bloz->bloz7;
                }
            }
            
            $unupdatedProducts = DB::connection('mysql-esklep')->table('ecommerce_products')
                ->whereIn('bloz7', $unupdatedProductsBlozArray)
                ->get();
            
            foreach ( $unupdatedProducts as $unupdate){
                $wrongUpdated++;
                $errorsStringCritical = $errorsStringCritical . '<span style="color: red">produkt: '.$unupdate->name. ' bloz: '. $unupdate->bloz7  . ' nie został zaktualizowany, ponieważ nie występował w bazie Camsoft</span><br>';
            }
            echo $errorsStringCritical;
            if ($errorsString != '' || $errorsStringCritical != ''){
                $emailVariables = [];
                $emailVariables['content'] = "<p style='color: green; font-size: 18px'> Zaktualizowano pomyślnie: ".$sucessUpdated." produktów</p><br><br> Nie udało się zaktualizować ".$wrongUpdated." produktów. <br><br>" . $errorsStringCritical . "<br><br>" .$unexistUpdated." produktów nie istnieje w sklepie internetowym ( a są przekazywane przez api Camsoftu):<br> ".$errorsString ."<br><br>";
                $emailsArray = ['info@datum.pl'];
                $email = new Email($emailsArray, 'Raport aktualizacji stanów magazynowych z Camsoft', 'emails/standard-mail-template', $emailVariables);
                $email->send();
            }

            $data = Carbon::now()->toDateTimeString();
            $data = $data . '  - setOffer1: ' . ' | ';

            Storage::append('data-wsdl-log.txt', $data);

          return true; //jeśli jwst ok
          
        } else {
            $emailVariables = [];
            $emailVariables['content'] = "Nie udało się zaktualizować cen i stanów magazynowych w sklepie z programem aptecznym! Błędny login i lub hasło.";
            $emailsArray = ['ryba415@gmail.com', 'darek@datum.pl'];
            $email = new Email($emailsArray, 'Błąd w integracji z Camsoft', 'emails/standard-mail-template', $emailVariables);
            $email->send();
        }
    }
    
    public function getOrdersTest(){
        return $this->getOrders('938674','adm_pass', 12, 'data');
    }

    public function getOrders(string $AUserName,string $APassword, int $ALastOrderId, $ALastDateTime)
    {

      // plik ApwWebSrv_iApteka.pdf strona 9
        if ($AUserName == Config::get('constants.camsoft-user') && $APassword = Config::get('constants.camsoft-pass')){
            $ordersArray = [];
            $orders = DB::connection('mysql-esklep')->select('SELECT ecommerce_orders.*, fos_user.username as username, '
                    . ' ecommerce_delivery_method.code as delivery_code,  ecommerce_delivery_method.name as delivery_name '
                    . ' FROM ecommerce_orders '
                    . ' LEFT JOIN fos_user ON ecommerce_orders.user_id = fos_user.id '
                    . ' LEFT JOIN ecommerce_delivery_method ON ecommerce_orders.delivery_method_id = ecommerce_delivery_method.id '
                    . ' WHERE sended_to_camsoft = 0 LIMIT 2', []);

            $xmlString = '';
            foreach ($orders as $order){

                $orderPositions = DB::connection('mysql-esklep')->select('SELECT ecommerce_order_position.*, '
                    . ' ecommerce_products.name as product_name, ecommerce_products.brand as brand, ecommerce_products.content as content, '
                    . ' ecommerce_products.bloz7 as bloz7, ecommerce_products.ean as ean, ecommerce_products.producent as producent '
                    . ' FROM ecommerce_order_position '
                    . ' LEFT JOIN ecommerce_products ON ecommerce_order_position.product_id = ecommerce_products.id '
                    . ' WHERE order_id = ?', [$order->id]);

                $productsXmlString = '';
                $licz = 1;
                foreach ($orderPositions as $position){
                    $productArray = [
                        'itemno' => $licz,
                        'idtowr' => $position->product_id,
                        'idiatw' => '',
                        'quantity' => $position->quantity,
                        'price' => $position->value_gross,
                        'bloz07' => $position->bloz7,
                        'bloz12' => '',
                        'ean' => $position->ean,
                        'name' => $position->product_name. ' ' . $position->brand . ' ' . $position->content,
                        'producer' => $position->producent,
                        'centralcode' => '',
                        'expirydate' => '',
                        'reservationorder' => '',
                        'reservationorderitem' => '',
                    ];
                    $xmlItem = new \SimpleXMLElement('<orderitem/>');
                    $itemsXml = $this->arrayToJson($xmlItem, $productArray);
                    $itemsXml = $xmlItem->asXML();
                    $productsXmlString = $productsXmlString . $itemsXml;
                    $licz++;
                }

                $fvvat = 0;
                if ($order->with_invoice){
                    $fvvat = 2;
                    if ($order->vat_number != '' && $order->vat_number != null){
                        $fvvat = 1;
                    }
                }

                $orderArray = [
                    'id' => strval($order->id),
                    'number' => strval($order->id),
                    'date' => $order->order_date,
                    'status' => 0,
                    'name1' => $order->recipient,
                    'name2' => $order->recipient,
                    'country' => [
                        'id' => 1,
                        'name' => 'Polska',
                        'symbol' => 'PL',
                    ],
                    'city' => $order->delivery_city,
                    'postcode' => $order->delivery_zip_code,
                    'street' => $order->delivery_street,
                    'houseno' => strval($order->delivery_house_number),
                    'placeno' => '',
                    'phonen' => $order->phone,
                    'email' => $order->email,
                    'remarks' => ' ',
                    'orderrebate' => 0.0,
                    'transportprice' => $order->delivery_cost,
                    'codprice' => 0.0,
                    'transportrebate' => 0.0,
                    'epayed' => ($order->payment_type=='przelewpaynow')?1:0,
                    'weight' => 0.0, //nie znam wagi
                    'fvvat' => $fvvat,
                    'feature' => 0,
                    'customer' => [
                        'id' => 0,
                        'name1' => $order->recipient,
                        'name2' => $order->recipient,
                        'country' => 'Polska',
                        'city' => $order->delivery_city,
                        'postcode' => $order->delivery_zip_code,
                        'street' => $order->delivery_street,
                        'houseno' => $order->delivery_house_number,
                        'placeno' => '',
                        'nip' => $order->vat_number,
                        'regon' => '',
                        'phoneno' => $order->phone,
                        'mobileno' => '',
                        'faxno' => '',
                        'email' => $order->email,
                        'login' => $order->username,
                        'pesel' => '',
                        'nick' => '',
                        'numberosoz' => '',
                    ],
                    'payment' => [
                        'id' => 0,
                        'symbol' => $order->payment_type,
                        'name' => $order->payment_type,
                    ],
                    'transport' => [
                        'id' => $order->delivery_method_id,
                        'symbol' => $order->delivery_code,
                        'name' => $order->delivery_name,
                        'deliverypoint' => [
                            'idext' => '',
                            'name' => '',
                            'city' => '',
                            'postcode' => '',
                            'street' => '',
                            'houseno' => '',
                            'placeno' => ''
                        ]
                    ],
                    'receivepoint' => [
                        'id' => 0,
                        'symbol' => '',
                        'name' => '',
                    ],
                    'items' => 'set_orders_items_xml_string'

                ];

                $xml = new \SimpleXMLElement('<order/>');
                $ordersXml = $this->arrayToJson($xml, $orderArray);
                $ordersXml = $xml->asXML();
                $xmlString = $xmlString . $ordersXml;

                $xmlString = str_replace('set_orders_items_xml_string',$productsXmlString,$xmlString);
                
                DB::connection('mysql-esklep')->update('UPDATE ecommerce_orders SET sended_to_camsoft = 1 WHERE id = ?', 
                                [$order->id]);
            }

            $xmlString = '<?xml version="1.0" encoding="windows-1250"?><orders>' . str_replace('<?xml version="1.0"?>','',$xmlString) . '</orders>';

            $data = Carbon::now()->toDateTimeString();
            $data = $data . '  - getOrders: correct ';

            Storage::append('data-wsdl-log.txt', $data);
            
$xmlString = '
<orders>
<order>
<id>4478</id>
<number>4478</number>
<date>2006-07-28T08:12:22</date>
<status>0</status>
<name1>Kowalski</name1>
<name2>Jan</name2>
<country>
<id>1</id>
<name>Polska</name>
<symbol>PL</symbol>
</country>
<city>Katowice</city>
<postcode>40-235</postcode>
<street>ul. 1-go Maja</street>
<houseno>133</houseno>
<placeno></placeno>
<phoneno>(032) 209 07 05</phoneno>
<email>2123@kamsoft.pl</email>
<remarks>Uwagi dotyczące zamówienia</remarks>
<orderrebate>0.00</orderrebate>
<transportprice>6.50</transportprice>
<codprice>3.50</codprice>
<transportrebate>0.00</transportrebate>
<epayed>0</epayed>
<weight>20.30</weight>
<fvvat>2</fvvat>
<feature>3</feature>
<customer>
<id>2274</id>
<name1>Przedsiębiorstwo Informatyczne</name1>
<name2>Kamsoft</name2>
<country></country>
<city>Katowice</city>
<postcode>40-235</postcode>
<street>ul. 1-go Maja</street>
<houseno>133</houseno>
<placeno></placeno>
<nip></nip>
<regon></regon>
<phoneno>(032) 209 07 05</phoneno>
<mobileno></mobileno>
<faxno>(032) 209 07 15</faxno>
<email>2123@kamsoft.pl</email>
<login>ksadmin</login>
<pesel>11111111111</pesel>
<nick>ksallegro</nick>
<numberosoz>1234512345</numberosoz>
</customer>
<payment>
<id>2</id>
<symbol>ZP</symbol>
<name>Za pobraniem</name>
</payment>
<transport>
<id>4</id>
<symbol>P48</symbol>
<name>Pocztex 48</name>
<deliverypoint>
<idext>986627</idext>
<name>Stacja PKN Orlen 408</name>
<city>Czeladź</city>
<postcode>41250</postcode>
<street>Grodziecka</street>
<houseno>2</houseno>
<placeno></placeno>
</deliverypoint>
</transport>
<receivepoint>
<id>1</id>
<symbol>OD1</symbol>
<name>Odbiór 1</name>
</receivepoint>
<items>
<orderitem>
<itemno>1</itemno>
<idtowr>4321</idtowr>
<idiatw></idiatw>
<quantity>2</quantity>
<price>12.09</price>
<bloz07>8052711</bloz07>
<bloz12>224780211395</bloz12>
<ean>7610108065417</ean> *NOWOŚĆ APW45 2016.3.2.0*
<name>2 KC Xtreme 12 tabl.</name>
<producer>Zakłady farmaceutyczne Colfarm, Polska</producer>
<centralcode>1240</centralcode>
<expirydate>2013-07-28</expirydate>
<reservationorder>ZM1232101123</reservationorder>
<reservationorderitem>1232101</reservationorderitem>
</orderitem>
</items>
</order>
</orders>';
        
        /*'<?xml version="1.0" encoding="windows-1250"?>
<orders>
<order>
<id>190</id>
<number>4478</number>
<date>2006.07.28 08:12:22</date>
<status>4</status>
<name1>Kowalski</name1>
<name2>Jan</name2>
<country>
<id>1</id>
<name>Polska</name>
<symbol>PL</symbol>
</country>
<city>Katowice</city>
<postcode>40-235</postcode>
<street>ul. 1-go Maja</street>
<houseno>133</houseno>
<placeno></placeno>
<phoneno>(032) 209 07 05</phoneno> 
<email>2123@kamsoft.pl</email> 
<remarks>Uwagi dotyczące zamówienia</remarks>
<orderrebate>0.00</orderrebate>
<transportprice>6.50</transportprice>
<codprice>3.50</codprice>
<transportrebate>0.00</transportrebate>
<epayed>0</epayed> 
<deleted>0</deleted>
<customer>
<id>780</id>
<name1>Przedsiębiorstwo Informatyczne</name1>
<name2>Kamsoft</name2>
<country></country>
<city>Katowice</city>
<postcode>40-235</postcode>
<street>ul. 1-go Maja</street>
<houseno>133</houseno>
<placeno></placeno>
<nip></nip>
<regon></regon>
<phoneno>(032) 209 07 05</phoneno>
<mobileno></mobileno>
<faxno>(032) 209 07 15</faxno>
<email>2123@kamsoft.pl</email>
<login>ksadmin</login>
<pesel>11111111111</pesel> 
<nick>ksallegro</nick> 
<numberosoz>1234512345</numberosoz> 
</customer>
<payment>
<id>102</id>
<symbol>ZP</symbol>
<name>Za pobraniem</name>
</payment>
<transport>
<id>4</id>
<symbol>P48</symbol>
<name>Pocztex 48</name>
<deliverypoint> 
<idext>986627</idext> 
<name>Stacja PKN Orlen 408</name> 
<city>Czeladź</city> 
<postcode>41250</postcode> 
<street>Grodziecka</street>
<houseno>2</houseno>
<placeno></placeno> 
</deliverypoint> 
</transport>
<receivepoint>
<id>1</id> 
<symbol>OD1</symbol> 
<name>Odbiór 1</name> 
</receivepoint> 
<items>
<orderitem>
<itemno>1</itemno>
<idtowr>4321</idtowr>
<idiatw></idiatw>
<quantity>2</quantity>
<price>12.09</price>
<bloz07>8052711</bloz07>
<bloz12>224780211395</bloz12>
<ean>7610108065417</ean> 
<name>2 KC Xtreme 12 tabl.</name>
<producer>Zakłady farmaceutyczne Colfarm, Polska</producer>
<status>1</status>
<centralcode>1240</centralcode>
</orderitem>
</items>
<letter>
<number>159007733334347449</number>
<date>2006.07.29</date>
</letter>
</order>
</orders>';*/
            
            return response($xmlString)->withHeaders([
                'content-type' => 'text/xml'
             ]);
        } else {
            $data = Carbon::now()->toDateTimeString();
            $data = $data . '  - getOrders: WRONG PASS!!! ' . $AUserName . ' ' . $APassword;
            Storage::append('data-wsdl-log.txt', $data);
            
            $emailVariables = [];
            $emailVariables['content'] = "Nie udało się przekazać zamówień do programu aptecznego! Błędny login i lub hasło.";
            $emailsArray = ['ryba415@gmail.com', 'darek@datum.pl'];
            $email = new Email($emailsArray, 'Błąd w integracji z Camsoft', 'emails/standard-mail-template', $emailVariables);
            $email->send();
        }
    }  

    public function setOrders(string $AUserName,string $APassword,string $AOffer)
    {
      //$AOffer - ciąg znaków w formacie XML zawierający informacje o statusie zamówień wczytanych do apteki internetowej
      // plik ApwWebSrv_iApteka.pdf strona 14
      // zaktualizuj informacje o zamówieniach w sklepie internetowym
        $data = Carbon::now()->toDateTimeString();
        $data = $data . '  - setOrders: ' . $AOffer;

        Storage::append('data-wsdl-log.txt', $data);
        
        return $this->getOrders('938674','adm_pass', 12, 'data');

    }
    
}
