<div id="login-step" class="max-w-[1120px] flex flex-col mx-auto opacity-0 h-0 hidden w-[100%]">
    
    
    @if($isLoggedUser)
    <div class="flex flex-col md:flex-row w-full gap-5 items-center justify-center">
        
        <div class="left flex flex-col  rounded-b-md drop-shadow-lg p-5 mb-5 bg-white gap-4" style="max-width: 426px; width: 100%;">
            <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 hidden ml-3 mr-5 md:ml-0 md:mr-0" id="login-form-errors">
                <ul id="login-form-errors-points" class="text-red-700 p-3 pl-5 pr-5 text-sm">
                </ul>
            </div>
            <div class="text-center">
                <p class="m-4">Jesteś zlogowany jako: <span class="font-semibold">{{$userdata["first_name"]}} {{$userdata["last_name"]}}</span></p>
                <button id="checkout-go-to-delivery" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base w-[100%] ">Kontynuuj</button>
                <p class="m-4">lub</p>
                <button id="checkout-logout" class="mb-4">Zmień użytkownika</button> 
            </div>
        </div>
    </div>
    @endif
    
    <div class="flex flex-col md:flex-row w-full gap-5 items-center justify-center flex-wrap @if($isLoggedUser) hidden @endif">
        
        
        @include('auth/login-form')

        <div class="right rounded-b-lg drop-shadow-lg flex  w-full gap-9 flex-col md:self-start " style="max-width: 426px; height: 100%;   ">
            
            @include('auth/register-form')
            

            <div class="rounded-b-lg drop-shadow-lg p-5 bg-white flex  w-full gap-3 flex-col">
                <div class="flex flex-col gap-3"> 
                    <h3>zakupy bez zakładania konta</h3>
                    <button id="buy-as-guest-button" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base  ">Kup jako gość</button>
                </div>
            </div>
        </div>
        
        <div class="w-[100%] flex justify-center">
            <div class="flex justify-center sm:justify-start w-[100%] pt-5" style="max-width: 875px;">
            <a href="/koszyk" class=" text-black mt-4 rounded p-3 shadow text-base mt-5 lg:inline-block">Wróć do koszyka</a>
            </div>
        </div>
        

    </div>
</div>

<script>
    
document.getElementById('buy-as-guest-button').addEventListener("click", (event) => {
    goToDataStep();
});

if (document.getElementById('checkout-go-to-delivery') != null){
    document.getElementById('checkout-go-to-delivery').addEventListener("click", (event) => {
        goToDataStep();
    });
}


document.getElementById('checkout-login-button').addEventListener("click", (event) => {
    checkoutLogin();
});






if (document.getElementById('checkout-logout') != null){
    document.getElementById('checkout-logout').addEventListener("click", (event) => {
        checkoutLogout();
    });
}

document.addEventListener("DOMContentLoaded", (event) => {
    let userId =  document.getElementById('current-user').getAttribute('content');
    if (userId != '' && userId != null){
        setUserData(userId);
    }
});



function checkoutLogout(){
    showGlobalLoader();
    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'logout'
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
        document.getElementById('buy-form-name').value = '';
        document.getElementById('buy-form-surname').value = '';
        document.getElementById('buy-form-email').value = '';
        document.getElementById('buy-form-phone').value = '';
        document.getElementById('buy-form-company').value = '';
        document.getElementById('buy-form-nip').value = '';
        document.getElementById('buy-form-invoice-street').value = '';
        document.getElementById('buy-form-invoice-house-number').value = '';
        document.getElementById('buy-form-invoice-city').value = '';
        document.getElementById('buy-form-invoice-zipcode').value = '';
        document.getElementById('buy-form-street').value = '';
        document.getElementById('buy-form-chouse-number').value = '';
        document.getElementById('buy-form-city').value = '';
        document.getElementById('buy-form-zipcode').value = '';
        setTimeout(() => {
            window.location.replace("/koszyk?go-to-step=2");
        }, "100");
    });
}


function checkoutLogin(){
    showGlobalLoader();
    fetch('/checkout-login', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            email: document.getElementById('checkout-login-email').value,
            password: document.getElementById('checkout-login-password').value
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
            
            let errorsDescriptionContainer = document.getElementById('login-form-errors');
            let errosPoints = document.getElementById('login-form-errors-points');
            
            
            let errorInfoFields = document.getElementById('login-step').querySelectorAll('.field-error-info');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.add('hidden');
            }
            
            errorInfoFields = document.getElementById('login-step').querySelectorAll('.area-validation-error');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.remove('area-validation-error');
            }
            if (jsonResponse.status){
                errorsDescriptionContainer.classList.add('hidden');
                errosPoints.innerHTML = '';
                
                setUserData(jsonResponse.userId);
                
                goToDataStep();
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

function setUserData(id){
    fetch('/get-user-data/'+id, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            email: document.getElementById('checkout-login-email').value,
            password: document.getElementById('checkout-login-password').value
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
        
        document.getElementById('buy-form-name').value = jsonResponse.userData.first_name;
        document.getElementById('buy-form-surname').value = jsonResponse.userData.last_name;
        document.getElementById('buy-form-email').value = jsonResponse.userData.email;
        //
        //document.getElementById('buy-form-company').value = jsonResponse.userData.;
        //document.getElementById('buy-form-nip').value = '';
        //document.getElementById('buy-form-invoice-street').value = jsonResponse.userData.;
        //document.getElementById('buy-form-invoice-house-number').value = jsonResponse.userData.;
        //document.getElementById('buy-form-invoice-city').value = jsonResponse.userData.;
        //document.getElementById('buy-form-invoice-zipcode').value = jsonResponse.userData.;
        if (jsonResponse.deliveryAdressFinded){
            if (jsonResponse.deliveryAdress.firstName != '' && jsonResponse.deliveryAdress.firstName != null){
                document.getElementById('buy-form-name').value = jsonResponse.deliveryAdress.firstName;
            }
            if (jsonResponse.deliveryAdress.lastName != '' && jsonResponse.deliveryAdress.lastName != null){
                document.getElementById('buy-form-surname').value = jsonResponse.deliveryAdress.lastName;
            }
            document.getElementById('buy-form-phone').value = jsonResponse.deliveryAdress.phoneNumber;
            document.getElementById('buy-form-street').value = jsonResponse.deliveryAdress.street;
            document.getElementById('buy-form-chouse-number').value = jsonResponse.deliveryAdress.house_number;
            document.getElementById('buy-form-city').value = jsonResponse.deliveryAdress.city;
            document.getElementById('buy-form-zipcode').value = jsonResponse.deliveryAdress.zipCode;
        }
        
        //nadpisanie danych z local storage
        dataInLocalStorage(false);
        
    });
}


</script>