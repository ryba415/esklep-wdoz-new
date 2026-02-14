<script>
    window.addProductToFavorite = function addProductToFavorite(e,id){
        let favorites = localStorage.getItem("favorites-items");

        if (favorites != null && favorites != ''){
            favorites = JSON.parse(favorites);
        } else {
            favorites = [];
        }
        
        let animation = e.querySelector('.heart-add-to-favorite-button');
        
        if (favorites.includes(id)){
            var index = favorites.indexOf(id);
            if (index !== -1) {
              favorites.splice(index, 1);
            }
            animation.classList.add('hidden');
            animation.classList.remove('animate');
            
            if (location.pathname == '/favorites-list' || location.pathname == '/favorites-list/'){
                setTimeout(() => {
                    e.closest('.product-container').remove();
                }, "200");
            }
            
        } else {
            favorites.push(id);
            animation.classList.remove('hidden');
            setTimeout(animation.classList.add('animate'), 30);
            setTimeout(animation.classList.remove('animate'), 500);
            setTimeout(animation.classList.add('animate'), 600);
        }
        
        localStorage.setItem('favorites-items', JSON.stringify(favorites));
        setCookie('favorites-items',JSON.stringify(favorites));

        setTimeout(showFavoritesInHeader(), 100);
        
        
        
    };
    
    window.addToBasket = function addToBasket(btn, id) {
    showGlobalLoader();

    const shortBox = btn.closest('.short-box');
    const productContainer = btn.closest('.product-container');

    const isShort = !!shortBox;

    let quantity = 1;
    let expirationDate = null;

    if (isShort) {
        const input = shortBox.querySelector('.short-quantity-input');
        if (input) quantity = parseInt(input.value || '1', 10) || 1;

        const max = parseInt(shortBox.dataset.max || '0', 10);
        if (max > 0 && quantity > max) quantity = max;
        if (quantity < 1) quantity = 1;

        expirationDate = shortBox.dataset.expirationDate || null;
    } else if (productContainer) {
        const input = productContainer.querySelector(':scope .product-quantity-input');
        if (input) quantity = parseInt(input.value || '1', 10) || 1;
        if (quantity < 1) quantity = 1;
    }

    let basketId = getBasketHash();
    if (basketId === '') basketId = null;

    const payload = {
        hash: basketId,
        id: id,
        quantity: quantity,
        expiration_date: expirationDate,
    };

    fetch('/add-to-basket', {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
        .then(r => { if (r.ok) return r.json(); throw new Error('Request failed!'); })
        .then(jsonResponse => {
        setCookie('basket-identifier', jsonResponse.hash);

        const errorScope = isShort ? shortBox : productContainer;
        const errorInfo = errorScope ? errorScope.querySelector('.add-to-basker-error-info') : null;

        if (jsonResponse.status === false) {
            if (errorInfo) {
            errorInfo.classList.remove('hidden');
            errorInfo.innerHTML = (jsonResponse.errors || []).map(e => `${e}<br>`).join('') || 'Wystąpił błąd.';
            }
        } else {
            if (errorInfo) {
            errorInfo.classList.add('hidden');
            errorInfo.innerHTML = '';
            }
        }

        setBasketInHeader(jsonResponse.basketData);
        setTimeout(() => hideGlobalLoader(), 350);
        })
        .catch(() => hideGlobalLoader());
    };


    function getBasketHash() {
        const el = document.getElementById('basket-identity');
        if (el && el.value) return el.value;
        return getCookie('basket-identifier') || '';
    }
    
    function closeMinicart(e){
        document.getElementById('minicart').classList.remove('minicart-active');
        setTimeout(() => {
            document.getElementById('minicart').classList.add('minicart-active');
        }, "100");
    }
    
    function setBasketInHeader(basketObject){
        if (basketObject.basket != null && basketObject.basket.itemsCount > 0){
            document.getElementById('basket-header-summary-price').innerHTML = priceFormat(basketObject.basket.valueGross) + ' zł';
            
            document.getElementById('basket-header-summary-items-count').innerHTML = basketObject.basket.itemsCount;
            document.getElementById('basket-header-summary-items-count').classList.remove('hidden');
            
            document.getElementById('minicart-total-price').innerHTML = priceFormat(basketObject.basket.valueGross) + ' zł';
            
            document.getElementById('minicart').classList.add('minicart-active');
            
            let minicartItemTemplate = document.getElementById('minicart-product-template');
            
            document.getElementById('minicart-items-list').innerHTML = '';
            document.getElementById('minicart-products-count').innerHTML = basketObject.basket.itemsCount;
            for (let i=0;i<basketObject.basket.basketItems.length;i++){
                let newItem = minicartItemTemplate.cloneNode(true);
                newItem.removeAttribute('id');

                const bi = basketObject.basket.basketItems[i];

                newItem.setAttribute('data-item-id', bi.id);
                newItem.setAttribute('data-product-id', bi.productId);
                newItem.setAttribute('data-expiration-date', bi.expiration_date || '');
                let nodes = newItem.querySelectorAll('[data-product-id], [data-item-id], [data-expiration-date]');
                for (let z=0; z<nodes.length; z++){
                    if (nodes[z].hasAttribute('data-product-id')) nodes[z].setAttribute('data-product-id', bi.productId);
                    if (nodes[z].hasAttribute('data-item-id')) nodes[z].setAttribute('data-item-id', bi.id);
                    if (nodes[z].hasAttribute('data-expiration-date')) nodes[z].setAttribute('data-expiration-date', bi.expiration_date || '');
                }
                newItem.classList.remove('hidden');
                newItem.querySelector('.minicart-product-name').innerHTML = basketObject.basket.basketItems[i].name;
                
                if (basketObject.basket.basketItems[i].quantity > 1){
                    newItem.querySelector('.minicart-product-price').innerHTML = priceFormat(basketObject.basket.basketItems[i].valueGross) + ' zł<br><span class="font-light">' + priceFormat(basketObject.basket.basketItems[i].valueGross/basketObject.basket.basketItems[i].quantity)+ ' zł/szt.</span>';
                } else {
                    newItem.querySelector('.minicart-product-price').innerHTML = priceFormat(basketObject.basket.basketItems[i].valueGross) + ' zł';
                }
                //newItem.querySelector('.minicart-product-quantity').innerHTML = basketObject.basket.basketItems[i].quantity;
                newItem.querySelector('.minicart-product-quantity').value = basketObject.basket.basketItems[i].quantity;
                if (typeof basketObject.basket.basketItems[i].images[0] != 'undefined'){
                    newItem.querySelector('.minicart-product-image').setAttribute('src','https://esklep.wdoz.pl/uploads/images/product/' + basketObject.basket.basketItems[i].images[0].image_name);
                    newItem.querySelector('.minicart-product-image').setAttribute('alt',basketObject.basket.basketItems[i].name);
                }
                
                document.getElementById('minicart-items-list').append(newItem);
            }
        }
    }    
    
    function updateBasketPageFromBasketData(basketData) {
        const basket = basketData?.basket;
        if (!basket) return;


        const map = new Map();
        for (const bi of (basket.basketItems || [])) {
            const key = `${bi.productId}|${bi.expiration_date ? bi.expiration_date : 'NULL'}`;
            map.set(key, bi);
        }

        const rows = document.querySelectorAll('.basket-item-container[data-variant-key]');
        rows.forEach(row => {
            const key = row.getAttribute('data-variant-key');
            const bi = map.get(key);

            if (!bi) {
            row.remove();
            return;
            }

            const qtyInput = row.querySelector('.set-quantity-input');
            if (qtyInput) qtyInput.value = bi.quantity;

            const qtyText = row.querySelector('.basket-item-price-quantity');
            if (qtyText) qtyText.textContent = `${bi.quantity} szt.`;

            const priceGross = row.querySelector('.basket-item-price-gross');
            if (priceGross) priceGross.textContent = priceFormat(bi.valueGross);

            const unitWrap = row.querySelector('.basket-item-unit-price-gross-container');
            const unitVal = row.querySelector('.basket-item-unit-price-gross');
            if (bi.quantity > 1) {
            if (unitWrap) unitWrap.classList.remove('hidden');
            if (unitVal) unitVal.textContent = priceFormat(bi.valueGross / bi.quantity);
            } else {
            if (unitWrap) unitWrap.classList.add('hidden');
            }

            row.setAttribute('data-item-id', bi.id);
            row.setAttribute('data-product-id', bi.productId);
            row.setAttribute('data-expiration-date', bi.expiration_date || '');
        });

        const anyLeft = document.querySelectorAll('.basket-item-container[data-variant-key]').length;
        if (anyLeft === 0) location.reload();
        }


    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    
    function priceFormat(price){
        price = (Math.round(parseFloat(price) * 100) / 100).toFixed(2);
        price = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        price = price.replace('.', ',');
        return price;
    }
  
    
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
    
    
    
    document.addEventListener("DOMContentLoaded", function() {

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-product');
        if (!btn) return;

        const itemContainer = btn.closest('.basket-item-container');
        if (!itemContainer) return;

        deleteBasketItem(itemContainer);
    });

        let favorites = localStorage.getItem("favorites-items");
        if (favorites != null && favorites != ''){
            favorites = JSON.parse(favorites);
            for (let i=0;i<favorites.length;i++){
                let favorite = favorites[i];
                let icon = document.getElementById('favorite-item-icon-' + favorite);
                if (icon != null){
                    icon = icon.querySelector('.heart-add-to-favorite-button')
                    icon.classList.add('animate');
                    icon.classList.remove('hidden');
                }
            }
            showFavoritesInHeader();

        }
        fetch('/get-basket-dataa', { 
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                'hash': getCookie('basket-identifier')
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
            setBasketInHeader(jsonResponse);
        });
    });
    
    function showFavoritesInHeader(){
        let favorites = localStorage.getItem("favorites-items");
        if (favorites != null && favorites != ''){
            favorites = JSON.parse(favorites);
            if (favorites.length > 0){
                let favoritesInHeader = document.getElementById('favorites-count-in-header');
                favoritesInHeader.classList.remove('hidden');
                favoritesInHeader.innerHTML = favorites.length;
                document.getElementById('favorites-description-in-header').classList.remove('hidden');
            }
        }
    }
    
    window.executeIncrementQuantity = function executeIncrementQuantity(event){
        let itemContainer = event.closest('.product-container');
        let quantityInput = itemContainer.querySelector('.product-quantity-input');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        var event = new Event('change');
        quantityInput.dispatchEvent(event);
    };

    window.executedecrementQuantity = function executedecrementQuantity(event){
        let itemContainer = event.closest('.product-container');
        let quantityInput = itemContainer.querySelector('.product-quantity-input');
        let newVal = parseInt(quantityInput.value) - 1;
        if (newVal > 0){
            quantityInput.value = newVal;
            var event = new Event('change');
            quantityInput.dispatchEvent(event);
        } else {
            deleteBasketItem(event.target);
        }
    };
    
    window.shortIncrementQuantity = function shortIncrementQuantity(btn) {
    const container = btn.closest('.short-product-container');
    if (!container) return;

    const max = parseInt(container.dataset.max || '0', 10);
    const input = container.querySelector('.short-quantity-input');
    if (!input) return;

    let current = parseInt(input.value || '0', 10);
    if (isNaN(current) || current < 1) current = 1;

    if (max > 0 && current >= max) {
        input.value = max;

        const err = container.querySelector('.short-stock-info');
        if (err) {
        err.textContent = `Maksymalnie ${max} szt. w krótkiej dacie.`;
        err.classList.remove('hidden');
        }
        return;
    }

    input.value = current + 1;
    input.dispatchEvent(new Event('change', { bubbles: true }));
    };

    window.shortDecrementQuantity = function shortDecrementQuantity(btn) {
    const container = btn.closest('.short-product-container');
    if (!container) return;

    const input = container.querySelector('.short-quantity-input');
    if (!input) return;

    let current = parseInt(input.value || '0', 10);
    if (isNaN(current) || current < 1) current = 1;

    const next = current - 1;

    if (next >= 1) {
        input.value = next;
        input.dispatchEvent(new Event('change', { bubbles: true }));
    } else {
        input.value = 1;
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }
    };

    document.addEventListener('input', (e) => {
    if (!e.target.classList.contains('short-quantity-input')) return;

    const input = e.target;
    const container = input.closest('.short-product-container');
    const max = parseInt(container?.dataset.max || '0', 10);

    let val = parseInt(input.value || '0', 10);
    if (isNaN(val) || val < 1) val = 1;
    if (max > 0 && val > max) val = max;

    input.value = val;
    });



    window.executeIncrementQuantityAndUpdate = function executeIncrementQuantityAndUpdate(event){
        let itemContainer = event.closest('.basket-item-container');
        let quantityInput = itemContainer.querySelector('.minicart-product-quantity');
        quantityInput.value = parseInt(quantityInput.value) + 1;
        var event = new Event('change');
        quantityInput.dispatchEvent(event);
    };

    window.executedecrementQuantityAndUpdate = function executedecrementQuantityAndUpdate(event){
        let itemContainer = event.closest('.basket-item-container');
        let quantityInput = itemContainer.querySelector('.minicart-product-quantity');
        let newVal = parseInt(quantityInput.value) - 1;
        if (newVal > 0){
            quantityInput.value = newVal;
            var event = new Event('change');
            quantityInput.dispatchEvent(event);
        } else {
            deleteBasketItem(itemContainer);
        }
    };
    
    window.executeUpdateQuantity = function executeUpdateQuantity(event){
    let quantity = parseInt(event.value);
        if (quantity > 0){
            changeQuantity(event, quantity, true);
        } else {
            deleteBasketItem(event);
        }
    };
    
    async function changeQuantity(buttonOrContainer, quantity, replace = false){
        showGlobalLoader();

        const itemContainer = buttonOrContainer.classList?.contains('basket-item-container')
            ? buttonOrContainer
            : buttonOrContainer.closest('.basket-item-container');

        if (!itemContainer) {
            hideGlobalLoader();
            return;
        }

        const itemId = itemContainer.getAttribute('data-item-id');
        const productId = itemContainer.getAttribute('data-product-id');


        const expirationDateAttr = itemContainer.getAttribute('data-expiration-date');
        const expirationDate = (expirationDateAttr && expirationDateAttr.trim() !== '') ? expirationDateAttr : null;

        const quantityInput = itemContainer.querySelector('.set-quantity-input');
        const currentVal = parseInt(quantityInput?.value || '0');


        const newQuantity = replace ? parseInt(quantity) : (currentVal + parseInt(quantity));


        let identity = getBasketHash();


        if (newQuantity <= 0) {
            await deleteBasketItem(itemContainer);
            hideGlobalLoader();
            return;
        }

        try {
            const res = await fetch('/add-to-basket', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: parseInt(productId),
                    quantity: parseInt(newQuantity), 
                    changeQuantity: true,
                    expiration_date: expirationDate,   
                    hash: identity
                })
            });

            const jsonResponse = await res.json();
            if (jsonResponse?.basketData) {
                setBasketInHeader(jsonResponse.basketData);
                updateBasketPageFromBasketData(jsonResponse.basketData);
            }


            if (typeof rebuildBasket !== 'undefined'){
                rebuildBasket();
            }

            const errorInfo = itemContainer.querySelector('.add-to-basker-error-info');

            if (!res.ok || jsonResponse.status === false){
                if (errorInfo != null){
                    errorInfo.innerHTML = '';
                    errorInfo.classList.remove('hidden');

                    let errorsString = '';
                    if (jsonResponse.errors && jsonResponse.errors.length){
                        for (let e=0;e<jsonResponse.errors.length;e++){
                            errorsString += jsonResponse.errors[e] + '<br>';
                        }
                    } else {
                        errorsString = 'Wystąpił błąd.';
                    }

                    errorInfo.innerHTML = errorsString;
                }


            } else {
                if (errorInfo != null){
                    errorInfo.classList.add('hidden');
                    errorInfo.innerHTML = '';
                }
                if (quantityInput) quantityInput.value = newQuantity;
            }

        } catch (e) {
            console.log(e);
        } finally {
            setTimeout(() => {
                hideGlobalLoader();
            }, 450);
        }
    }
    async function deleteBasketItem(deleteButtonOrContainer){
        showGlobalLoader();

        const itemContainer = deleteButtonOrContainer.classList?.contains('basket-item-container')
            ? deleteButtonOrContainer
            : deleteButtonOrContainer.closest('.basket-item-container');

        if (!itemContainer) { hideGlobalLoader(); return; }

        const itemId = itemContainer.getAttribute('data-item-id');
        const identity = getBasketHash();

        try {
            const res = await fetch('/remove-from-basket', {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id: parseInt(itemId, 10),
                hash: identity
            })
            });

            const jsonResponse = await res.json();

            if (jsonResponse?.basketData) {
                setBasketInHeader(jsonResponse.basketData);
                updateBasketPageFromBasketData(jsonResponse.basketData);
            }
            if (typeof rebuildBasket !== 'undefined') rebuildBasket();


            if (typeof rebuildBasket !== 'undefined') rebuildBasket();

        } catch (e) {
            console.log(e);
        } finally {
            setTimeout(() => hideGlobalLoader(), 450);
        }
    }


</script>