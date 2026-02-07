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
    
    window.addToBasket = function addToBasket(e,id){
        showGlobalLoader();
        
        let quantity = 1;
        let productContainer = e.closest('.product-container');
        if (productContainer != null){
            let quantityInput = productContainer.querySelector('.product-quantity-input');
            if (quantityInput != null){
                quantity = quantityInput.value;
            }
        }
        let basketId = getCookie('basket-identifier'); //
        if (typeof basketId == 'undefined' || basketId == ''){
            basketId = null;
        }
        
        let formdata = {
            'hash': basketId,
            'id': id,
            'quantity': quantity
        };
        fetch('/add-to-basket', { 
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                    'hash': basketId,
                    'id': id,
                    'quantity': quantity
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
            setCookie('basket-identifier',jsonResponse.hash);
            
            if (jsonResponse.status == false){
                let productContainer = e.closest('.product-container');
                console.log(jsonResponse);
                if (productContainer != null){
                    let errorInfo = productContainer.querySelector('.add-to-basker-error-info');
                    console.log(errorInfo);
                    if (errorInfo != null){
                        errorInfo.innerHTML = '';
                        errorInfo.classList.remove('hidden');
                        let errorsString = '';
                        for (let e=0;e<jsonResponse.errors.length;e++){
                            errorsString = errorsString + jsonResponse.errors[e] + '<br>';
                        }
                        console.log(errorsString);
                        errorInfo.innerHTML = errorsString;
                    }
                }
            } else {
               let productContainer = e.closest('.product-container');
                if (productContainer != null){
                    let errorInfo = productContainer.querySelector('.add-to-basker-error-info');
                    if (errorInfo != null){
                        errorInfo.classList.add('hidden');
                        errorInfo.innerHTML = '';
                    }
                } 
            }
            console.log(jsonResponse);
            setBasketInHeader(jsonResponse.basketData);
            
            setTimeout(() => {
                hideGlobalLoader();
            }, "350");
            //
        });
        
    };
    
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
                newItem.setAttribute('data-product-id',basketObject.basket.basketItems[i].productId);
                let itemsIdAttrs = newItem.querySelectorAll('[data-product-id]');
                for (let z=0;z<itemsIdAttrs.length;z++){
                    itemsIdAttrs[z].setAttribute('data-product-id',basketObject.basket.basketItems[i].productId);
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
            deleteBasketItem(event);
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
    
    async function changeQuantity(button, quantity, replace = false){
        showGlobalLoader();
        let itemContainer = button.closest('.basket-item-container');
        //let itemId = itemContainer.getAttribute('data-item-id');
        let productId = itemContainer.getAttribute('data-product-id');
        let quantityInput = itemContainer.querySelector('.set-quantity-input');
        let newQuantity = 0;
        if (replace){
            newQuantity = parseInt(quantity);
        } else {
            newQuantity = parseInt(quantityInput.value) + quantity;
        }
        
        let identity = '';
        if (document.getElementById('basket-identity') != null){
            identity = document.getElementById('basket-identity').value;
        } else {
            identity = getCookie('basket-identifier');
        }

        fetch('/add-to-basket', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: productId,
                quantity: quantity,
                changeQuantity: true,
                hash: identity
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
                rebuildBasket();
            }
            if (newQuantity > 0){
                quantityInput.value = newQuantity;
                
                if (jsonResponse.status == false){
                    let product = document.querySelector('.product-container[data-product-id="'+productId+'"]');
                    console.log(product);
                    if (product != null){
                        //let productContainer = product.closest('.product-container');
                       // console.log(productContainer);
                        //if (productContainer != null){
                            let errorInfo = product.querySelector('.add-to-basker-error-info');
                            console.log(errorInfo);
                            if (errorInfo != null){
                                errorInfo.innerHTML = '';
                                errorInfo.classList.remove('hidden');
                                let errorsString = '';
                                for (let e=0;e<jsonResponse.errors.length;e++){
                                    errorsString = errorsString + jsonResponse.errors[e] + '<br>';
                                }
                                console.log(errorsString);
                                errorInfo.innerHTML = errorsString;
                            }
                        //}
                    }
                } else {
                    let product = document.querySelector('.product-container[data-product-id="'+productId+'"]');
                    //console.log(product);
                    if (product != null){
                        //let productContainer = product.closest('.product-container');
                         //if (productContainer != null){
                             let errorInfo = product.querySelector('.add-to-basker-error-info');
                             if (errorInfo != null){
                                 errorInfo.classList.add('hidden');
                                 errorInfo.innerHTML = '';
                             }
                         //} 
                     }
                }
                
            } else {
                itemContainer.remove();
            }
            setTimeout(() => {
                hideGlobalLoader();
            }, "450");    
        });
    }

    async function deleteBasketItem(deleteButton){
        showGlobalLoader();
        let itemContainer = deleteButton.closest('.basket-item-container');
        let itemId = itemContainer.getAttribute('data-item-id');

        fetch('/remove-from-basket', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: itemId,
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
            rebuildBasket();
            itemContainer.remove();
            setTimeout(() => {
                hideGlobalLoader();
            }, "450");  
            let itemsToRemove = document.querySelectorAll('.basket-item-container[data-item-id="'+itemId+'"]');
            for(let i=0;i<itemsToRemove.length;i++){
                itemsToRemove[i].remove();
            }
            
            if (document.querySelectorAll('.basket-item-container[data-item-id]').length == 0){
                location.reload();
            }
        });

    }
</script>