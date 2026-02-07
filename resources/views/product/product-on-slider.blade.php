<div class="product-container bg-white rounded-2xl overflow-hidden hover:shadow-md transition p-4 flex flex-col h-full border border-[#ddd] min-h-[448px]">
    <!-- Obrazek produktu z sercem -->
    <div class="relative">
        <a href="/{{$product->slug}}" class="cursor-pointer">
            <img src="/uploads/images/product/{{$product->image_name}}" alt="BIFLORIN LGG" class="w-[200px] h-[200px] mx-auto" />
        </a>
        
        <div id="favorite-item-icon-{{$product->id}}" onclick="addProductToFavorite(this,{{$product->id}})" class="add-product-to-favorite bg-transparent cursor-pointer heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
            <svg class="z-20"  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <div class="heart-add-to-favorite-button hidden absolute z-10" onclick="this.classList.remove('animate'); void this.offsetWidth; this.classList.add('animate');">
                <div class="heart-add-to-favorite-animations"></div>
            </div>
        </div>
        
    </div>

    <div class="flex flex-col flex-grow">
        <a href="/{{$product->slug}}" class="text-lg font-semibold text-left capitalize text-[#3d3d3d] min-h-[64px]">
         {{$product->name}}
        </a> 
        <p class="w-full text-base text-left text-[#595959] min-h-[72px]">{{$product->brand}}@if(!empty($product->content)), {{$product->content}}@endif</p>
    </div>

    <!-- Podsumowanie (zawsze na dole) -->
    <div class="podsumowanie mt-auto flex flex-col justify-end items-center self-stretch gap-4">
        <div class="flex justify-start items-center self-stretch gap-2.5">
            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                <span class="text-[24px] font-semibold text-left text-[#eb442d]">{{ \App\Models\GlobalHelper::diplayPrice($product->price_gross) }} zł</span>
            </div>
            <div class="border flex flex-row h-10 rounded-lg overflow-hidden" >
                <button class="minus px-3 w-10 hover:bg-gray-100" aria-label="Zmniejsz ilość" onclick="executedecrementQuantity(this)">
                    <svg id="Warstwa_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 14 2">
                        <path style="stroke: #000;stroke-miterlimit: 10;" d="M.64,1h12.73"/>
                      </svg>
                </button>
                <input placeholder="0" type="text" class="product-quantity-input w-6 text-center outline-none" value="1" aria-label="Liczba sztuk">
                <button class="plus px-3 w-10 hover:bg-gray-100" aria-label="Zwiększ ilość" onclick="executeIncrementQuantity(this)">
                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                    </svg>
                </button>
            </div>
        </div>
        <button  onclick="addToBasket(this,{{$product->id}})" class="@if($product->availability <=0) opacity-50 cursor-not-allowed grayscale pointer-events-none @endif flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors" aria-label="Dodaj do koszyka">
            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
            </svg>
            <span class="text-lg font-bold text-white">@if($product->availability <=0) produkt niedostępny @else Do koszyka @endif </span>
        </button>
        <span class="add-to-basker-error-info hidden font-['Open_Sans'] text-sm text-[#d71921]"></span>
    </div>
</div>