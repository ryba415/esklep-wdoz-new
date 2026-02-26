@extends('layouts.front')

@section('content')

@include('loader')
<div class="bg-white flex flex-col overflow-hidden items-center pt-7 pb-[46px] px-20 max-md:px-5">
    <div class="w-[1280px] max-w-full">
        <h1 class="m-auto text-center pt-1 pb-4 sm:pt-8 pl-1 pr-1 text-xl sm:text-2xl font-bold max-w-[250px] sm:max-w-[100%] text-[#008641]">{!!$title!!}</h1>
                    <p>Apteka Internetowa wdoz.pl objęta jest nadzorem Wojewódzkiego Inspektoratu Farmaceutycznego w Gdańsku:</p>

<p>Wojewódzki Inspektorat Farmaceutyczny w Gdańsku<br>
ul. Na Stoku 50<br>
80-874 Gdańsk<br>
tel: 58-300-00-92, 58-300-00-93<br>
fax: 58-320-28-58<br>
email: sekretariat@wiif.gdansk.pl</p>
    </div>
</div>

@endsection