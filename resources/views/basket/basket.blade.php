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
    
@include('basket/basket-summary')

@include('basket/basket-login')   

@include('basket/basket-delivery')  

@include('basket/basket-finish')  
</div>


<script>
document.addEventListener("DOMContentLoaded", (event) => {
    let userId =  document.getElementById('current-user').getAttribute('content');
    if (userId != '' && userId != null){
        setUserData(userId);
    }
    
    let goToStep = parseInt(document.getElementById('go-to-step').getAttribute('content'));
    if (goToStep == 2){
        goToLoginStep();
        setTimeout(() => {
            window.history.pushState('koszyk', 'koszyk', '/koszyk');
        }, "300");
    }
    if (goToStep == 3){
        goToDataStep();
        setTimeout(() => {
            window.history.pushState('koszyk', 'koszyk', '/koszyk');
        }, "300");
    }
    if (goToStep == 4){
        goToFinishStep();
        setTimeout(() => {
            window.history.pushState('koszyk', 'koszyk', '/koszyk');
        }, "300");
    }
    
    dataInLocalStorage(false);
    
    @if ($sumbitBuy == 1)
        showGlobalLoader();
    
        @if ($newsletterSetAgree == 1)
            document.getElementById('check-3').checked = true;
        @endif
        
        document.getElementById('check-2').checked = true;
        document.getElementById('accept-rules1').checked = true;
        
        
        setTimeout(() => {
            localStorage.removeItem("userSetData");
            document.getElementById('finish-and-buy-now').click();
        }, "200");    
    @endif;
});
function goToBasketStep(){
    
    let basketItems = document.getElementById('basket-products-list').querySelectorAll('.basket-item-container');
    if (basketItems!= null && basketItems.length > 0){
        showGlobalLoader();

        let basketStepContainer = document.getElementById('basket-step');
        let dataStepContainer = document.getElementById('data-step');
        let loginStepContainer = document.getElementById('login-step');
        let finishStep = document.getElementById('finish-step');

        basketStepContainer.style.opacity = "1";
        basketStepContainer.style.height = "auto";
        basketStepContainer.style.display = 'flex';
        
        finishStep.style.opacity = "0";
        finishStep.style.height = "0px";
        finishStep.style.display = 'none';

        dataStepContainer.style.opacity = "0";
        dataStepContainer.style.height = "0px";
        dataStepContainer.style.display = 'none';

        loginStepContainer.style.opacity = "0";
        loginStepContainer.style.height = "0px";
        loginStepContainer.style.display = "none";

        document.body.scrollTop = 0; 
        document.documentElement.scrollTop = 0;
        
        changeStepOnTopSummary(1);
        
        //document.getElementById('top-bar-company-name').innerHTML = 'Drogeria';
        showMainLogo();
        
        setTimeout(() => {
            hideGlobalLoader();
        }, "300");
    }
}

function showMainLogo(){
    document.getElementById('top-header-main-logo').classList.remove('hidden');
    document.getElementById('top-header-pharmacy-logo').classList.add('hidden');
}

function showPharmacyLogo(){
    document.getElementById('top-header-main-logo').classList.add('hidden');
    document.getElementById('top-header-pharmacy-logo').classList.remove('hidden');
}

function goToLoginStep(){
    
    let basketItems = document.getElementById('basket-products-list').querySelectorAll('.basket-item-container');
    if (basketItems!= null && basketItems.length > 0){
        if (document.getElementById('current-user').content != '' && document.getElementById('current-user').content != null){
            goToDataStep();
        } else {
            showGlobalLoader();

            let basketStepContainer = document.getElementById('basket-step');
            let dataStepContainer = document.getElementById('data-step');
            let loginStepContainer = document.getElementById('login-step');
            let finishStep = document.getElementById('finish-step');

            basketStepContainer.style.opacity = "0";
            basketStepContainer.style.height = "0px";
            basketStepContainer.style.display = 'none';

            finishStep.style.opacity = "0";
            finishStep.style.height = "0px";
            finishStep.style.display = 'none';

            dataStepContainer.style.opacity = "0";
            dataStepContainer.style.height = "0px";
            dataStepContainer.style.display = 'none';

            loginStepContainer.style.opacity = "1";
            loginStepContainer.style.height = "auto";
            loginStepContainer.style.display = "flex";

            document.body.scrollTop = 0; 
            document.documentElement.scrollTop = 0;

            changeStepOnTopSummary(1);
            
            //document.getElementById('top-bar-company-name').innerHTML = 'Drogeria';
            showMainLogo();
            
            setTimeout(() => {
                hideGlobalLoader();
            }, "300");
        }
        
    }
}

function goToDataStep(){
    showGlobalLoader();
    
    let basketStepContainer = document.getElementById('basket-step');
    let dataStepContainer = document.getElementById('data-step');
    let loginStepContainer = document.getElementById('login-step');
    let finishStep = document.getElementById('finish-step');
    
    basketStepContainer.style.opacity = "0";
    basketStepContainer.style.height = "0px";
    basketStepContainer.style.display = 'none';
    
    loginStepContainer.style.opacity = "0";
    loginStepContainer.style.height = "0px";
    loginStepContainer.style.display = 'none';
    
    finishStep.style.opacity = "0";
    finishStep.style.height = "0px";
    finishStep.style.display = 'none';
    
    dataStepContainer.style.opacity = "1";
    dataStepContainer.style.height = "auto";
    dataStepContainer.style.display = 'flex';
    
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0;
    
    changeStepOnTopSummary(2);
    
    //document.getElementById('top-bar-company-name').innerHTML = 'Drogeria';
    showMainLogo();
    
    setTimeout(() => {
        hideGlobalLoader();
    }, "300");
}

function goToFinishStep(){
    showGlobalLoader();
    
    dataInLocalStorage(true);
    
    let basketStepContainer = document.getElementById('basket-step');
    let dataStepContainer = document.getElementById('data-step');
    let loginStepContainer = document.getElementById('login-step');
    let finishStep = document.getElementById('finish-step');
    
    basketStepContainer.style.opacity = "0";
    basketStepContainer.style.height = "0px";
    basketStepContainer.style.display = 'none';
    
    loginStepContainer.style.opacity = "0";
    loginStepContainer.style.height = "0px";
    loginStepContainer.style.display = 'none';
    
    finishStep.style.opacity = "1";
    finishStep.style.height = "auto";
    finishStep.style.display = "flex";
    
    dataStepContainer.style.opacity = "0";
    dataStepContainer.style.height = "0px";
    dataStepContainer.style.display = 'none';
    
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0;
    
    changeStepOnTopSummary(3);
    
    
    if (parseInt(document.getElementById('pharmacy-items-in-basket').value) == 1){

        /*nie usuwać  to jest backup rozdziału apteki i drogerii*/
        /*let allData = prepareDataToPharmacyOut();
        let basketId = getCookie('basket-identifier');
        let selectedDelivery = document.querySelector('.delivey-method-radio[name="select-delivey-method"]:checked');
        let deliveryPrice  = 20;
        if (selectedDelivery != null){
            deliveryPrice  = parseFloat(selectedDelivery.closest('li').querySelector('.delivery-price').getAttribute('data-price').replace(',','.'));
        }
        let url = '@if (Config::get('constants.use_ssl')){{'https://'}}@else{{'http://'}}@endif{{Config::get('constants.apteka_domin')}}' + '/koszyk-apteka?basket-identifier=' + basketId + '&d=' + deliveryPrice + '&summary=' + allData;
        
        console.log(url);
        window.location.replace(url);
        
        showPharmacyLogo();
        
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
        document.getElementById('footer-drogeria-logo').classList.add('hidden');*/
    } else {
        //document.getElementById('top-bar-company-name').innerHTML = 'Drogeria';
        /*showMainLogo();
        document.getElementById('footer-legal-pharmacy').classList.add('hidden');
        document.getElementById('footer-apteka-info').classList.add('hidden');
        document.getElementById('footer-cookies-apteka-info').classList.add('hidden');
        document.getElementById('footer-cookies-drogeria-info').classList.remove('hidden');
        document.getElementById('footer-rules-apteka-info').classList.add('hidden');
        document.getElementById('footer-rules-drogeria-info').classList.remove('hidden');
        document.getElementById('footer-permit-apteka-info').classList.add('hidden');
        document.getElementById('footer-wif-apteka-info').classList.add('hidden');
        document.getElementById('footer-apteka-email').classList.add('hidden');
        document.getElementById('footer-drogeria-email').classList.remove('hidden');
        document.getElementById('header-apteka-email').classList.add('hidden');
        document.getElementById('header-drogeria-email').classList.remove('hidden');
        document.getElementById('footer-newsleter-apteka-rules-span').classList.add('hidden');
        document.getElementById('footer-newsleter-drogeria-rules-span').classList.remove('hidden');
        
        document.getElementById('footer-pharmacy-logo').classList.add('hidden');
        document.getElementById('footer-drogeria-logo').classList.remove('hidden');*/
    }
    
    setTimeout(() => {
        hideGlobalLoader();
    }, "300");
}


function changeStepOnTopSummary(step){
    for (let i=0; i<=3; i++){
        let stepContainer = document.getElementById('top-step-'+i);
        if (stepContainer != null){
            if (i<=step){
                stepContainer.querySelector('.step-link-circle').classList.add('bg-wdoz-primary');
                stepContainer.querySelector('.this-step-number').classList.add('hidden');
                stepContainer.querySelector('.this-step-ready').classList.remove('hidden');
                stepContainer.querySelector('.step-link').classList.remove('pointer-events-none');
            } else {
                stepContainer.querySelector('.step-link-circle').classList.remove('bg-wdoz-primary');
                stepContainer.querySelector('.this-step-number').classList.remove('hidden');
                stepContainer.querySelector('.this-step-ready').classList.add('hidden');
                stepContainer.querySelector('.step-link').classList.add('pointer-events-none');
            }
        }
    }
}


function prepareDataToPharmacyOut(){
    
    let invoice = '';
    if (document.getElementById('need-invoice-checkbox').checked){
        invoice = document.getElementById('summary-invoice-data').innerHTML;
    }
    let data = {
        'p' :  document.getElementById('summary-personal-data').innerHTML,
        'i' : invoice,
        'd': document.getElementById('summary-delivery-data').innerHTML,
        'm': document.getElementById('summary-payment-data').innerHTML,
    };

    return JSON.stringify(data);
}


function dataInLocalStorage(isSave = false){
    let areasToSave = {
        0: {
            'name': 'buy-form-name',
            'type': 'input'
        },
        1: {
            'name': 'buy-form-surname',
            'type': 'input'
        },
        2: {
            'name': 'buy-form-email',
            'type': 'input'
        },
        3: {
            'name': 'buy-form-phone',
            'type': 'input'
        },
        4: {
            'name': 'buy-form-name',
            'type': 'input'
        },
        5: {
            'name': 'need-invoice-checkbox',
            'type': 'checkbox'
        },
        6: {
            'name': 'invoice-type-select',
            'type': 'select'
        },
        7: {
            'name': 'buy-form-company',
            'type': 'input'
        },
        8: {
            'name': 'buy-form-nip',
            'type': 'input'
        },
        9: {
            'name': 'buy-form-invoice-street',
            'type': 'input'
        },
        10: {
            'name': 'buy-form-invoice-house-number',
            'type': 'input'
        },
        11: {
            'name': 'buy-form-invoice-city',
            'type': 'input'
        },
        12: {
            'name': 'buy-form-invoice-zipcode',
            'type': 'input'
        },
        13: {
            'name': 'selected-orlen',
            'type': 'input'
        },
        14: {
            'name': 'selected-paczkomat',
            'type': 'input'
        },
        15: {
            'name': 'select-delivey-method',
            'type': 'radio'
        },
        16: {
            'name': 'payment-method',
            'type': 'radio'
        },
        17: {
            'name': 'accept-rules-newsletter',
            'type': 'checkbox'
        },
        18: {
            'name': 'buy-form-street',
            'type': 'input'
        },
        19: {
            'name': 'buy-form-chouse-number',
            'type': 'input'
        },
        20: {
            'name': 'buy-form-city',
            'type': 'input'
        },   
        21: {
            'name': 'buy-form-zipcode',
            'type': 'input'
        },    
            
    };
    
    
    if (isSave){
        let jsonToSave = {};

        for (const [key, area] of Object.entries(areasToSave)) {    
            let input = document.getElementById(area.name);
            if (input != null){
                if (area.type == 'input'){
                    jsonToSave[area.name] = input.value;
                }
                if (area.type == 'checkbox'){
                    if (input.checked){
                        jsonToSave[area.name] = 1;
                    } else {
                        jsonToSave[area.name] = 0;
                    }
                }
                
            }
            if (area.type == 'radio'){
                let selectedInput = document.querySelector('[name="'+area.name+'"]:checked');
                if (selectedInput != null){
                    jsonToSave[area.name] = selectedInput.value;
                } else {
                    jsonToSave[area.name] = '';
                }
            }
        };
        jsonToSaveData = {
            'expiredDate': Date.now() + 1000,
            'items': JSON.stringify(jsonToSave)
        }

        let jsonString = JSON.stringify(jsonToSaveData);
        localStorage.setItem("userSetData", jsonString);
    } else {
        let userData = localStorage.getItem("userSetData");
        if (userData != '' && userData != null){
            userData = JSON.parse(userData);
            if (userData.items != null && userData.items != ''){
                let userDataItems = JSON.parse(userData.items);
                for (const [key, area] of Object.entries(areasToSave)) {    
                    if (typeof userDataItems[area.name] != 'undefined' && userDataItems[area.name] != null){
                        
                        let input = document.getElementById(area.name);
                        if (input != null){
                            if (area.type == 'input'){
                                input.value = userDataItems[area.name];
                            }
                            if (area.type == 'checkbox'){
                                if (userDataItems[area.name] == 1){
                                    input.checked = true;
                                }
                                if (userDataItems[area.name] == 0){
                                    input.checked = false;
                                }
                            }
                            
                        }
                        if (area.type == 'radio'){

                            let radioInput = document.querySelector('[name="'+area.name+'"][value="'+userDataItems[area.name]+'"]');
                            if (radioInput != null){
                                radioInput.checked = true;
                            }
                        }
                        
                        if (area.name == 'need-invoice-checkbox'){
                            showHideInvoideContainer();
                        }
                        
                        if (area.name == 'selected-orlen'){
                            document.getElementById('selected-orlen-point-visible').innerHTML = userDataItems[area.name];
                            if (userDataItems[area.name] != ''){
                                document.getElementById('selected-orlen-point-visible').classList.remove('hidden');
                            }
                        }
                        if (area.name == 'selected-paczkomat'){
                            document.getElementById('selected-paczkomat-visible').innerHTML = userDataItems[area.name];
                            if (userDataItems[area.name] != ''){
                                document.getElementById('selected-paczkomat-visible').classList.remove('hidden');
                            }
                        }
                        
                        if (area.name == 'select-delivey-method'){
                            let myRadio = document.querySelector('[name="'+area.name+'"][value="'+userDataItems[area.name]+'"]');
                            if (myRadio.getAttribute('data-orlen-widget') != 1){
                                document.getElementById('selected-orlen-point-visible').innerHTML = '';
                                document.getElementById('selected-orlen-point-visible').classList.add('hidden');
                                document.getElementById('selected-orlen').value = '';
                            }
                            if (myRadio.getAttribute('data-inpost-widget') != 1){
                                document.getElementById('selected-paczkomat-visible').innerHTML = '';
                                document.getElementById('selected-paczkomat-visible').classList.add('hidden');
                                document.getElementById('selected-paczkomat').value = '';
                            }
                        }
                    }
                }
            }
        }
    }
}
</script>
@endsection