<div class="flex flex-row border-doz-border border-b pb-5 mb-5 basket-item-container product-container" data-item-id="{{$item->id}}" data-product-id="{{$item->productId}}">  
    <div class="w-[96px] h-[96px] inline-block">
        @if (isset($item->images[0]) && $item->images[0]->image_name != null && $item->images[0]->image_name != '')
        <picture class="w-[96px] h-[96px] inline-block">
            <source srcset="https://esklep.wdoz.pl/uploads/images/product/{{str_replace('.jpg','.webp',$item->images[0]->image_name)}}" type="image/webp">
            <source srcset="https://esklep.wdoz.pl/uploads/images/product/{{$item->images[0]->image_name}}" type="image/jpeg"> 
            <img width="96" height="96" class="w-24 text-xs w-[96px] h-[96px] inline-block" src="{{Config::get('constants.admin-panel-url')}}uploads/images/product/{{$item->images[0]->image_name}}" alt="{{$item->name}} - {{$item->brand}}, {{$item->content}}">
        </picture>
        @endif    
    </div>
    <div class="flex w-full flex-col ">
        <div class="flex flex-row w-full justify-between pl-[10px] items-center">
            @if ($item->is_cosmetic == 1)
            <span class="text-xs leading-none	h-[28px] py-2 px-2 bg-wdoz-primaty-drog-10 rounded-lg">Produkt drogeryjny</span>
            @else
            <span class="text-xs leading-none	h-[28px] py-2 px-2 bg-wdoz-primary-10 rounded-lg">Produkt apteczny</span>
            @endif
            @if ($enalbeChange)
            <button class="flex hover:bg-wdoz-border stroke-black text-black px-2 py-2 rounded-lg delete-basket-item">
            <img class="w-5" src="/images/ico-delete.svg"> 
            </button>
            @endif
        </div>
        <h3 class="text-md font-semibold pl-[18px] mt-1">{{$item->name}}</h3>
        
        <p class="text-sm text-wdoz-text-gray pl-[18px]">{{$item->brand}}, {{$item->content}}</p>
        <div class="flex flex-row w-full mt-2 align-bottom items-center">
            <div class="w-full text-xl pl-[18px] text-wdoz-text-gray">
                <span class="basket-item-price-gross">{{$item->diplayPrice($item->valueGross )}}</span> zł<br>
                <span class="basket-item-price-quantity text-xs">{{$item->quantity }} szt.</span><br>    
                <div class="text-xs basket-item-unit-price-gross-container @if($item->quantity <= 1) hidden @endif">
                    (<span class="basket-item-unit-price-gross">{{$item->diplayPrice($item->valueGross / $item->quantity)}}</span> zł / szt.)
                </div>
            </div>
            @if ($enalbeChange)
            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                <button class="minus px-3 w-10 hover:bg-wdoz-border set-quantity-less">
                  <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20"></path></svg>
                </button>
                <input placeholder="0" type="text" class="price w-8 text-center outline-transparent transition-all set-quantity-input" value="{{$item->quantity}}" autocomplete="off">
                <button class="plus px-3 w-10 hover:bg-wdoz-border set-quantity-more">
                  <svg width="14" height="14" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 11h20M11 1v20"></path></svg>
                </button>
            </div>
            
            @endif
        </div> 
        <span class="mt-2 add-to-basker-error-info hidden font-['Open_Sans'] text-sm text-[#d71921]"></span>
    </div>
</div>