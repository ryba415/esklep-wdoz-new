@extends('layouts.front')

@section('content')

@include('loader')

<input type="hidden" id="single-login-type" value="1">

<div class="login-container">
    <div class="flex flex-col md:flex-row w-full gap-5 items-center justify-center pt-10 pb-8">
        @if ($resetEnabled)
        <div id="login-form" class="left flex flex-col  rounded-b-md drop-shadow-lg p-5 mb-5 bg-white gap-4" style="max-width: 426px; width: 100%;">
        <h3>Podaj nowe hasło</h3>
        
            <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 hidden ml-3 mr-5 md:ml-0 md:mr-0" id="login-form-errors">
                <ul id="login-form-errors-points" class="text-red-700 p-3 pl-5 pr-5 text-sm">
                </ul>
            </div>
            <div id="login-form-sucess" class="hidden text-sm text-[#008641] w-[100%] m-auto bg-wdoz-primary-10 rounded-lg mb-5 border-solid border-wdoz-primary border-2 p-2">
                Hasło zostało zresetowane
            </div>
            <div id="reset-form">
                <input type="hidden" id="user-hash" value="{{$hash}}">
                <div class="relative">
                    <input type="password" id="new-password" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded-lg border-1 border-wdoz-input-border appearance-none  focus:outline-none focus:ring-0  peer" placeholder=" " style="border: solid 1px gray;"/>
                    <span class="text-red-700 block text-xs pt-1 field-error-info hidden">Błąd</span>
                    <label for="new-password" class="pointer-events-none absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Nowe hasło</label>
                </div>
                <div class="relative mt-3">
                    <input type="password" id="new-password-repeat" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded-lg border-1 border-wdoz-input-border appearance-none  focus:outline-none focus:ring-0  peer" placeholder=" " style="border: solid 1px gray;"/>
                    <span class="text-red-700 block text-xs pt-1 field-error-info hidden">Błąd</span>
                    <label for="new-password-repeat" class="pointer-events-none absolute text-sm text-gray-500  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[515151]  peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/4 peer-placeholder-shown:top-1/4 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">Powtórz nowe hasło</label>
                </div>
                <button id="reset-password-button" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base  ">Zresetuj hasło</button>
            </div>
        
        </div>
        @else
            <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 ml-3 mr-5 md:ml-0 md:mr-0" >
                <ul  class="text-red-700 p-3 pl-5 pr-5 text-sm">
                    <li>{{$resetErrorMessage}}</li>
                </ul>
            </div>
        @endif
    </div>
</div>



<script>
document.getElementById('reset-password-button').addEventListener("click", (event) => {

        showGlobalLoader();
        fetch('/set-client-password-confirm', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                newPassword: document.getElementById('new-password').value,
                newPasswordRepeat: document.getElementById('new-password-repeat').value,
                userHash: document.getElementById('user-hash').value,
            })
        }).then(response => {
            if(response.ok){
                return response.json();  
            }
            throw new Error('Request failed!');
            hideGlobalLoader();
        }, networkError => {
            hideGlobalLoader();
        }).then(jsonResponse => {

                let errorsDescriptionContainer = document.getElementById('login-form-errors');
                let errosPoints = document.getElementById('login-form-errors-points');


                let errorInfoFields = document.getElementById('login-form').querySelectorAll('.field-error-info');
                for(let i=0; i<errorInfoFields.length; i++){
                    errorInfoFields[i].classList.add('hidden');
                }

                errorInfoFields = document.getElementById('login-form').querySelectorAll('.area-validation-error');
                for(let i=0; i<errorInfoFields.length; i++){
                    errorInfoFields[i].classList.remove('area-validation-error');
                }
                if (jsonResponse.status){
                    errorsDescriptionContainer.classList.add('hidden');
                    errosPoints.innerHTML = '';
                    
                    document.getElementById('login-form-sucess').classList.remove('hidden');
                    document.getElementById('reset-form').classList.add('hidden');
                    document.getElementById('new-password').value = '';
                    document.getElementById('new-password-repeat').value = '';
                    //window.location.replace("/user-acount/dasboard");
                    
                } else {
                    document.getElementById('login-form-sucess').classList.add('hidden');
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



});
</script>
    
@endsection