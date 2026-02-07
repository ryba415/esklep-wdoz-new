@extends('user.layouts')

@section('content')

<div class="buy-now-form">
        <h1>Wypełnij formularz, żeby dokonać zakupu</h1>
        <div id="scroll-page-top"></div>
        @if($isSanbox)
        <p class="sandbox-info">Uwaga, system płatności jest w wersji sanbox!</p>
        @endif
        
        <div class="all-data-form">
            <div id="form-erros" class="d-none form-erros"></div>
            @csrf
            <div class="customer-data-container">
                <label class="text-label"><span class="red-star">*</span> Adres e-mail :</label>
                <input type="text" name="user_email" value="{{ $user->email }}" disabled="disabled">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Imię:</label>
                <input type="text" name="user_name"  value="{{ $user->name }}">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Nazwisko:</label>
                <input type="text" name="user_surname"   value="{{ $user->surname }}">
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Ulica:</label>
                <input type="text" name="user_street" value="{{ $user->street  }}" >
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Kod pocztowy:</label>
                <input type="text" name="user_postcode" value="{{ $user->postcode }}" >
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Miasto:</label>
                <input type="text" name="user_city" value="{{ $user->city }}" >
            </div>
            <input class="need-invoice-input" type="checkbox" name="need_invoice" id="need-invoice" autocomplete="off"> <label for="need-invoice">Chcę otrzymać fakturę VAT</label>
            
            <div id="invoice-cintainer" class="d-none invoice-cintainer">
                <p class="invoice-title">Dane do faktury</p>
                <br>
                <label class="text-label"><span class="red-star">*</span> Nazwa firmy:</label>
                <input type="text" name="invoice_comapny" value="{{ $user->invoice_comapny }}" > 
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Ulica:</label>
                <input type="text" name="invoice_street" value="{{ $user->invoice_street  }}" >
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Kod pocztowy:</label>
                <input type="text" name="invoice_postcode" value="{{ $user->invoice_postcode }}" >
                <br><br>
                <label class="text-label"><span class="red-star">*</span> Miasto:</label>
                <input type="text" name="invoice_city" value="{{ $user->invoice_city }}" >
                <br><br>
                <label class="text-label"><span class="red-star">*</span> NIP:</label>
                <input type="text" name="invoice_nip" value="{{ $user->invoice_nip }}" >
                <br><br>
            </div>

            <div class="rules-container">
            <input type="checkbox" name="accept_rules" autocomplete="off"> <label><span class="red-star">*</span> Akceptuję <a href="/regulamin" target="blank">regulamin</a> i <a href="/polityka-prywatnosci" target="blank">politykę prywatności</a></label>
            </div>
            <div class="buy-buton-container">
                <button class="standard-button standard-big-button-orange" id="sumbit-and-buy">Kup teraz</button>
            </div>
        </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        
        let needInvoice = document.getElementById('need-invoice');
        needInvoice.addEventListener("change", function(){
            setTimeout(function(){
                if (document.getElementById('need-invoice').checked){
                    document.getElementById('invoice-cintainer').classList.remove('d-none');
                } else {
                    document.getElementById('invoice-cintainer').classList.add('d-none');
                }
            }, 80);
        });
        
        let sumbitButton = document.getElementById('sumbit-and-buy');
        sumbitButton.addEventListener("click", function(){
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
                accept_rules : document.querySelector('[name="accept_rules"]').checked,
                need_invoice : document.querySelector('[name="need_invoice"]').checked,
            };

            const Http = new XMLHttpRequest();
            let params = '?_token=' + document.querySelector('[name="_token"]').value + '&data=' +  JSON.stringify(formData);
            const url='/send-buy-now-request' + params;
            Http.open("POST", url);
            Http.send(params);

            Http.onreadystatechange = (e) => {
                if (Http.status == 200){
                    if(Http.readyState == 4) {
                        let response = JSON.parse(Http.responseText);
                        let formErrors = document.getElementById('form-erros');
                        formErrors.innerHTML = 'Wystąpiły błędy w formularzu zakupu: ';
                        if (response.status){
                            formErrors.classList.add('d-none');
                            window.location.href = response.paymentUrl;
                        } else {
                            formErrors.classList.remove('d-none');
                            let error; 
                            for (let i=0; i<response.errors.length; i++){
                                error = document.createElement("div");
                                error.classList.add('error-item');
                                error.innerHTML = response.errors[i];
                                formErrors.appendChild(error);
                            }
                            document.getElementById('scroll-page-top').scrollIntoView({
                                behavior: 'smooth'
                            });
                            
                        }
                    }
                }
              
            }
        });
    });
</script>    
@endsection