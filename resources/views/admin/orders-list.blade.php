@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<div class="all-content-big cms-list-container">
    <h1>Zamówienia</h1>
    <div class="orders-top-actions">
        <div class="cms-filters-container cms-filters-container-orders">
            <span class="filters-name">Filtrowanie</span>
            <form>
                <div class="filter-row">
                    od: <input type="text" name="date-from" value="{{$data_start}}" style="width: 110px;" autocomplete="off">
                    do: <input type="text" name="date-to" value="{{$data_koniec}}" style="width: 110px;" autocomplete="off">
                </div>

                <div class="filter-row">
                    Status zamówienia: <select type="text" name="searchStatus" autocomplete="off">
                        <option value="" ></option>
                        <option value="inprogress" @if($searchStatus == 'inprogress') selected @endif>Nowe zamówienie</option>
                        <option value="payed_failed" @if($searchStatus == 'payed_failed') selected @endif>Nowe zamówienie - nieudana płatność</option>
                        <option value="payed_accept" @if($searchStatus == 'payed_accept') selected @endif>Zapłacone</option>
                        <option value="to_fulfilled" @if($searchStatus == 'to_fulfilled') selected @endif>Przekazane do realizacji</option>
                        <option value="redy_to_send" @if($searchStatus == 'redy_to_send') selected @endif>Gotowe do wysłania</option>
                        <option value="send" @if($searchStatus == 'send') selected @endif>Wysłane</option>
                    </select>
                </div>

                <div class="filter-row">
                    Status płatności: <select type="text" name="searchPaymentStatus" autocomplete="off">
                        <option value="" ></option>
                        <option value="CONFIRMED" @if($searchPaymentStatus == 'CONFIRMED') selected @endif>Opłacone</option>
                        <option value="payed_failed" @if($searchPaymentStatus != '' && $searchPaymentStatus != null && $searchPaymentStatus != 'CONFIRMED') selected @endif>Nieopłacone</option>
                    </select>
                </div>

                <div class="filter-row">
                    Wyszukaj: <input type="text" value="{{$searchValue}}" name="searchValue" autocomplete="off">
                </div>

                <input type="submit" value="Zastosuj" class="standard-button standard-big-button-green submit-filters">
            </form>
        </div>
        <div class="mass-actions cms-filters-container cms-filters-container-orders">
            <span class="filters-name">Działania masowe</span>
            <div class="filter-row">
                Eksportuj zaznaczone do: <select name="mass-export" id="mass-export" autocomplete="off">
                    <option value="" ></option>
                    <option value="print">Wydruk</option>
                </select>
            </div>
            <div class="filter-row">
                Zmień status zaznaczonych na: <select type="text" name="mass-change-status" id="mass-change-status" autocomplete="off">
                        <option value="" ></option>
                        <option value="inprogress" @if($searchStatus == 'inprogress') selected @endif>Nowe zamówienie</option>
                        <option value="payed_failed" @if($searchStatus == 'payed_failed') selected @endif>Nowe zamówienie - nieudana płatność</option>
                        <option value="payed_accept" @if($searchStatus == 'payed_accept') selected @endif>Zapłacone</option>
                        <option value="to_fulfilled" @if($searchStatus == 'to_fulfilled') selected @endif>Przekazane do realizacji</option>
                        <option value="redy_to_send" @if($searchStatus == 'redy_to_send') selected @endif>Gotowe do wysłania</option>
                        <option value="send" @if($searchStatus == 'send') selected @endif>Wysłane</option>
                    </select>
            </div>
        </div>
    </div>

    @if (count($orders)>0)
    <table class="cms-list-table cms-list-table-orders">
        <thead>
        <tr>
            <td><input type="checkbox" id="master-checed" autocomplete="off"></td>
            <td>Numer</td>
            <td>Status</td>
            <td>Status płatności</td>
            <td>Data</td>
            <td>Wartość</td>
            <td>Odbiorca</td>
            <td>Adres</td>
            <td>E-mail</td>
            <td>Telefon</td>
            <td>Akcje</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($orders as $order)
        <tr style="@if ($order->paynow_payment_status == 'CONFIRMED')
            @if ($order->status == 'inprogress')
            background-color: #fdd0d0;
            @endif
            
            @if ($order->status == 'payed_accept')
            background-color: #fdd6d0;
            @endif
            
            @if ($order->status == 'to_fulfilled')
            background-color: #fdeed0;
            @endif
            
            @if ($order->status == 'redy_to_send')
            background-color: #f6dbdb;
            @endif
            
            @if ($order->status == 'send')
            background-color: #d8fdd0;
            @endif

            @endif
            "
            >
            <td><input type="checkbox" class="mass-select-orders" data-id="{{$order->id}}" autocomplete="off"></td>
            <td style="font-size: 11px;">{{$order->name}}</td>
            <td>{{$order->status}}</td>
            <td>{{$order->paynow_payment_status}}</td>
            <td>{{$order->order_date}}</td>
            <td>{{number_format($order->value_gross, 2, ',', ' ')}} zł</td>
            <td>{{$order->recipient}}</td>
            <td>{{$order->delivery_street}} {{$order->delivery_house_number}}<br>{{$order->delivery_city}} {{$order->delivery_zip_code}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->phone}}</td>
            <td><a class="standard-button standard-big-button-green" href="/panel/order/{{$order->id}}">Edytuj</a></td>
        </tr>
        @endforeach
    </table>
    @else
    <p>Nie znaleziono wyników dla zadanych kryteriów w zadanym przedziale czasu. Upewnij się kryteria sią poprawne lub zwiększ przedział czasu do przeszukiwania.</p>
    @endif
</div> 

<script type="text/javascript">
    
    document.getElementById('mass-change-status').addEventListener("change", function(){
        if (confirm('Czy na pewno chcesz zmienić status wszytskich zaznaczonych pozycji?')) {
            
        } else {

        }
    });
    
    
    document.getElementById('master-checed').addEventListener("change", function(e){
        let orders = document.querySelectorAll('.mass-select-orders');
        setTimeout(() => {
            if (document.getElementById('master-checed').checked){
                for (let i=0;i<orders.length;i++){
                    orders[i].checked = true;
                }
            } else {
                for (let i=0;i<orders.length;i++){
                    orders[i].checked = false;
                }
            }
        }, 30);
    });
    document.getElementById('mass-export').addEventListener("change", function(e){
        console.log(e.target.value);
        if (e.target.value == 'print'){
            
            let orders = document.querySelectorAll('.mass-select-orders:checked');
            let ordersIds = [];
            for (let i=0;i<orders.length;i++){
                ordersIds.push(orders[i].getAttribute('data-id'));
            }
            console.log(ordersIds);
            if (ordersIds.length > 0){
                console.log(ordersIds.join(';'));
                window.open('/panel/orders-export-print?ids='+ordersIds.join(';'), '_blank').focus();
            } else {
                alert("Nie zaznaczono żadnego zamówienia do eksportu");
            }
            
            e.target.value = '';
        }
    });
    
    
</script>
@endsection