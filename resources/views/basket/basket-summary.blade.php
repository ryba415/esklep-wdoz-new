<div id="basket-step" class="flex flex-col lg:flex-row w-full gap-5">
    <div id="basket-products-list" class="left" style="max-width: 700px; width: 100%; flex-grow: 10; align-self: center;">
        <!-- produkty apteczne-->
        @if ($basket->medicamentsCount > 0)
        <div class="border-t-4 border-wdoz-primary max-w-[714px] rounded-b-lg drop-shadow-lg p-5 mb-5 bg-white "> 
          <h3 class="text-lg font-medium pb-4">Produkty apteczne</h3> <!-- produkt 1--> 
          @foreach ($basket->basketItems as $item)
            @if ($item->is_cosmetic != 1)
            @include('basket/basket-item',['enalbeChange'=>true]) 
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
              @include('basket/basket-item',['enalbeChange'=>true]) 
            @endif
          @endforeach
        </div>
        @endif
         <!-- *produkty drogeryjne-->
        
         <p class="text-center mb-5 @if ($basket->itemsCount > 0) hidden @endif">Brak produktów w koszyku. <a class="font-bold" href="/">Wróć na stronę główną.</a></p>
        
        @if ($basket->itemsCount > 0)
            <a href="/" class=" text-black mt-4 rounded p-3 shadow text-base basis-[700px] mt-5 hidden lg:inline-block">Przejdź do strony głównej</a>
        @endif 
    </div>


     <!-- podsumowanie-->
     <div class="right   rounded-b-lg drop-shadow-lg p-5 bg-white max-w-[700px] w-full lg:w-[370px] gap-3 self-center  md:flex-1 lg:self-baseline"> 
      <div id="basket-medicaments-summary-price-container" class="flex flex-row pb-2 justify-between @if($basket->medicamentsCount <= 0 ) hidden @endif">  
        <span class="text-md font-normal">Produkty apteczne</span>
        <div class="text-md font-semibold">
            <span id="basket-medicaments-summary-price">{{$basket->diplayPrice($basket->medicamentsValueGross)}}</span>
            <span>zł</span>
        </div>
      </div>
      <div id="basket-cosmetics-summary-price-container" class="flex flex-row pb-2 justify-between @if($basket->cosmeticsCout <= 0 ) hidden @endif " >  
        <span class="text-md font-normal">Produkty drogeryjne</span>
        <div class="text-md font-semibold">
            <span id="basket-cosmetics-summary-price">{{$basket->diplayPrice($basket->cosmeticsValueGross)}}</span>
            <span>zł</span>
        </div>
      </div>

      @if ($basket->freeDeliveryFromValue !== null) 

      <div id="missing-for-free-delivery-container" class="flex flex-col bg-wdoz-body-bg border text-right justify-end p-2 @if ($basket->valueGross >= $basket->freeDeliveryFromValue) hidden @endif">
        <span class="text-sm font-normal">Darmowa wysyłka od {{$basket->diplayPrice($basket->freeDeliveryFromValue)}} zł</span>
        <div class="text-sm font-normal">Do darmowej wysyłki brakuje: <span id="missing-for-free-delivery">{{$basket->diplayPrice($basket->freeDeliveryFromValue-$basket->valueGross)}}</span> zł</div>
      </div>
      <div id="get-free-delivery-container" class="flex flex-col bg-wdoz-body-bg border text-right justify-end p-2 text-gray-900 bg-wdoz-primary-10 @if ($basket->valueGross < $basket->freeDeliveryFromValue) hidden @endif">
          <span class="text-sm font-normal">Otrzymujesz darmową wysyłkę!</span>
      </div>
      @endif

        <div class="flex flex-row  pt-3 justify-between border-t mt-3 flex-wrap">  
            <span class="text-md font-bold  ">Podsumowanie</span>
            <div class="text-md font-semibold">
                <span id="basket-summary-price" >{{$basket->diplayPrice($basket->valueGross)}}</span>
                <span>zł</span>
            </div>
            <button id="go-to-login-step" class="@if ($basket->itemsCount > 0) bg-wdoz-primary hover:bg-wdoz-primary-900 @else bg-gray-400 cursor-auto @endif  text-white mt-4 rounded p-3 shadow text-base basis-[700px]">Dalej</button>
        </div>
    <!-- *podsumowanie-->
    </div>
</div>
    
<script>

let deleteButtons = document.querySelectorAll('.delete-basket-item');

for (let i=0;i<deleteButtons.length;i++){
    deleteButtons[i].addEventListener("click", (event) => {
        const itemContainer = event.currentTarget.closest('.basket-item-container');
        deleteBasketItem(itemContainer); // << ważne
    });
}

let incrementQuantityButtons = document.querySelectorAll('.set-quantity-more');

for (let i=0;i<incrementQuantityButtons.length;i++){
    incrementQuantityButtons[i].addEventListener("click", (event) => {
        const itemContainer = event.currentTarget.closest('.basket-item-container');
        const quantityInput = itemContainer.querySelector('.set-quantity-input');
        quantityInput.value = parseInt(quantityInput.value || '0') + 1;
        quantityInput.dispatchEvent(new Event('change'));
    });
}

document.executeIncrementQuantity = function executeIncrementQuantity(event){
    let itemContainer = event.target.closest('.basket-item-container');
    let quantityInput = itemContainer.querySelector('.set-quantity-input');
    quantityInput.value = parseInt(quantityInput.value) + 1;
    var event = new Event('change');
    quantityInput.dispatchEvent(event);
};

document.executedecrementQuantity = function executedecrementQuantity(event){
    let itemContainer = event.target.closest('.basket-item-container');
    let quantityInput = itemContainer.querySelector('.set-quantity-input');
    let newVal = parseInt(quantityInput.value) - 1;
    if (newVal > 0){
        quantityInput.value = newVal;
        var event = new Event('change');
        quantityInput.dispatchEvent(event);
    } else {
        deleteBasketItem(event.target);
    }
};

let decrementQuantityButtons = document.querySelectorAll('.set-quantity-less');

for (let i=0;i<decrementQuantityButtons.length;i++){
    decrementQuantityButtons[i].addEventListener("click", (event) => {
        const itemContainer = event.currentTarget.closest('.basket-item-container');
        const quantityInput = itemContainer.querySelector('.set-quantity-input');
        const newVal = parseInt(quantityInput.value || '0') - 1;

        if (newVal > 0){
            quantityInput.value = newVal;
            quantityInput.dispatchEvent(new Event('change'));
        } else {
            deleteBasketItem(itemContainer); // << ważne, przekaż kontener
        }
    });
}

let quantityInputs = document.querySelectorAll('.set-quantity-input');
for (let i=0;i<quantityInputs.length;i++){
    quantityInputs[i].addEventListener("change", (event) => {
        let quantity = parseInt(event.target.value);
        if (quantity > 0){
            changeQuantity(event.target, quantity, true);
        } else {
            deleteBasketItem(event.target);
        }
        
    });
}

document.getElementById('go-to-login-step').addEventListener("click", (event) => {
    goToLoginStep();
});

rebuildBasket();



async function rebuildBasket(){
    fetch('/get-basket-dataa', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            hash: document.getElementById('basket-identity').value
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
        document.getElementById('basket-summary-price').innerHTML = priceFormat(jsonResponse.basket.valueGross);
        document.getElementById('basket-summary-price2').innerHTML = priceFormat(jsonResponse.basket.valueGross);
        document.getElementById('basket-medicaments-summary-price').innerHTML = priceFormat(jsonResponse.basket.medicamentsValueGross);
        document.getElementById('basket-medicaments-summary-price2').innerHTML = priceFormat(jsonResponse.basket.medicamentsValueGross);
        if (jsonResponse.basket.medicamentsCount == 0){
            document.getElementById('basket-medicaments-summary-price-container').classList.add("hidden");
        } else {
            document.getElementById('basket-medicaments-summary-price-container').classList.remove("hidden");
        }
        document.getElementById('basket-cosmetics-summary-price').innerHTML = priceFormat(jsonResponse.basket.cosmeticsValueGross);
        document.getElementById('basket-cosmetics-summary-price2').innerHTML = priceFormat(jsonResponse.basket.cosmeticsValueGross);
        if (jsonResponse.basket.cosmeticsCout == 0){
            document.getElementById('basket-cosmetics-summary-price-container').classList.add("hidden");
        } else {
            document.getElementById('basket-cosmetics-summary-price-container').classList.remove("hidden");
        }
        
        if (jsonResponse.basket.freeDeliveryFromValue != null && document.getElementById('missing-for-free-delivery-container') != null){
            let missingFreeDelivery = jsonResponse.basket.freeDeliveryFromValue - jsonResponse.basket.valueGross;
            if (missingFreeDelivery <= 0){
                missingFreeDelivery = 0;
                document.getElementById('missing-for-free-delivery-container').classList.add("hidden");
                document.getElementById('get-free-delivery-container').classList.remove("hidden");
                document.getElementById('missing-for-free-delivery-container2').classList.add("hidden");
                document.getElementById('get-free-delivery-container2').classList.remove("hidden");
            } else {
                document.getElementById('missing-for-free-delivery-container').classList.remove("hidden");
                document.getElementById('get-free-delivery-container').classList.add("hidden");
                document.getElementById('missing-for-free-delivery-container2').classList.remove("hidden");
                document.getElementById('get-free-delivery-container2').classList.add("hidden");
            }
            document.getElementById('missing-for-free-delivery').innerHTML = priceFormat(missingFreeDelivery);
            document.getElementById('missing-for-free-delivery2').innerHTML = priceFormat(missingFreeDelivery);
        }
        //let productsListContainer = document.getElementById('basket-products-list');
        for (let i = 0; i < jsonResponse.basket.basketItems.length; i++) {
            const item = jsonResponse.basket.basketItems[i];

            const itemContainer = document.querySelector('.basket-item-container[data-item-id="' + item.id + '"]');
            if (!itemContainer) continue;

            const priceGrossEl = itemContainer.querySelector('.basket-item-price-gross');
            const qtyTextEl = itemContainer.querySelector('.basket-item-price-quantity');
            const unitPriceEl = itemContainer.querySelector('.basket-item-unit-price-gross');
            const unitPriceBox = itemContainer.querySelector('.basket-item-unit-price-gross-container');

            if (priceGrossEl) priceGrossEl.innerHTML = priceFormat(item.valueGross);
            if (qtyTextEl) qtyTextEl.innerHTML = item.quantity + ' szt.';

            const unit = (item.quantity > 0) ? (item.valueGross / item.quantity) : 0;

            if (unitPriceEl) unitPriceEl.innerHTML = priceFormat(unit);

            if (unitPriceBox) {
                if (item.quantity > 1) unitPriceBox.classList.remove("hidden");
                else unitPriceBox.classList.add("hidden");
            }

            const qtyInput = itemContainer.querySelector('.set-quantity-input');
            if (qtyInput) qtyInput.value = item.quantity;

        }


        if (jsonResponse.basket.drugsCount == 0){
            let deliverymethods = document.querySelectorAll('.delivery-method-in-basket');
            for (let i=0;i<deliverymethods.length;i++){
                deliverymethods[i].classList.remove("pointer-events-none");
                deliverymethods[i].classList.remove("opacity-40");
                deliverymethods[i].classList.remove("grayscale");
            }
            let paczkomatUnavariable = document.querySelectorAll('.paczkomat-unavariable-info');
            for (let i=0;i<paczkomatUnavariable.length;i++){
                paczkomatUnavariable[i].classList.add("hidden");
            }
        }
    });
}

function priceFormat(price){
    price = (Math.round(parseFloat(price) * 100) / 100).toFixed(2);
    price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    price = price.replace('.', ',');
    return price;
}


</script>
