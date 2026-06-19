<style>
    @page size: A4 landscape;

    @media print { body,html,#wrapper {
        width: 100%;
    }
    .page-breaker {
        clear: both;page-break-after: always; height:2px;
    }
    .page-breaker {
        clear: both;page-break-after: always; height:2px;
    }
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
    }
</style>
        $orders = $this->getOrders($ids);
        
        @foreach ($orders as $order)
            <table colspan="0">
            
            @php 
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
            @endphp
            <tr>
                <td>{{$order->getOrderDate()->format('Y-m-d H:i:s')}}</td>
                <td colspan='2'><span class='label'>nr: </span> {{$order->getOrderNumber()}}</td>
                <td><span class='label'>status płatności:</span> {{$order->getPaynowPaymentStatus()}} </td>
            </tr>
            <tr>
                <td colspan='2'><span class='label'>imie i nazwisko:</span> {{ $order->getRecipient()}}</td>
                <td colspan='2'><span class='label'>metoda płatności:</span> {{ $paymentType }}</td>
            </tr>
            <tr>
                <td colspan='2'><span class='label'>telefon:</span> {{ $order->getPhone() }}</td>
                <td colspan='2'><span class='label'>e-mail:</span> {{ $order->getEmail() }}</td>
            </tr>";
            <tr>
                <td colspan='2'><span class='label'>metoda dostawy:</span> {{ $order->getDeliveryMethod() }}</td>
                <td colspan='2'><span class='label'>koszt dostway:</span> {{ $order->getDeliveryCost() }} zł</td>
            </tr>";
            <tr>
                <td colspan='4'><span class='label'>adres dostawy:</span>{{ $order->getDeliveryData() . $paczkomatDetails }}</td>
            </tr>";
            @if ($order->getWithInvoice())
                @if ($order->getNipNumber() == '' || $order->getNipNumber() == null)
                    <tr>
                        <td colspan='4'>
                            <span class='label'>dane do faktury (na osobę fizyczną):</span>
                            {{$order->getCompanyName().", ".$order->getTown()." ".$order->getPostalCode()." ".$order->getStreet() }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td colspan='4'>
                            <span class='label'>dane do faktury (na firmę):</span>
                            {{$order->getCompanyName().", nip: ".$order->getNipNumber()." ".$order->getTown()." ".$order->getPostalCode()." ".$order->getStreet()}}
                        </td>
                    </tr>
                @endif
                
            @else{
                <tr>
                    <td colspan='4'><span class='label'>faktura:</span>NIE</td>
                </tr>
            @endif
            @foreach ($order->getOrderPositions() as $i => $product){
                @php
                $licz = $i+1;
                $expirationdate = '';
                
                
                if ($product->getExpirationDate() != '' && $product->getExpirationDate() != null){
                    $expirationdate = ' <span style="color: gray;">( Data ważności: ' . $product->getExpirationDate() . ' )</span>';
                }
                
                @endphp
                
                <tr>
                    <td colspan='4'>
                        <div class='count'>" .  $product->getQuantity() . ' x</div>
                        <div class="product-content">{{$product->getProduct()->getName() . " " . $product->getProduct()->getBrand() . " " . $product->getProduct()->getContent(). $expirationdate }}</div>
                        {{$product->getPriceGross() . ' x ' . $product->getQuantity() . ' = ' . $product->getValueGross()}} zł
                    </td>
                </tr>
                
            @endforeach
            <tr>
                <td colspan='4'>
                    <div class='price-sumary'>suma brutto (produkty + koszt przesyłki):</div>{{$order->getValueGross()}} zł</td>
            </tr>
            </table><br>
            <br>
            <div class='page-breaker'></div>
        @endforeach