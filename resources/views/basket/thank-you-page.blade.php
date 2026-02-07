@extends('layouts.front')

@section('content')

@include('loader')

<div class="max-w-[1120px] flex flex-col mx-auto mt-10 mb-20">
    <div class="flex flex-col lg:flex-row w-full gap-5 justify-center">
        <div class="left" style="max-width: 700px; width: 100%; flex-grow: 10; align-self: center;">
            @if ($findedOrder)
            <h1 class="text-lg pb-4 text-center font-bold p-5">Dziękujemy za dokonanie zakupu</h1>
            <div class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg p-5 mb-5 bg-white shadow-lg"> 
                <h2 class="text-lg font-medium pb-4 text-center">Przyjęto nowe zamówienie.</h2>
                <p class="text-sm pb-4">Twoje zamówienie otrzymało nr: <span class="text-black font-bold">{{$order->name}}</span></p>

                <p class="text-sm pb-4">Dołożymy wszelkich starań, aby możliwie najszybciej dostarczyć zamówione produkty.</p>

                <p class="text-sm pb-4">Realizacja zamówienia rozpocznie się po zaksięgowaniu płatności za zamówienie na koncie bankowym.<br><br></p>
                
                @if ($order->payment_type == 'on')
                <p class="text-sm pb-4">W celu opłacenia zamówienia prosimy o dokananie przelewu na poniższy rachunek bankowy:</p>

                <p class="text-sm pb-4 font-bold">{{Config::get('constants.bank_acount_recipent')}}<br>
                {{Config::get('constants.bank_acount_number')}}<br>
                kwota: {{number_format(floatval($order->value_gross), 2,',',' ')}} zł<br></p>

                <p class="text-sm pb-4 ">W tytule płatności prosimy wpisać: <span class="font-bold">opłata za zamówienie {{$order->name}}</span></p>
                @endif
                
                <div class="flex pt-4 pb-8 justify-evenly flex-wrap">
                    @if($order->user_id != null && $order->user_id != '')
                    <a href="/profile/profil" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base mx-3 my-3 ">Moje konto</a>
                    @endif
                    <a href="/" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base mx-3 my-3  ">Przejdź do strony głównej</a>
                    
                </div>
            </div>
            @else
            <h1 class="text-lg font-medium pb-4 text-center">Wystąpił błąd</h1>
            <div class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white "> 
                <p>Twoje zamówienie zostało zapisane, ale podczas jego procesowania wystąpił błąd. Skontaktuj się z obsługą klienta w celu rozwiązania problemu.</p>
            </div>
            @endif
    </div>
</div>

@endsection