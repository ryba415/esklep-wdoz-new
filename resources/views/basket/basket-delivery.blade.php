<div id="data-step" class="max-w-[1120px] flex flex-col mx-auto opacity-0 h-0 hidden">
<div class="flex flex-col lg:flex-row w-full gap-5">
    <div class="left" style="max-width: 700px; width: 100%; flex-grow: 10; align-self: center;">
        <!-- Twoje dane -->

        <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 hidden ml-3 mr-5 md:ml-0 md:mr-0" id="delivery-form-errors">
            <ul id="delivery-form-errors-points" class="text-red-700 p-3 pl-5 pr-5 text-sm">
            </ul>
        </div>

        <div id="zmiana" class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5"> 
          <h3 class="w-full">Twoje dane</h3>
            <div class="relative w-full sm:w-[48%]">
                <input type="text" id="buy-form-name" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-name" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Imię</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="buy-form-surname" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-surname" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nazwisko</label>
            </div>

            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="buy-form-email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-email" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Adres e-mail</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="buy-form-phone" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-phone" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Telefon</label>
            </div>



            <div class="inline-flex items-center py-4 w-full">
              <label class="flex items-center cursor-pointer relative" for="need-invoice-checkbox">
                <input autocomplete="off" id="need-invoice-checkbox" type="checkbox" class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary" />
                <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                    stroke="currentColor" stroke-width="1">
                    <path fill-rule="evenodd"
                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                    clip-rule="evenodd"></path>
                  </svg>
                </span>
              </label>
              <label class="cursor-pointer ml-2 text-slate-600 text-sm" for="need-invoice-checkbox">
                Chcę otrzymać fakturę VAT
              </label>
            </div>




          <div id="invoice-data-container" class="max-w-[714px] p-0 mb-5 bg-white flex flex-wrap flex-row gap-5 hidden">
            <div class="relative w-full sm:w-[48%] " style="flex-shrink: 0;">
                <select autocomplete="off" type="text" id="invoice-type-select" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 z-10 śpeer" placeholder=" ">
                  <option value="company">Faktura na firmę</option>
                  <option value="person">Faktura na osobę fizyczną</option>
                </select>
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="invoice-type-select" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Typ faktury</label>
                <img src="images/down-arrow-svgrepo-com.svg" class="absolute  top-[18px] right-3 text-sm text-gray-500  duration-300 transform  w-4  z-1"/>
            </div>
            <div></div>

            <div id="invoice-company-name-container" class="relative w-full sm:w-[48%]" >
              <input type="text" id="buy-form-company" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
              <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
              <label for="buy-form-company" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nazwa firmy</label>
            </div>

            <div  id="invoice-company-vat-number-container" class="relative w-full sm:w-[48%]" >
              <input type="text" id="buy-form-nip" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
              <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
              <label for="buy-form-nip" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">NIP</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
              <input type="text" id="buy-form-invoice-street" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
              <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
              <label for="buy-form-invoice-street" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Ulica</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
              <input type="text" id="buy-form-invoice-house-number" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
              <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
              <label for="buy-form-invoice-house-number" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nr domu / mieszkania</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
              <input type="text" id="buy-form-invoice-city" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
              <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
              <label for="buy-form-invoice-city" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Miejscowość</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
              <input type="text" id="buy-form-invoice-zipcode" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
              <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
              <label for="buy-form-invoice-zipcode" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Kod pocztowy</label>
            </div>
        </div>
        </div>
         <!-- *Twoje dane-->

        <!-- Sposob -->
        <div id="zmiana" class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5  "> 

          <h3 class="w-full">Sposób dostawy</h3>


          <ul class="flex flex-col w-full gap-4">
            @foreach ($deliveryMethods as $i => $method)
            <li class="delivery-method-in-basket <?= ($medicamentsInBasket && ($method->show_orlen_widget == 1 || $method->show_inpost_widget == 1))?'  opacity-40 pointer-events-none grayscale':'' ?>"> 
              <input type="radio" id="delivery-{{$method->id}}" name="select-delivey-method"
                    data-orlen-widget="{{$method->show_orlen_widget}}"
                    data-inpost-widget="{{$method->show_inpost_widget}}"
                    data-method-id="{{$method->id}}"
                    autocomplete="off" value="delivery-{{$method->id}}" class="hidden peer delivey-method-radio" />
              <label for="delivery-{{$method->id}}" class="inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary  hover:text-gray-900 hover:bg-wdoz-primary-10  ">                           
                <div class="flex flex-col w-full">
                  <div class="w-full text-sm sm:text-base font-medium delivery-name">{{$method->name}}</div>
                  <div class="w-full text-sm hidden sm:inline-flex">{{$method->description}}</div>
                  @if ($method->show_orlen_widget == 1)
                    <div id="selected-orlen-point-visible" class="selected-visible font-semibold mt-4 mb-4 hidden"></div>
                    <input id="selected-orlen" type="hidden" autocomplete="off" name="selected-orlen" value="">
                    <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                  @endif  
                  @if ($method->show_inpost_widget == 1)
                    <div id="selected-paczkomat-visible" class="font-semibold mt-4 mb-4 hidden"></div>
                    <input id="selected-paczkomat" type="hidden" autocomplete="off" name="selected-paczkomat" value="">
                    <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>    
                  @endif
                </div>
                  <div data-price="@if ($basket->valueGross > $basket->freeDeliveryFromValue) 0 @else{{$basket->diplayPrice($method->payu_price)}}@endif" class="text-right text-base sm:text-lg font-medium text-nowrap delivery-price">@if ($basket->valueGross > $basket->freeDeliveryFromValue) 0 @else {{$basket->diplayPrice($method->payu_price)}} @endif zł</div>
                <img src="{{$method->logo_image}}" alt="{{$method->name}}" class=" right-3 text-sm text-gray-500 duration-300 transform w-11 z-10"/>
              </label>
            </li>
            @if ($medicamentsInBasket && ($method->show_orlen_widget == 1 || $method->show_inpost_widget == 1))
            <div class="paczkomat-unavariable-info text-xs text-red-700 mt-[-15px]">Twój koszyk zawiera produkt leczniczy – wysyłka poprzez {{$method->name}} niemożliwa.</div>
            @endif
            @if ($method->show_orlen_widget == 1)
            <div id="widget-orlen-html" class="hidden"></div>
            @endif
            @if ($method->show_inpost_widget == 1)
            <div id="easypack-map" class="selected-visible font-semibold mt-4 mb-4 hidden"></div>
            @endif
            @endforeach
          </ul>
        </div>
         <!-- *Sposob dostawy-->

        <table class="hidden"><tr>
        <td><button onclick="button_init()" id="but_i">INIT</button></td>
        <td><button onclick="button_show()" id="but_s" style="display: none;">SHOW</button></td>
        <td><button onclick="button_hide()" id="but_h" style="display: none;">HIDE</button></td>
        <td id="start_adr"> Start (adres lub id punktu): <input type="text" id="start"/></td>
        <td id="codtd"> COD: <input type="text" id="cod" value="0"/></td>
        <td id="typetd"> Typ: <input type="text" id="type" value="" placeholder="P = PSD, R = PSP, A = PPP"/></td>
        <td> <div id="status"></div></td>
        </tr></table>

         <!-- Dane dostawy -->
        <div id="delivery-data-container" class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5"> 

          <h3 class="w-full">Adres dostawy</h3>
            <div class="relative w-full sm:w-[48%]">
                <input type="text" id="buy-form-street" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-street" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Ulica</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="buy-form-chouse-number" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-chouse-number" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Numer domu / mieszkania</label>
            </div>

            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="buy-form-city" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-city" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Miejscowość</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="buy-form-zipcode" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="buy-form-zipcode" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Kod pocztowy</label>
            </div>


        </div>
         <!-- *Dane dostawy-->


        <!-- Sposob -->
        <div id="zmiana" class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5  "> 

          <h3 class="w-full">Metoda płatności</h3>


          <ul class="flex flex-col w-full gap-4">
            <li>
              <input type="radio" id="platnosc-online" name="payment-method" value="przelewpaynow" autocomplete="off"  class="hidden peer payment-method-input"/>
              <label for="platnosc-online" class="inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary   hover:text-gray-900 hover:bg-wdoz-primary-10  dark:bg-wdoz-primary dark:hover:bg-wdoz-primary">                           
                <div class="flex flex-col w-full">
                  <div class="w-full text-base font-medium payment-name">Płatność on-line</div>
                  <div class="w-full text-sm">przelew / karta / blik</div>
                </div>
                 <img src="images/platnosc-online.png" class=" right-3 text-sm text-gray-500 duration-300 transform h-6 z-10"/>
              </label>
            </li>
            <li>
              <input type="radio" id="platnosc-przelewem" name="payment-method" value="on" class="hidden peer payment-method-input"/>
              <label for="platnosc-przelewem" class="h-[62px] inline-flex gap-4 items-center justify-between w-full p-2 px-4 bg-white border border-1 border border-wdoz-input-border rounded cursor-pointer peer-checked:bg-wdoz-primary-10 peer-checked:border-wdoz-primary   hover:text-gray-900 hover:bg-wdoz-primary-10  dark:bg-wdoz-primary dark:hover:bg-wdoz-primary">                           
                <div class="flex flex-col w-full">
                  <div class="w-full text-base font-medium payment-name">Płatność przelewem tradycyjnym</div>

                </div>

              </label>
            </li>

          </ul>




        </div>


    </div>


 <!-- podsumowanie-->
 <div class="right   rounded-b-lg drop-shadow-lg p-5 bg-white max-w-[700px] w-full lg:w-[370px] gap-3 self-center  md:flex-1 lg:self-baseline"> 
 
  <div class="flex flex-row pb-2 justify-between">  
      <span class="text-md font-normal">Produkty apteczne</span>
      <div class="text-md font-semibold">
          <span id="basket-medicaments-summary-price2">{{$basket->diplayPrice($basket->medicamentsValueGross)}}</span> zł
      </div>
  </div>
  <div class="flex flex-row pb-2 justify-between">  
    <span class="text-md font-normal">Produkty drogeryjne</span>
    <div class="text-md font-semibold">
        <span id="basket-cosmetics-summary-price2">{{$basket->diplayPrice($basket->cosmeticsValueGross)}}</span> zł
    </div>
  </div>
 
    @if ($basket->freeDeliveryFromValue !== null) 
    <div id="missing-for-free-delivery-container2" class="flex flex-col bg-wdoz-body-bg border text-right justify-end p-2 @if ($basket->valueGross >= $basket->freeDeliveryFromValue) hidden @endif">
        <span class="text-sm font-normal">Darmowa wysyłka od {{$basket->diplayPrice($basket->freeDeliveryFromValue)}} zł</span>
        <span class="text-sm font-normal">Do darmowej wysyłki brakuje: <span id="missing-for-free-delivery2">{{$basket->diplayPrice($basket->freeDeliveryFromValue-$basket->valueGross)}}</span> zł</span>
    </div>
    <div id="get-free-delivery-container2" class="flex flex-col bg-wdoz-body-bg border text-right justify-end p-2 text-gray-900 bg-wdoz-primary-10 @if ($basket->valueGross < $basket->freeDeliveryFromValue) hidden @endif">
        <span class="text-sm font-normal">Otrzymujesz darmową wysyłkę!</span>
    </div>
    @endif


  <div class="flex flex-row  pt-3 justify-between border-t mt-3 flex-wrap">  
    <span class="text-md font-bold  ">Podsumowanie</span>
    <div class="text-md font-semibold">
        <span id="basket-summary-price2">{{$basket->diplayPrice($basket->valueGross)}}</span> zł
    </div>
    
    @if ($drogeryItemsInBasket)
    <div class="inline-flex items-start py-4 w-full">
      <label class="flex items-center cursor-pointer relative"  for="accept-rules1">
        <input type="checkbox" autocomplete="off" id="accept-rules1"
          class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary" id="accept-rules1" />
        <span class="pointer-events-none absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
            stroke="currentColor" stroke-width="1">
            <path fill-rule="evenodd"
            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
            clip-rule="evenodd"></path>
          </svg>
        </span>
      </label>
      
      <label class="cursor-pointer ml-2 text-slate-600 text-xs" for="accept-rules1">
        <span class="text-xl text-red-600">*</span>

        Oświadczam, że zapoznałem się z obowiązującym w Drogerii Internetowej Wracam do zdrowia <a style="color:#38900D" target="blank" href="/podstrona/regulamin/">Regulaminem</a> i wyrażam chęć zawarcia umowy sprzedaży do, której Regulamin ten będzie miał zastosowanie.
        
        <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
      </label>
      
    </div>
    @endif
    

    <div class="inline-flex items-start py-4 w-full">
      <label class="flex items-center cursor-pointer relative" for="accept-rules-newsletter">
        <input type="checkbox" autocomplete="off"
          class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary" id="accept-rules-newsletter" />
        <span class="pointer-events-none absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
            stroke="currentColor" stroke-width="1">
            <path fill-rule="evenodd"
            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
            clip-rule="evenodd"></path>
          </svg>
        </span>
      </label>
      <label class="cursor-pointer ml-2 text-slate-600 text-xs" for="accept-rules-newsletter">Wyrażam zgodę na otrzymywanie newslettera i informacji handlowych od Wracam do zdrowia (www.wracamdozdrowa.pl). Jestem świadom przysługującego mi prawa do cofnięcia wyrażonej zgody w każdym czasie. Wówczas przekazane dane będą przetwarzane do momentu cofnięcia zgody. Administratorem danych osobowych jest „Wracam do zdrowia 8" sp. z o.o., adres: ul. Remusa 6, 81-574 Gdynia. Administrator przetwarza dane zgodnie z obowiązującym prawem oraz.
      </label>
    </div> 

    <p class="text-xs"><span class="text-xl text-red-600">*</span> pola oznaczone czerwoną gwiazdką są obowiązkowe</p>

    <button id="validate-buy-form" class="bg-wdoz-primary text-white mt-4 rounded p-4 shadow text-sm font-semibold" style="flex-basis: 700px;">Dalej</button>
  </div>
    
    
 
 
  
</div>
<!-- *podsumowanie-->
</div>
    
    <div class="w-[100%] flex justify-center">
        <div class="flex justify-center sm:justify-start w-[100%] pt-5" >
        <a href="/koszyk" class=" text-black mt-4 rounded p-3 shadow text-base mt-5 lg:inline-block">Wróć do koszyka</a>
        </div>
    </div>
    
</div>


<script>
    
    document.getElementById('need-invoice-checkbox').addEventListener("change", (event) => {
        showHideInvoideContainer();
    });
    
    document.getElementById('invoice-type-select').addEventListener("change", (event) => {
        changeInvoiceType();
    });
    
    let deliveryRadios = document.querySelectorAll('.delivey-method-radio');
    for (let i=0;i<deliveryRadios.length;i++){
        deliveryRadios[i].addEventListener("change", (event) => {
            deliveryChanged(event.target);
        });
    }
    
    document.getElementById('validate-buy-form').addEventListener("click", (event) => {
        validateBuyForm();
    });
    
    function validateBuyForm(buyNow = false){
        showGlobalLoader();

        if(buyNow == true){
            const rulesEl = document.getElementById('check-2');
            const rulesErr = document.getElementById('check-2-error');
            if (rulesEl) {
                rulesEl.classList.remove('area-validation-error');
                if (rulesErr) {
                    rulesErr.classList.add('hidden');
                    rulesErr.innerHTML = '';
                }

                if (!rulesEl.checked) {
                    rulesEl.classList.add('area-validation-error');
                    if (rulesErr) {
                    rulesErr.innerHTML = 'Akceptacja regulaminu jest polem obowiązkowym';
                    rulesErr.classList.remove('hidden');
                    }
                    hideGlobalLoader();
                    rulesEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }
            }
        }

        let formdata = {};
        
        formdata['buyNow'] = buyNow;
        formdata['buy-form-name'] = document.getElementById('buy-form-name').value;
        formdata['buy-form-surname'] = document.getElementById('buy-form-surname').value;
        formdata['buy-form-email'] = document.getElementById('buy-form-email').value;
        formdata['buy-form-phone'] = document.getElementById('buy-form-phone').value;
        if (document.getElementById('need-invoice-checkbox').checked){
            formdata['need-invoice-checkbox'] = 1;
        } else {
            formdata['need-invoice-checkbox'] = 0;
        }
        formdata['invoice-type-select'] = document.getElementById('invoice-type-select').value;
        formdata['buy-form-company'] = document.getElementById('buy-form-company').value;
        formdata['buy-form-nip'] = document.getElementById('buy-form-nip').value;
        formdata['buy-form-invoice-street'] = document.getElementById('buy-form-invoice-street').value;
        formdata['buy-form-invoice-house-number'] = document.getElementById('buy-form-invoice-house-number').value;
        formdata['buy-form-invoice-city'] = document.getElementById('buy-form-invoice-city').value;
        formdata['buy-form-invoice-zipcode'] = document.getElementById('buy-form-invoice-zipcode').value;
        let selectedDelivery = document.querySelector('.delivey-method-radio[name="select-delivey-method"]:checked');
        
        let useOrlenWidget = false;
        let useInpostWidget = false;
        let deliveryId = '';
        let selectedDeliveryName = '';
        let deliveryPrice = 0;
        if (selectedDelivery != null){
            formdata['select-delivey-method'] = selectedDelivery.value;
            useOrlenWidget = selectedDelivery.getAttribute('data-orlen-widget');
            useInpostWidget = selectedDelivery.getAttribute('data-inpost-widget');
            deliveryId = selectedDelivery.getAttribute('data-method-id');
            selectedDeliveryName = selectedDelivery.closest('li').querySelector('.delivery-name').innerText;
            deliveryPrice = parseFloat(selectedDelivery.closest('li').querySelector('.delivery-price').getAttribute('data-price').replace(',','.'));
        } else {
            formdata['select-delivey-method'] = '';
        }
        formdata['select-delivey-method-id'] = deliveryId;
        formdata['use-orlen-widget'] = useOrlenWidget;
        formdata['use-inpost-widget'] = useInpostWidget;
        
        let orlenSelectedContainer = document.getElementById('selected-orlen');
        if (orlenSelectedContainer != null){
            formdata['selected-orlen'] = orlenSelectedContainer.value;
        } else {
            formdata['selected-orlen'] = '';
        }
        let paczkomatSelectedContainer = document.getElementById('selected-paczkomat');
        if (paczkomatSelectedContainer != null){
            formdata['selected-paczkomat'] = paczkomatSelectedContainer.value;
        } else {
            formdata['selected-paczkomat'] = '';
        }
        
        formdata['buy-form-street'] = document.getElementById('buy-form-street').value;
        formdata['buy-form-chouse-number'] = document.getElementById('buy-form-chouse-number').value;
        formdata['buy-form-city'] = document.getElementById('buy-form-city').value;
        formdata['buy-form-zipcode'] = document.getElementById('buy-form-zipcode').value;
        let selectedPayment = document.querySelector('.payment-method-input[name="payment-method"]:checked');
        let selectedPaymentName = '';
        if (selectedPayment != null){
            formdata['select-payment-method'] = selectedPayment.value;
            selectedPaymentName = selectedPayment.closest('li').querySelector('.payment-name').innerText;
        } else {
            formdata['select-payment-method'] = '';
        }
        if (document.getElementById('accept-rules1') == null || document.getElementById('accept-rules1').checked){
            formdata['accept-rules1'] = true;
        } else {
            formdata['accept-rules1'] = false;
        }
        if (document.getElementById('accept-rules-newsletter').checked){
            formdata['accept-rules-newsletter'] = true;
        } else {
            formdata['accept-rules-newsletter'] = false;
        }
        formdata['basket-hash'] = document.getElementById('basket-identity').value;
        
        fetch('/buy-now', { // buy-now  validate-delivery-data
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                formdata
            })
        }).then(response => {
            if(response.ok){
                return response.json();  
            }
            throw new Error('Request failed!');
            hideGlobalLoader();
        }, networkError => {
            console.log(networkError.message);
            hideGlobalLoader();
        }).then(jsonResponse => {
            if (typeof rebuildBasket != 'undefined'){
                setTimeout(() => {
                    rebuildBasket();
                }, "400");
            }
            
            let errorsDescriptionContainer = document.getElementById('delivery-form-errors');
            if (buyNow){
                errorsDescriptionContainer = document.getElementById('finish-form-errors');
            }
            let errosPoints = document.getElementById('delivery-form-errors-points');
            if (buyNow){
                errosPoints = document.getElementById('finish-form-errors-points');
            }
            
            let errorInfoFields = document.querySelectorAll('.field-error-info');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.add('hidden');
            }
            
            errorInfoFields = document.querySelectorAll('.area-validation-error');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.remove('area-validation-error');
            }
            if (jsonResponse.status){
                errorsDescriptionContainer.classList.add('hidden');
                errosPoints.innerHTML = '';
                document.getElementById('summary-personal-data').innerHTML = formdata['buy-form-name'] + ' ' + formdata['buy-form-surname'] + '<br>' + formdata['buy-form-email'] + '<br>' + formdata['buy-form-phone'];
                if (formdata['need-invoice-checkbox'] == 1){
                    document.getElementById('summary-invoice-container').classList.remove('hidden');
                    document.getElementById('summary-invoice-data').innerHTML = formdata['buy-form-company'] + '<br>' + formdata['buy-form-nip'] + '<br>' +
                            formdata['buy-form-invoice-street'] + ' ' + formdata['buy-form-invoice-house-number'] + '<br>' +
                            formdata['buy-form-invoice-zipcode'] + ' ' + formdata['buy-form-invoice-city'];
                } else {
                    document.getElementById('summary-invoice-container').classList.add('hidden');
                }
                

                if (useOrlenWidget == 1){
                    document.getElementById('summary-delivery-data').innerHTML = 'Orlen paczka<br>' + formdata['selected-orlen'];
                }
                if (useInpostWidget == 1){
                    document.getElementById('summary-delivery-data').innerHTML = 'Poczkomat InPost<br>' + formdata['selected-orlen'];
                }
                if (useOrlenWidget != 1 && useInpostWidget != 1){
                    document.getElementById('summary-delivery-data').innerHTML = 'Kurier' + '<br>' +
                            formdata['buy-form-street'] + ' ' + formdata['buy-form-chouse-number'] + '<br>' + 
                            formdata['buy-form-zipcode'] + ' ' + formdata['buy-form-city'];
                }
                
                document.getElementById('summary-payment-data').innerHTML = selectedPaymentName;
                
                document.getElementById('basket-medicaments-finish-price').innerHTML = document.getElementById('basket-medicaments-summary-price').innerHTML;
                document.getElementById('basket-cosmetics-finish-price').innerHTML = document.getElementById('basket-cosmetics-summary-price').innerHTML;
                document.getElementById('basket-medicaments-finish-price-container').classList = document.getElementById('basket-medicaments-summary-price-container').classList;
                document.getElementById('basket-cosmetics-finish-price-container').classList = document.getElementById('basket-cosmetics-summary-price-container').classList;
                
                document.getElementById('basket-finish-price').innerHTML = priceFormat(parseFloat(document.getElementById('basket-summary-price').innerText) + parseFloat(deliveryPrice));
                document.getElementById('basket-delivery-finish-price').innerHTML = priceFormat(parseFloat(deliveryPrice));

                
                goToFinishStep();
                
                if (buyNow){
                    //opinie ceneo
                    let ceneoBasketItems = [];
                    let ceneoAmount = 0;
                    for (let ii=0;ii<jsonResponse.basket.basketItems.length;ii++){
                        ceneoBasketItems.push(
                        {
                            'id': String(jsonResponse.basket.basketItems[ii].id),
                            'price': parseFloat(jsonResponse.basket.basketItems[ii].priceGross),
                            'quantity': parseInt(jsonResponse.basket.basketItems[ii].quantity),
                            'currency': 'PLN'
                        });
                        ceneoAmount = ceneoAmount + parseFloat(jsonResponse.basket.basketItems[ii].valueGross);
                    }
                    _ceneo('transaction', {
                        client_email: document.getElementById('buy-form-email').value,
                        order_id: String(jsonResponse.orderId),
                        shop_products: ceneoBasketItems,
                        work_days_to_send_questionnaire: 5, 
                        amount: ceneoAmount
                    });
                    
                    window.location.href = jsonResponse.redirectUrl;
                }
            } else {
                errorsDescriptionContainer.classList.remove('hidden');
                errosPoints.innerHTML = '';
                for(let i=0; i<jsonResponse.errors.length; i++){
                    let newErrorLi = document.createElement("li");
                    newErrorLi.innerHTML = jsonResponse.errors[i];
                    errosPoints.appendChild(newErrorLi);
                }
                for(let i=0; i<jsonResponse.errorsAreas.length; i++){
                    let input = document.getElementById(jsonResponse.errorsAreas[i]);
                    if (input != null){
                        let errorArea = input.parentNode.querySelector('.field-error-info');
                        if (errorArea == null){
                            errorArea = input.parentNode.parentNode.querySelector('.field-error-info');
                        }
                        if (errorArea != null){
                            errorArea.innerHTML = jsonResponse.errors[i];
                            errorArea.classList.remove('hidden');
                            input.classList.add('area-validation-error');
                        }
                    }
                }
                
                window.scrollTo({top: 0, behavior: 'smooth'});
                
                
            }
            
            hideGlobalLoader();
        });
    }
    
    
    function deliveryChanged(radio){
        if (radio.getAttribute('data-orlen-widget') == 1){
            showOrlenWidget(radio);
            document.getElementById('widget-orlen-html').style.display = 'block';
            document.getElementById('delivery-data-container').classList.add('hidden');
        } else {
            document.getElementById('selected-orlen-point-visible').classList.add('hidden');
            document.getElementById('widget-orlen-html').style.display = 'none';
        }
        if (radio.getAttribute('data-inpost-widget') == 1){
            showInpostWidget(radio);
            document.getElementById('easypack-map').classList.remove('hidden');
            document.getElementById('easypack-map').style.display = 'block';
            document.getElementById('delivery-data-container').classList.add('hidden');
        } else {
            document.getElementById('easypack-map').classList.add('hidden');
            document.getElementById('easypack-map').style.display = 'none';
            document.getElementById("selected-paczkomat-visible").classList.add('hidden');;
        }
        
        if (radio.getAttribute('data-orlen-widget') != 1 && radio.getAttribute('data-inpost-widget') != 1){
            document.getElementById('delivery-data-container').classList.remove('hidden');
        }
    }
    
    function showInpostWidget(input){
        //var input = document.querySelector('.delivery[show-inpost-widget="1"]').querySelector('input[name="delivery"]');
        //if (input.checked){
        
        
            //document.querySelector('.delivery[show-inpost-widget="1"]').classList.add("delivery-method-container-map-active");
            //document.getElementById("easypack-map-container").classList.add("easypack-map-container-visible");
            let isMapReady = input.getAttribute('data-map-ready');
            if (isMapReady != '1'){
                showGlobalLoader();
                let head  = document.getElementsByTagName('head')[0];
                let link  = document.createElement('link');
                link.rel  = 'stylesheet';
                link.type = 'text/css';
                link.href = 'https://geowidget.easypack24.net/css/easypack.css';
                head.appendChild(link);
                
                input.setAttribute('data-map-ready',1);
                let script = document.createElement("script");
                script.type = "text/javascript";
                script.src = "https://geowidget.easypack24.net/js/sdk-for-javascript.js"; 
                document.getElementsByTagName("head")[0].appendChild(script);

                script.addEventListener("load", function(event) {
                    //onjqloaded(); // in fact, yourstuffscript() function
                    easyPack.init({
                        instance: 'pl',
                        context: "context name",
                        token: "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJkVzROZW9TeXk0OHpCOHg4emdZX2t5dFNiWHY3blZ0eFVGVFpzWV9TUFA4In0.eyJleHAiOjE5NzUyMzM0MTcsImlhdCI6MTY1OTg3MzQxNywianRpIjoiOGJmZDYyZDUtMzQzMS00NWJkLWI5NDAtNjM0NGFiMGI0YjZhIiwiaXNzIjoiaHR0cHM6Ly9zYW5kYm94LWxvZ2luLmlucG9zdC5wbC9hdXRoL3JlYWxtcy9leHRlcm5hbCIsInN1YiI6ImY6N2ZiZjQxYmEtYTEzZC00MGQzLTk1ZjYtOThhMmIxYmFlNjdiOmRhcmVrQHdkb3oucGwiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJzaGlweCIsInNlc3Npb25fc3RhdGUiOiJmNjE4OWY2MC0zYTI4LTQ4MDAtYWRhNy03NGU0ZjUwOTdjNjUiLCJhY3IiOiIxIiwic2NvcGUiOiJvcGVuaWQgYXBpOmFwaXBvaW50cyIsImFsbG93ZWRfcmVmZXJyZXJzIjoiZXNrbGVwLndkb3oucGwsd2Rvei5wbCIsInV1aWQiOiIyNTc0NmU0OC01NzRjLTQxMzEtYjhhNS0wODIzNjViNWJiOTIifQ.MoHPSAZ75d2-K_2FxwY-Kbgju0zVOBFPPjMxf9sAbv-CuuDrwDAlP753owFnMwu73387Pp9TF4rLxQepImRbp2FgkuyaS2SYelbpIUdB_XgXqLRJ5_WCKKtN3raDBqrAvgKRMKKbnugJSZuNAEI2qiivzU4XII8c9mzvMUKwG2ixPPhiK5CfhKDlNDBAAfv-Fl4J9jxpmAUvCSg9OK4ofMLc_ETIDpuGsUP8PBBfKmuU6gf6mDL8EFvXhGrvmXf_LXyBdIwKUPRn-AMQ7KC6gkph7EQKwTdlKZoqwuhDOZimnYr6tY0HcP51_6VWmgI2Ub0XqvK-P0-P13duvZ2tYA"
                    });
                    let map = easyPack.mapWidget('easypack-map', function(point) {
                        let selectedPointDisplay = "wybrany punkt:<br>" + point.name + " " + point.location_description + "<br>" + point.address.line1+ "<br>" + point.address.line2;
                        let selectedPoint = "wybrany punkt: " + point.name + " " + point.location_description + ", " + point.address.line1+ " " + point.address.line2;
                        document.getElementById("selected-paczkomat-visible").innerHTML = selectedPointDisplay;
                        document.getElementById("selected-paczkomat-visible").classList.remove('hidden');
                        document.getElementById("selected-paczkomat").value = selectedPoint; 
                        scrollTo("selected-paczkomat-visible");
                        hideGlobalLoader();
                    }); 
                    hideGlobalLoader();
                });
            } else {
                hideGlobalLoader();
            //    document.querySelector('.delivery[show-inpost-widget="1"]').classList.remove("delivery-method-container-map-active");
            //    document.getElementById("easypack-map-container").classList.remove("easypack-map-container-visible");
            }
    }
    
    function showOrlenWidget(input){ //inicjalizacja orlen paczki
        
            let isOrlenLoaded = input.getAttribute('data-orlen-loaded');
            if (isOrlenLoaded != '1'){
                showGlobalLoader();
                input.setAttribute('data-orlen-loaded','1');

                let head  = document.getElementsByTagName('head')[0];
                let link  = document.createElement('link');
                link.rel  = 'stylesheet';
                link.type = 'text/css';
                link.href = 'https://ruch-osm.sysadvisors.pl/widget.css';
                head.appendChild(link);
                
                var script2 = document.createElement('script');
                script2.src = '/js/jquery.min.js';
                document.body.appendChild(script2);
                script2.addEventListener("load", function(){
                    var script = document.createElement('script');
                    script.src = 'https://ruch-osm.sysadvisors.pl/widget.js?i=12';
                    document.body.appendChild(script);
                    script.addEventListener("load", function(){
                        let wid;
                        function button_init() {
                                wid = new RuchWidget('widget-orlen-html',	// Nazwa div, gdzie będzie wyświetlany widget
                                    {
                                        loadCb: on_load,				// Wywoływany po załadowaniu mapy
                                        readyCb: on_ready,				// Wywoływany, gdy widget jest gotowy do wyświetlenia
                                        selectCb: on_select,			// Wywoływany po wybraniu punktu
                                        initialAddress: document.getElementById('start').value,	// Centrum mapy na start - id punktu albo adres
                                        sandbox: 0,						// 1 jeśli widget ma pobierać dane testowe zamiast produkcyjnych
                                        showCodFilter: 0,
                                        showPointTypeFilter: 0
                                    }
                                );
                                wid.init();
                        }

                        function button_show() {
                            wid.showWidget(
                                parseInt(0),	// Cod czy nie document.getElementById('cod').value
                                {					// Lista cen dla typów
                                    'R': 10 + document.getElementById('cod').value*2,
                                    'P': 11 + document.getElementById('cod').value*2,
                                    'U': 11 + document.getElementById('cod').value*2,
                                    'A': 11 + document.getElementById('cod').value*2
                                },
                                {					// Lista metod dla typów
                                    'R': 'ruch_' + document.getElementById('cod').value,
                                    'P': 'partner_' + document.getElementById('cod').value,
                                    'U': 'partner_' + document.getElementById('cod').value,
                                    'A': 'orlen_' + document.getElementById('cod').value
                                }
                            );
                            wid.setPointType(document.getElementById('type').value);
                        }

                        function on_load() {
                                //document.getElementById('selected-orlen-point-visible').innerHTML = 'LOAD');
                                /*document.getElementById('but_s').show();
                                document.getElementById('but_h').show();
                                document.getElementById('but_i').hide();
                                document.getElementById('start_adr').hide();*/
                        }

                        function on_ready() {
                                //document.getElementById('selected-orlen-point-visible').innerHTML = 'READY');
                                wid.showWidget(
                                parseInt(0),	// Cod czy nie document.getElementById('cod').value
                                {					// Lista cen dla typów
                                    'R': 10+document.getElementById('cod').value*2,
                                    'P': 11+document.getElementById('cod').value*2,
                                    'U': 11+document.getElementById('cod').value*2,
                                    'A': 11+document.getElementById('cod').value*2
                                },
                                {					// Lista metod dla typów
                                    'R': 'ruch_' + document.getElementById('cod').value,
                                    'P': 'partner_' + document.getElementById('cod').value,
                                    'U': 'partner_' + document.getElementById('cod').value,
                                    'A': 'orlen_' + document.getElementById('cod').value,
                                }
                            );
                            wid.setPointType(document.getElementById('type').value);
                            document.getElementById('widget-orlen-html').querySelector('.searchBar__location').click();
                            hideGlobalLoader();
                        }

                        function on_select(p) {
                                if(p == null) {
                                    document.getElementById('selected-orlen-point-visible').innerHTML = '';
                                    document.getElementById('selected-orlen').value = '';
                                    document.getElementById('selected-orlen-point-visible').classList.add('hidden');
                                } else {
                                    document.getElementById('selected-orlen-point-visible').innerHTML = 'wybrano: ' + p.a + '  ID: ' + p.id ;
                                    document.getElementById('selected-orlen').value = 'wybrano: ' + p.a + '  ID: ' + p.id;
                                    document.getElementById('selected-orlen-point-visible').classList.remove('hidden');
                                }
                        }

                        button_init();

                        /*document.querySelector('.delivery[show-orlen-widget="1"]').classList.add("delivery-method-container-map-active");
                        document.getElementById("widget_orlen_html").classList.add("easypack-map-container-visible");
                        document.getElementById("selected-orlen-point-visible").classList.add("selected-visible");*/

                    });
                });
            } else {
                hideGlobalLoader();
                /*document.querySelector('.delivery[show-orlen-widget="1"]').classList.add("delivery-method-container-map-active");
                document.getElementById("widget_orlen_html").classList.add("easypack-map-container-visible");
                document.getElementById("selected-orlen-point-visible").classList.add("selected-visible");*/
            }

    }
    
    function showHideInvoideContainer(){
        let checbox = document.getElementById('need-invoice-checkbox');
        if (checbox.checked){
            document.getElementById('invoice-data-container').classList.remove("hidden");
        } else {
            document.getElementById('invoice-data-container').classList.add("hidden");
        }
    }
    
    function changeInvoiceType(){
        if (document.getElementById('invoice-type-select').value == "person"){
            document.getElementById('invoice-company-name-container').classList.add("hidden");
            document.getElementById('invoice-company-vat-number-container').classList.add("hidden");
        } else {
            document.getElementById('invoice-company-name-container').classList.remove("hidden");
            document.getElementById('invoice-company-vat-number-container').classList.remove("hidden");
        }
    } 
</script>