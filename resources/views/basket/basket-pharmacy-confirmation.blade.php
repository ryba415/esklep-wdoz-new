@extends('layouts.front')

@section('content')

<meta id="cform" name="csrf-token" content="{{ csrf_token() }}">
<meta id="current-user" content="@if($isLoggedUser){{$userdata["id"]}}@endif">
<meta id="go-to-step" content="@if($goToStep != null) {{$goToStep}} @else 1 @endif">
<input type="hidden" value="{{$basket->getHash()}}" id="basket-identity">
<input type="hidden" value="@if($drogeryItemsInBasket) 1 @else 0 @endif" id="drogery-items-in-basket">
<input type="hidden" value="@if($pharmacyItemsInBasket) 1 @else 0 @endif" id="pharmacy-items-in-basket">

@include('loader')


@include('basket/basket-top-bar')

<div class="max-w-[1120px] flex flex-col mx-auto mt-8 mb-8">
@include('basket/basket-top-steps')    



    <div id="finish-step" class="flex flex-col lg:flex-row w-full gap-5">

      <div class="left" style="max-width: 700px; width: 100%; flex-grow: 10; align-self: center;">

        <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 hidden ml-3 mr-5 md:ml-0 md:mr-0" id="finish-form-errors">
            <ul id="finish-form-errors-points" class="text-red-700 p-3 pl-5 pr-5 text-sm">
            </ul>
        </div>
        <!-- twoje dane -->
        <div class="  max-w-[714px] rounded-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5  "> 
            <h3 class="w-full">Twoje dane</h3>
            <div onclick="goToDataStep()" class="inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary   hover:text-gray-900 hover:bg-wdoz-primary-10  dark:bg-wdoz-primary dark:hover:bg-wdoz-primary">                           
                <div class="flex flex-col w-full">
                    <p id="summary-personal-data" class="text-sm">
                        {!!$summaryData['p']!!}
                    </p>
                </div>
                <div class="w-full text-base font-medium text-right text-wdoz-primary underline"><a href="#">Edytuj</a></div>
            </div>
          </div>
           <!-- *twoje dane-->

        @if ($summaryData['i'] != '')
        <div id="summary-invoice-container" class="  max-w-[714px] rounded-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5  "> 
            <h3 class="w-full">Dane do faktury VAT</h3>
            <div onclick="goToDataStep()" class="inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary   hover:text-gray-900 hover:bg-wdoz-primary-10  dark:bg-wdoz-primary dark:hover:bg-wdoz-primary">                           
                <div class="flex flex-col w-full">
                    <p id="summary-invoice-data" class="text-sm">
                        {!!$summaryData['i']!!}
                    </p>
                </div>
                <div class="w-full text-base font-medium text-right text-wdoz-primary underline"><a href="#">Edytuj</a></div>
            </div>
          </div>
          @endif

           <!-- twoje dane -->
        <div class="  max-w-[714px] rounded-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5  "> 
            <h3 class="w-full">Sposób dostawy</h3>
            <div onclick="goToDataStep()" class="inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary   hover:text-gray-900 hover:bg-wdoz-primary-10  dark:bg-wdoz-primary dark:hover:bg-wdoz-primary">                           
                <div class="flex flex-col w-full">
                    <p id="summary-delivery-data" class="text-sm" >
                        {!!$summaryData['d']!!}
                    </p>
                </div>
                <div class="w-full text-base font-medium text-right text-wdoz-primary underline"><a href="#">Edytuj</a></div>
            </div>
          </div>
           <!-- *twoje dane-->

           <!-- twoje dane -->
        <div class="  max-w-[714px] rounded-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5  "> 
            <h3 class="w-full">Sposób płatności</h3>
            <div onclick="goToDataStep()" class="inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary   hover:text-gray-900 hover:bg-wdoz-primary-10  dark:bg-wdoz-primary dark:hover:bg-wdoz-primary">                           
                <div class="flex flex-col w-full">
                    <p id="summary-payment-data" class="text-sm" >
                        {!!$summaryData['m']!!}
                    </p>
                </div>
                <div class="w-full text-base font-medium text-right text-wdoz-primary underline"><a href="#">Edytuj</a></div>
            </div>
          </div>
           <!-- *twoje dane-->


           <!-- produkty apteczne-->
            @if ($basket->medicamentsCount > 0)
            <div class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white "> 
              <h3 class="text-lg font-medium pb-4">Produkty apteczne</h3> <!-- produkt 1--> 
              @foreach ($basket->basketItems as $item)
                @if ($item->is_cosmetic != 1)
                @include('basket/basket-item',['enalbeChange'=>false]) 
                @endif
              @endforeach
            </div>
            @endif
            <!-- *produkty apteczne-->

            <!-- produkty drogeryjne-->
            @if ($basket->cosmeticsCout > 0)
            <div class="border-t-4 border-wdoz-primary-drog max-w-[714px] rounded-b-lg drop-shadow-lg mb-5 p-5 bg-white "> 
              <h3 class="text-lg font-medium pb-4">Produkty drogeryjne</h3>
              @foreach ($basket->basketItems as $item)
                @if ($item->is_cosmetic == 1)
                  @include('basket/basket-item',['enalbeChange'=>false]) 
                @endif
              @endforeach
            </div>
            @endif
             <!-- *produkty drogeryjne-->


        </div>


         <!-- podsumowanie-->
         <div class="right   rounded-b-lg drop-shadow-lg p-5 bg-white max-w-[700px] w-full lg:w-[370px] gap-3 self-center  md:flex-1 lg:self-baseline"> 

             @if ($basket->medicamentsCount > 0)
          <div id="basket-medicaments-finish-price-container" class="flex flex-row pb-2 justify-between text-md font-normal">  
                <span>Produkty apteczne</span>
                <div class="text-md font-semibold">
                    <span id="basket-medicaments-finish-price" class="text-md font-semibold">{{$item->diplayPrice($basket->medicamentsValueGross)}}</span> zł
                </div>
          </div>
             @endif 
             @if ($basket->cosmeticsValueGross > 0) 
          <div id="basket-cosmetics-finish-price-container" class="flex flex-row pb-2 justify-between text-md font-normal">  
                <span>Produkty drogeryjne</span>
                <div class="text-md font-semibold">  
                    <span id="basket-cosmetics-finish-price" class="text-md font-semibold">{{$item->diplayPrice($basket->cosmeticsValueGross)}}</span> zł
                </div>
          </div>
            @endif 
          <div class="flex flex-row pb-2 justify-between text-md font-normal">  
                <span>Dostawa</span>
                <div class="text-md font-semibold">  
                    <span id="basket-delivery-finish-price" class="text-md font-semibold">{{$item->diplayPrice($deliveryPrice)}}</span> zł
                </div>
          </div>  
            



          <div class="flex flex-row  pt-3 justify-between border-t mt-3 flex-wrap">  
            <span class="text-md font-bold  ">Podsumowanie</span>
            <div class="text-md font-semibold">
            <span id="basket-finish-price" class="text-md font-semibold">{{$item->diplayPrice(floatval($basket->medicamentsValueGross) + floatval($basket->cosmeticsValueGross) + floatval($deliveryPrice))}}</span><span>zł</span>
            </div>
            @if ($pharmacyItemsInBasket)
            <div class="inline-flex items-center py-4 w-full input-field-container">
              <label class="flex items-center cursor-pointer relative" for="check-2">
                <input type="checkbox"
                       id="check-2"
                       autocomplete="off"
                  class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary" id="check-2" />
                <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                    stroke="currentColor" stroke-width="1">
                    <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
                  </svg>
                </span>
              </label>
              <label class="cursor-pointer ml-3 text-slate-600 text-xs" for="check-2">
                Akceptuję <a href="#">Regulamin Apteki</a> <span class="redStar ml-1 text-lg text-red-600">* </span></span>
              </label>
            </div>
            @endif

            <div class="inline-flex items-start py-4 w-full">
              <label class="flex items-center cursor-pointer relative" for="check-3">
                <input type="checkbox"
                       autocomplete="off"
                  class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary" id="check-3" />
                <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                    stroke="currentColor" stroke-width="1">
                    <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
                  </svg>
                </span>
              </label>
              <label class="cursor-pointer ml-3 pt-1 text-slate-600 text-xs" for="check-3">Wyrażam zgodę na otrzymywanie newslettera i informacji handlowych od Apteki Internetowej Wracam do zdrowia, www.wdoz.pl. Jestem świadom przysługującego mi prawa do cofnięcia wyrażonej zgody w każdym czasie. Wówczas przekazane dane będą przetwarzane do momentu cofnięcia zgody. Administratorem danych osobowych jest „Wracam do zdrowia 8” sp. z o.o., adres: ul. Remusa 6, 81-574 Gdynia. Administrator przetwarza dane zgodnie z obowiązującym prawem oraz Regulaminem Newslettera.
              </label>
            </div> 

            <p class="text-xs"><span class="text-xl text-red-600">*</span> pola oznaczone czerwoną gwiazdką są obowiązkowe</p>

            <button id="finish-and-buy-now" class="bg-wdoz-primary text-white mt-4 rounded p-4 shadow text-sm font-semibold" style="flex-basis: 700px;">Kup i zapłać</button>
          </div>



        </div>
    <!-- *podsumowanie-->
    </div>


    <script>
    document.getElementById('finish-and-buy-now').addEventListener("click", (event) => {
        showGlobalLoader();
        
        if (!document.getElementById('check-2').checked){
            let errosPoints = document.getElementById('finish-form-errors-points');
            let errorsDescriptionContainer = document.getElementById('finish-form-errors');
            errorsDescriptionContainer.classList.remove('hidden');
            errosPoints.innerHTML = '';
            
            let newErrorLi = document.createElement("li");
            newErrorLi.innerHTML = 'Akceptacja regulaminu jest polem obowiązkowym';
            errosPoints.appendChild(newErrorLi);
            
            let input = document.getElementById('check-2');
            //let errorArea = input.closest('.input-field-container').querySelector('.field-error-info');
            //if (errorArea == null){
            //    input.closest('.input-field-container').classList.add('area-validation-error');
            //}
            //if (errorArea != null){
            //    errorArea.innerHTML = 'akceptacja regulaminu jest polem obowiązkowym';
            //    errorArea.classList.remove('hidden');
            //    input.classList.add('area-validation-error');
            //}
            
            hideGlobalLoader();
            
            window.scrollTo({top: 0, behavior: 'smooth'});
        } else {
            
            let newsletterAgree = 0;
            if (!document.getElementById('check-3').checked){
                newsletterAgree = 1;
            }
            let url = '@if (Config::get('constants.use_ssl')){{'https://'}}@else{{'http://'}}@endif{{Config::get('constants.drogeria_domain')}}' + '/koszyk?sumbitBuy=1&newsletterAgree=' + newsletterAgree;
            window.location.replace(url);
        }
        
        
        
        
    });
    
    document.addEventListener("DOMContentLoaded", (event) => {

        document.getElementById('top-header-main-logo').classList.add('hidden');
        document.getElementById('top-header-pharmacy-logo').classList.remove('hidden');

        document.getElementById('footer-legal-pharmacy').classList.remove('hidden');

        document.getElementById('footer-apteka-info').classList.remove('hidden');
        document.getElementById('footer-cookies-apteka-info').classList.remove('hidden');
        document.getElementById('footer-cookies-drogeria-info').classList.add('hidden');
        document.getElementById('footer-rules-apteka-info').classList.remove('hidden');
        document.getElementById('footer-rules-drogeria-info').classList.add('hidden');
        document.getElementById('footer-permit-apteka-info').classList.remove('hidden');
        document.getElementById('footer-wif-apteka-info').classList.remove('hidden');
        document.getElementById('footer-apteka-email').classList.remove('hidden');
        document.getElementById('footer-drogeria-email').classList.add('hidden');
        document.getElementById('header-apteka-email').classList.remove('hidden');
        document.getElementById('header-drogeria-email').classList.add('hidden');
        document.getElementById('footer-newsleter-apteka-rules-span').classList.remove('hidden');
        document.getElementById('footer-newsleter-drogeria-rules-span').classList.add('hidden');
        
        
        document.getElementById('footer-pharmacy-logo').classList.remove('hidden');
        document.getElementById('footer-drogeria-logo').classList.add('hidden');
        
    });
    </script>

    
</div>    

@endsection
