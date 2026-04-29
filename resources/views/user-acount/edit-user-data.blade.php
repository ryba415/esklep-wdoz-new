<div class="flex flex-wrap justify-center pb-[50px] xl:mt-10">
    
    <div class="" id="user-data-container">
        <h1 class="flex w-[100%] text-center justify-center mb-5 text-lg">Dane użytkownika</h1>
        <div class="w-[100%]">
            <div class="m-auto bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 hidden max-w-[350px]" id="user-data-form-errors">
                <ul id="user-data-form-errors-points" class="text-red-700 p-3 pl-5 pr-5 text-sm">
                </ul>
            </div>
            <div class="m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 hidden text-center max-w-[350px] p-2" id="user-data-form-suces">
                Dane zostały poprawnie zapisane.
            </div>
        </div>
        <div class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5"> 
            <h2 class="w-full">Moje dane</h2>
            <div class="relative w-full sm:w-[48%]">
                <input type="text" id="user-data-form-name" value="{{$userdata['userData']['first_name']}}" autocomplete="off" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="user-data-form-name" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Imię</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="user-data-form-surname" value="{{$userdata['userData']['last_name']}}" autocomplete="off" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="user-data-form-surname" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nazwisko</label>
            </div>

            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="user-data-form-email" value="{{$userdata['userData']['email']}}" readonly autocomplete="off" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="user-data-form-email" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Adres e-mail</label>
            </div>
            <div class="relative w-full sm:w-[48%]" >
                <input type="text" id="user-data-form-phone" value="{{$userdata['deliveryAdress']->phoneNumber}}" autocomplete="off" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                <label for="user-data-form-phone" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Telefon</label>
            </div>
        </div>
        <div class="w-[100%]"></div>


        <div class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white flex flex-wrap flex-row gap-5"> 
            <h2 class="w-full">Adres dostwy</h2>

            <div id="delivery-data-container" class="max-w-[714px] p-0 mb-5 bg-white flex flex-wrap flex-row gap-5 ">
                <div class="relative w-full sm:w-[48%]" >
                  <input type="text" id="user-data-form-street" value="{{$userdata['deliveryAdress']->street}}" autocomplete="off" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                  <label for="user-data-form-street" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Ulica</label>
                </div>
                <div class="relative w-full sm:w-[48%]" >
                  <input type="text" id="user-data-form-house-number" value="{{$userdata['deliveryAdress']->house_number}}" autocomplete="off" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                  <label for="user-data-form-house-number" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nr domu / mieszkania</label>
                </div>
                <div class="relative w-full sm:w-[48%]" >
                  <input type="text" id="user-data-form-city"  value="{{$userdata['deliveryAdress']->city}}" autocomplete="off" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                  <label for="user-data-form-city" value="{{$userdata['deliveryAdress']->city}}" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Miejscowość</label>
                </div>
                <div class="relative w-full sm:w-[48%]" >
                  <input type="text" id="user-data-form-zipcode"  value="{{$userdata['deliveryAdress']->zipCode}}" autocomplete="off" class="vat block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                  <label for="user-data-form-zipcode"  value="{{$userdata['deliveryAdress']->zipCode}}" class="absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Kod pocztowy</label>
                </div>
            </div>
        </div>

        <div class="flex w-[100%] flex-wrap justify-center fixed bottom-[0px] md:relative p-2 bg-white">
            <button id="save-user-data" class="w-[200px] bg-wdoz-primary text-white mt-4 rounded p-4 shadow text-sm font-semibold" >Zapisz</button>
        </div>
    
    </div>
    <div class="w-[100%]"></div>
    
    <div id="orders-container" class="max-w-[100%] overflow-auto hidden">
        @if (count($allOrders) == 0)
        <p class="pt-5 pb-5 text-lg">Brak zamówień</p>
        @endif
        <table>
        @foreach ($allOrders as $order)
        <tr><td colspan="6" class="p-6"></td></tr>  
        <tr>
            <td colspan="6" class="p-2 pb-0">
                <span class="text-[rgba(61,61,61,1)] text-sm">zamówienie numer:</span> <span class="font-semibold">{{$order->name}}</span>
            </td>
        </tr>
        <tr class="border-t-4 border-wdoz-primary ">
            <td class="p-2"><span class="text-[rgba(61,61,61,1)] text-sm">data:</span><br> <span class="font-semibold">{{$order->order_date}}</span></td>
            <td class="p-2"><span class="text-[rgba(61,61,61,1)] text-sm">status płatności:</span><br> <span class="font-semibold " @if($order->paynow_payment_status == 'CONFIRMED') style="color: green;"@endif >{{$globalHelper->mapPaymentStatus($order->paynow_payment_status)}}</span></td>
            <td class="p-2"><span class="text-[rgba(61,61,61,1)] text-sm">status zamówienia:</span><br> <span class="font-semibold">{{$globalHelper->mapOrderStatus($order->status)}}</span></td>
            <td class="p-2"><span class="text-[rgba(61,61,61,1)] text-sm">wartość:</span><br> <span class="font-semibold">{{$order->value_gross}} zł</span></td>
            <td class="p-2"></td>
            <td class="p-2"></td>
        </tr>
        <tr>
            <td colspan="6" class="p-2"><span class="text-[rgba(61,61,61,1)] text-sm">adres dostawy:</span> 
                <span class="font-semibold">{{$order->delivery_street}} {{$order->delivery_house_number}}, {{$order->delivery_city}}{{$order->delivery_zip_code}}
                @if ($order->paczkomat_details != '' && $order->paczkomat_details != null)
                , paczkomat {{$order->paczkomat_details}}
                @endif
                </span></td>
        </tr>
        <tr>
            <td colspan="6" class="p-2 border-b"><span class="text-[rgba(61,61,61,1)] text-sm">produkty:</span></td>
        </tr>
            @foreach ($order->positions as $position)
            <tr class="border-b">
                <td class="p-2">
                    <a href="/{{$position->slug}}">
                    <img class="w-[70px]" src="{{Config::get('constants.admin-panel-url')}}uploads/images/product/{{$position->image_name}}" alt="{{$position->name}}">
                    </a>
                </td>
                <td class="p-2" colspan="2">
                    <a href="/{{$position->slug}}">
                        {{$position->name}}<br>
                        <span class="text-[rgba(61,61,61,1)] text-sm">{{$position->brand}}@if(!empty($position->content)), {{$position->content}}@endif</span>
                    </a>
                </td>
                <td class="p-2">{{$position->value_gross}} zł</td>
                <td class="p-2">{{$position->quantity}} szt.</td>
                <td class="p-2">{{$position->value_gross/$position->quantity}} zł/szt.</td>
            </tr>
            @endforeach
            <tr >
                <td colspan="2" class="p-2"></td>
                <td class="p-2 text-right border-b"><span class="text-[rgba(61,61,61,1)] text-sm">Koszt dostawy:</span></td>
                <td class="p-2 border-b">{{$order->delivery_cost}} zł</td>
                <td class="p-2 border-b"></td>
                <td class="p-2 border-b"></td>
            </tr>
            
            
        <tr><td colspan="6" class="p-6 drop-shadow-lg"></td></tr>  
        @endforeach
        </table>
    </div>
    
</div>  

<script>
    document.getElementById('save-user-data').addEventListener("click", (event) => {
        saveUserData();
    });
    
    function saveUserData(buyNow = false){
        showGlobalLoader();
        let formdata = {};
        
        formdata['buyNow'] = buyNow;
        formdata['user-data-name'] = document.getElementById('user-data-form-name').value;
        formdata['user-data-surname'] = document.getElementById('user-data-form-surname').value;
        //formdata['user-data-email'] = document.getElementById('user-data-form-email').value;
        formdata['user-data-phone'] = document.getElementById('user-data-form-phone').value;

        formdata['user-data-street'] = document.getElementById('user-data-form-street').value;
        formdata['user-data-house-number'] = document.getElementById('user-data-form-house-number').value;
        formdata['user-data-city'] = document.getElementById('user-data-form-city').value;
        formdata['user-data-zipcode'] = document.getElementById('user-data-form-zipcode').value;
        
        fetch('/user-acount/save-user-data', { // buy-now  validate-delivery-data
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

            let errorsDescriptionContainer = document.getElementById('user-data-form-errors');
            let errosPoints = document.getElementById('user-data-form-errors-points');
            
            let errorInfoFields = document.querySelectorAll('.field-error-info');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.add('hidden');
            }
            
            errorInfoFields = document.querySelectorAll('.area-validation-error');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.remove('area-validation-error');
            }
            if (jsonResponse.status){
                console.log('sucess!')
                
                
                errorsDescriptionContainer.classList.add('hidden');
                errosPoints.innerHTML = '';

                document.getElementById('user-data-form-suces').classList.remove('hidden');
                
                window.scrollTo({top: 0, behavior: 'smooth'});
                
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
</script>