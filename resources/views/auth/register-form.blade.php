<div class="rounded-b-lg drop-shadow-lg p-5 bg-white flex  w-full gap-3 flex-col">
    <div class="flex flex-col gap-3"> 
        <h3>Załóż konto</h3>
        <button id="show-register-areas" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base  ">Załóż konto</button>
        <div id="register-form-sucess" class="m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 hidden text-center max-w-[350px] p-2">
            Udało się poprawnie zarejestrować konto klienta. Sprawdź adres e-mail, podany podczas rejestracji, aby aktywować konto.  
        </div>
        <div id="register-areas" class="flex flex-col gap-3 hidden h-0 transition-all duration-500 ease-in-out">
            <div id="register-form-errors" class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 hidden ml-3 mr-5 md:ml-0 md:mr-0" id="login-form-errors">
                <ul id="register-form-errors-points" class="text-red-700 p-3 pl-5 pr-5 text-sm">
                </ul>
            </div>
            <div class="relative">
                <input type="text" autocomplete="off" id="checkout-register-email" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 field-error-info hidden field-error-info">Błąd</span>
                <label for="checkout-login-email" class="pointer-events-none absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1"><span class="text-xl text-red-600">*</span> Adres e-mail</label>
            </div>
            <div class="relative">
                <input type="password" autocomplete="off" id="checkout-register-password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 field-error-info hidden field-error-info">Błąd</span>
                <label for="checkout-login-password" class="pointer-events-none absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1"><span class="text-xl text-red-600">*</span> Hasło</label>
            </div>
            <div class="relative">
                <input type="password" autocomplete="off" id="checkout-register-password-repeat" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded border-1 border border-wdoz-input-border appearance-none focus:outline-none focus:ring-0 peer" placeholder=" " />
                <span class="text-red-700 block text-xs pt-1 field-error-info hidden field-error-info">Błąd</span>
                <label for="checkout-login-password" class="pointer-events-none absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1"><span class="text-xl text-red-600">*</span> Powtórz hasło</label>
            </div>
            <div class="inline-flex items-start py-4 w-full">
                <label class="flex items-center cursor-pointer relative" for="accept-rules1">
                  <input type="checkbox" autocomplete="off" id="register-accept-rules1" class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary">
                  <span class="pointer-events-none absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                  </span>
                </label>
                <label class="cursor-pointer ml-2 text-slate-600 text-xs" for="accept-rules1">
                  <span class="text-xl text-red-600">*</span>
                  Oświadczam, że zapoznałem się z obowiązującym w Aptece Internetowej <a style="color:#38900D" target="blank" href="https://<?=Config::get('constants.shop_domain')?>/podstrona/regulamin/">Regulaminem</a>.
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                </label>
            </div>

            <div class="inline-flex items-start py-4 w-full">
                <label class="flex items-center cursor-pointer relative" for="accept-rules1">
                  <input type="checkbox" autocomplete="off" id="register-accept-rules2" class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary">
                  <span class="pointer-events-none absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                  </span>
                </label>
                <label class="cursor-pointer ml-2 text-slate-600 text-xs" for="accept-rules1">
                  <span class="text-xl text-red-600">*</span>
                  Oświadczam, że zapoznałem się z obowiązującą w Aptece Internetowej <a style="color:#38900D" target="blank" href="https://<?=Config::get('constants.shop_domain')?>/podstrona/polityka-prywatnosci/">Polityką Prywatności</a> i mechanizmem cookies.
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                </label>
            </div>

            <div class="inline-flex items-start py-4 w-full">
                <label class="flex items-center cursor-pointer relative" for="accept-rules1">
                  <input type="checkbox" autocomplete="off" id="register-accept-rules3" class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-wdoz-primary checked:border-wdoz-primary">
                  <span class="pointer-events-none absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" stroke="currentColor" stroke-width="1">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                  </span>
                </label>
                <label class="cursor-pointer ml-2 text-slate-600 text-xs" for="accept-rules1">
                    Wyrażam zgodę na otrzymywanie newslettera i informacji handlowych od Apteki Internetowej Wracam do zdrowia, www.wdoz.pl. Jestem świadom przysługującego mi prawa do cofnięcia wyrażonej zgody w każdym czasie. Wówczas przekazane dane będą przetwarzane do momentu cofnięcia zgody. Administratorem danych osobowych jest „Wracam do zdrowia 8” sp. z o.o., adres: ul. Remusa 6, 81-574 Gdynia. Administrator przetwarza dane zgodnie z obowiązującym prawem oraz <a style="color:#38900D" target="blank" href="https://<?=Config::get('constants.shop_domain')?>/podstrona/regulamin-newslettera-apteki-internetowej/">Regulaminem Newslettera</a>.
                  <span class="text-red-700 block text-xs pt-1 hidden field-error-info">Błąd</span>
                </label>
            </div>
            <button id="checkout-register-button" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base  ">Załóz konto</button>
        </div>    

    </div>
</div>

<script>
document.getElementById('show-register-areas').addEventListener("click", (event) => {
    let registerAreas = document.getElementById('register-areas');
    registerAreas.classList.remove('hidden');
    registerAreas.classList.remove('h-0');
    document.getElementById('show-register-areas').classList.add('hidden');
});

document.getElementById('checkout-register-button').addEventListener("click", (event) => {
    confirmRegister();
});

function confirmRegister(){
    showGlobalLoader();
    let acceptRules = 0;
    if (document.getElementById('register-accept-rules1').checked){
        acceptRules = 1;
    }
    let acceptCookies = 0;
    if (document.getElementById('register-accept-rules2').checked){
        acceptCookies = 1;
    }
    let acceptNewsletter = 0;
    if (document.getElementById('register-accept-rules3').checked){
        acceptNewsletter = 1;
    }

    fetch('/register-new-user', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            email: document.getElementById('checkout-register-email').value,
            password: document.getElementById('checkout-register-password').value,
            passwordRepeat: document.getElementById('checkout-register-password-repeat').value,
            acceptRules: acceptRules,
            acceptCookies: acceptCookies,
            acceptNewsletter: acceptNewsletter,
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
            
            let errorsDescriptionContainer = document.getElementById('register-form-errors');
            let errosPoints = document.getElementById('register-form-errors-points');
            
            
            let errorInfoFields = document.getElementById('register-areas').querySelectorAll('.field-error-info');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.add('hidden');
            }
            
            errorInfoFields = document.getElementById('register-areas').querySelectorAll('.area-validation-error');
            for(let i=0; i<errorInfoFields.length; i++){
                errorInfoFields[i].classList.remove('area-validation-error');
            }
            if (jsonResponse.status){
                errorsDescriptionContainer.classList.add('hidden');
                errosPoints.innerHTML = '';
                
                if (typeof setUserData != 'undefined'){
                    setUserData(jsonResponse.userId);
                
                    goToDataStep();
                } else {
                    document.getElementById('register-form-sucess').classList.remove('hidden');
                     document.getElementById('register-areas').classList.add('hidden');
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
</script>