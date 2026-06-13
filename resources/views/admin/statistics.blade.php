@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<div class="all-content-big cms-list-container admin-dashboard-container">
    <h1>Statystyki</h1>
    <div class="cms-filters-container">
        <form>
            od: <input type="text" name="date-from" value="{{$data_start}}">
            do: <input type="text" name="date-to" value="{{$data_koniec}}">
            Statystyka: <select name="type">
                <option value="day" @if ($statisticType == 'day') selected @endif>dziennie</option>
                <option value="month" @if ($statisticType == 'month') selected @endif>miesięcznie</option>
                </select>
            <input type="submit" value="Zastosuj" class="standard-button standard-big-button-green submit-filters">
        </form>
    </div>
    
    <p>
        W tym okresie:<br>
        ilość zamówień: {{$allOrders}}<br>
        ilość zamówień opłaconych: {{$payyedOrders}} @if ($allOrders > 0) ({{ round(($payyedOrders/$allOrders) * 100)}}%) @endif<br>
        suma wartości zamówień brutto: {{$payOrdersSumm}} zł<br>
    </p>
    
    <div id="orders-by-days" style="width: 100%; height: 500px;"></div>
    <div id="price-by-days" style="width: 100%; height: 500px;"></div>
    <div id="deliveries-char" style="width: 100%; height: 500px;"></div>
</div> 

<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Dzień', 'Ilość zamówień', 'Ilość zamówień opłaconych'],
            @foreach ($ordersByDays as $date => $orders)
            ['{{$date}}',  {{$orders['all']}},      {{$orders['payed']}}],
            @endforeach 
        ]);

        var options = {
          title: 'Ilość zamówień',
          hAxis: {title: 'Data',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('orders-by-days'));
        chart.draw(data, options);
        
        
        /*********/
        data = google.visualization.arrayToDataTable([
            ['Dzień', 'Wartośc opłaconych zamówień'],
            @foreach ($ordersByDays as $date => $orders)
            ['{{$date}}',  {{$orders['summ']}}],
            @endforeach 
        ]);

        options = {
          title: 'Wartość opłaconych zamówień [zł]',
          hAxis: {title: 'Data',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        chart = new google.visualization.AreaChart(document.getElementById('price-by-days'));
        chart.draw(data, options);
        
        
        /***************/

        data = google.visualization.arrayToDataTable([
          ['nazwa dostawy', 'ilość dostaw'],
          
          @foreach ($deliveriesData  as $delivery)
          ['{{$delivery->nazwa_dostawy}}',     {{$delivery->ilosc_zamowien}}],
          @endforeach 
        ]);

        options = {
          title: 'Typy dostaw wybierane przez klientów'
        };

        chart = new google.visualization.PieChart(document.getElementById('deliveries-char'));

        chart.draw(data, options);
      }
    </script>
@endsection