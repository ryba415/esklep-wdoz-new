@extends('layouts.front')

@section('content')

@include('loader')

<nav class="">
    <ol class="mt-5 mb-5 flex flex-wrap items-center justify-around pl-2 pr-2 gap-y-1">
        <li class="crumb "><a id="show-user-data" class="xl:min-w-[170px]  cursor-pointer inline-block m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 text-center max-w-[350px] p-1" >Moj dane <span class="text-[#008641] font-bold ml-1">></span></a></li>
        <!--<li class="crumb xl:w-[100%]"><a class="xl:min-w-[170px] inline-block m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 text-center max-w-[350px] p-1" href="#">Dane do wysyłki <span class="text-[#008641] font-bold ml-1">></span></a></li>-->
        <li class="crumb "><a id="show-orders-data" class="bg-white xl:min-w-[170px] cursor-pointer inline-block m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 text-center max-w-[350px] p-1" >Historia zamówień <span class="text-[#008641] font-bold ml-1">></span></a></li>
        <li class="crumb "><a class="bg-white xl:min-w-[170px]  inline-block m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 text-center max-w-[350px] p-1" href="/logout">Wyloguj <span class="text-[#008641] font-bold ml-1">></span></a></li>
    </ol>  
</nav>

@include('user-acount/edit-user-data')

<script>
    document.getElementById('show-user-data').addEventListener("click", (event) => {
        document.getElementById('orders-container').classList.add('hidden');
        document.getElementById('user-data-container').classList.remove('hidden');
        document.getElementById('show-user-data').classList.remove('bg-white');
        document.getElementById('show-orders-data').classList.add('bg-white');
    });
    
    document.getElementById('show-orders-data').addEventListener("click", (event) => {
        document.getElementById('orders-container').classList.remove('hidden');
        document.getElementById('user-data-container').classList.add('hidden');
        document.getElementById('show-user-data').classList.add('bg-white');
        document.getElementById('show-orders-data').classList.remove('bg-white');
    });
</script>

@endsection