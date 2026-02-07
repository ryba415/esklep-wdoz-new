@extends('layouts.admin')

@section('content')
<div id="top-page-id" ></div>
<div class="settings-form">
        
        <h1>Ustawienia</h1>
        <div class="pro-acount-info">
        </div>
        <div class="all-data-form invoice-cintainer">
            
            <div id="form-erros" class="d-none form-erros"></div>
            <div id="form-sucess" class="d-none form-sucess">Dane zostały zapisane poprawnie</div>
            @csrf
            <div class="customer-data-container">
                <p class="form-title">Dane użytkownika</p>
                <label class="text-label"><span class="red-star">*</span> Adres e-mail :</label>
                <input type="text" name="user_email" value="{{ $user->email }}" disabled="disabled" autocomplete="off">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Imię:</label>
                <input type="text" name="user_name"  value="{{ $user->name }}" autocomplete="off">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Nazwisko:</label>
                <input type="text" name="user_surname"   value="{{ $user->surname }}" autocomplete="off">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Ulica:</label>
                <input type="text" name="user_street" value="{{ $user->street  }}"  autocomplete="off">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Kod pocztowy:</label>
                <input type="text" name="user_postcode" value="{{ $user->postcode }}"  autocomplete="off">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Miasto:</label>
                <input type="text" name="user_city" value="{{ $user->city }}"  autocomplete="off">
            </div>

            <div id="invoice-cintainer" class="invoice-cintainer">
                <p class="invoice-title">Dane do faktury</p>
                <br>
                <label class="text-label">Nazwa firmy:</label>
                <input type="text" name="invoice_comapny" value="{{ $user->invoice_comapny }}" autocomplete="off"> 
                <br><br>
                <label class="text-label">Ulica:</label>
                <input type="text" name="invoice_street" value="{{ $user->invoice_street  }}" autocomplete="off">
                <br><br>
                <label class="text-label">Kod pocztowy:</label>
                <input type="text" name="invoice_postcode" value="{{ $user->invoice_postcode }}" autocomplete="off">
                <br><br>
                <label class="text-label">Miasto:</label>
                <input type="text" name="invoice_city" value="{{ $user->invoice_city }}" autocomplete="off">
                <br><br>
                <label class="text-label">NIP:</label>
                <input type="text" name="invoice_nip" value="{{ $user->invoice_nip }}" autocomplete="off">
                <br><br>
            </div>

            <div class="buy-buton-container">
                <button class="standard-button standard-big-button-orange" id="sumbit-and-buy">Zapisz dane</button>
            </div>
            
            <div id="top-page-id1" ></div>
            <div class="new-pass-container">
                <p class="invoice-title">Zmiana hasła</p>
                <br>
                <div id="form-erros1" class="d-none form-erros"></div>
                <div id="form-sucess1" class="d-none form-sucess">Hasło zostało zmienione poprawnie</div>
                <label class="text-label"><span class="red-star">*</span> Nowe hasło:</label>
                <input type="password" name="new-passwored" value="" autocomplete="off"> 
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Powtórz nowe hasło:</label>
                <input type="password" name="new-passwored-repeat" value="" autocomplete="off"> 
                <br><br>
            </div>
            
            <div class="buy-buton-container">
                <button class="standard-button standard-big-button-orange" id="change-password">Zmień hasło</button>
            </div>
        </div>

</div>

<script>

        let sumbitButton = document.getElementById('sumbit-and-buy');
        sumbitButton.addEventListener("click", function(e){
            e.preventDefault();
            let formData = {
                user_name : document.querySelector('[name="user_name"]').value,
                user_surname : document.querySelector('[name="user_surname"]').value, 
                user_street : document.querySelector('[name="user_street"]').value, 
                user_postcode : document.querySelector('[name="user_postcode"]').value, 
                user_city : document.querySelector('[name="user_city"]').value, 
                invoice_comapny : document.querySelector('[name="invoice_comapny"]').value,
                invoice_street : document.querySelector('[name="invoice_street"]').value,
                invoice_postcode : document.querySelector('[name="invoice_postcode"]').value,
                invoice_city : document.querySelector('[name="invoice_city"]').value,
                invoice_nip : document.querySelector('[name="invoice_nip"]').value,
            };

            const Http = new XMLHttpRequest();
            let params = '?_token=' + document.querySelector('[name="_token"]').value + '&data=' +  JSON.stringify(formData);
            const url='/save-user-data-sumbit' + params;
            Http.open("POST", url);
            Http.send(params);

            Http.onreadystatechange = (e) => {
                if (Http.status == 200){
                    if(Http.readyState == 4) {
                        let response = JSON.parse(Http.responseText);
                        
                        let formErrors = document.getElementById('form-erros');
                        let formSucess = document.getElementById('form-sucess');
                        formErrors.innerHTML = 'Wystąpiły błędy w formularzu: ';
                        if (response.status){
                            formErrors.classList.add('d-none');
                            formSucess.classList.remove('d-none');
                            
                        } else {
                            formErrors.classList.remove('d-none');
                            formSucess.classList.add('d-none');
                            let error; 
                            for (let i=0; i<response.errors.length; i++){
                                error = document.createElement("div");
                                error.classList.add('error-item');
                                error.innerHTML = response.errors[i];
                                formErrors.appendChild(error);
                            }
                            
                        }
                        document.querySelector('#top-page-id').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
              
            }
        });
        
        
        let sumbitButton1 = document.getElementById('change-password');
        sumbitButton1.addEventListener("click", function(e){
            e.preventDefault();
            let formData = {
                new_passwored : document.querySelector('[name="new-passwored"]').value,
                new_passwored_repeat : document.querySelector('[name="new-passwored-repeat"]').value, 
            };

            const Http = new XMLHttpRequest();
            let params = '?_token=' + document.querySelector('[name="_token"]').value + '&data=' +  JSON.stringify(formData);
            const url='/update-password' + params;
            Http.open("POST", url);
            Http.send(params);

            Http.onreadystatechange = (e) => {
                if (Http.status == 200){
                    if(Http.readyState == 4) {
                        let response = JSON.parse(Http.responseText);
                        
                        let formErrors = document.getElementById('form-erros1');
                        let formSucess = document.getElementById('form-sucess1');
                        formErrors.innerHTML = 'Wystąpiły błędy w formularzu: ';
                        if (response.status){
                            formErrors.classList.add('d-none');
                            formSucess.classList.remove('d-none');
                            
                        } else {
                            formErrors.classList.remove('d-none');
                            formSucess.classList.add('d-none');
                            let error; 
                            for (let i=0; i<response.errors.length; i++){
                                error = document.createElement("div");
                                error.classList.add('error-item');
                                error.innerHTML = response.errors[i];
                                formErrors.appendChild(error);
                            }
                            
                        }
                        document.querySelector('#top-page-id1').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
              
            }
        });
</script>    
@endsection