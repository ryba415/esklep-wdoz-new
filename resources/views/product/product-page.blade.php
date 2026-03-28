@extends('layouts.front')

@section('content')

@include('loader')

<div class="bg-white flex flex-col overflow-hidden items-center pt-7 pb-[46px] px-20 max-md:px-5">
    <div class="w-[1280px] max-w-full">
        <nav class="text-black text-sm font-semibold leading-[30px] max-md:max-w-full">
        @include('product/bread-crumbs')
        </nav>
            <div class="product-container flex w-full gap-[40px_68px] flex-wrap mt-[60px] max-md:max-w-full max-md:mt-10">
                <div class="flex min-w-60 flex-col items-center justify-center w-[450px] p-2.5 max-md:max-w-full">
                    <img src="/uploads/images/product/{{$product->image_name}}" alt="{{$product->name}}" class="aspect-[1] object-contain w-[412px] max-w-full"></div>
                    <div class="min-w-60 flex-1 shrink basis-5 max-md:max-w-full">
                        <div class="w-full font-normal max-md:max-w-full">
                            <h1 class="text-[#2c2c2c] text-3xl font-semibold max-md:max-w-full">{{$product->name}}</h1>
                            <div class="text-[#707070] text-lg leading-none mt-6 max-md:max-w-full">{{$product->brand}}@if(!empty($product->content)), {{$product->content}}@endif</div>
                            <div class="w-full text-sm text-black leading-[30px] mt-6 max-md:max-w-full">
                                <div class="max-md:max-w-full">
                                    <span class="font-['Open_Sans']">Producent: </span>
                                    <span class="font-['Open_Sans'] font-semibold">{{$product->producent}}</span>
                                </div>
                                <div class="max-md:max-w-full">
                                    <span class="font-['Open_Sans']">Typ: </span>
                                    <span class="font-['Open_Sans'] font-semibold">{{$product->type_of_preparation}}</span>
                                </div><div class="max-md:max-w-full">
                                    <span class="font-['Open_Sans']">Postać i dawka: </span>
                                    <span class="font-['Open_Sans'] font-semibold">{{$product->brand}}</span>
                                </div>
                                <div class="max-md:max-w-full">
                                    <span class="font-['Open_Sans']">Opakowanie: </span>
                                    <span class="font-['Open_Sans'] font-semibold">{{$product->content}}</span>
                                </div>
                                <div class="max-md:max-w-full">
                                    <span class="font-['Open_Sans']">Dostępność: </span>
                                    <span class="font-['Open_Sans'] font-semibold @if($product->availability > 0) text-[#38900d] @else text-[#d71921] @endif">@if($product->availability > 0) Dostępny @else Ten produkt właśnie robi sobie kawę i zaraz wróci na półkę. @endif</span>
                                </div>
                            </div>
                        </div>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4 mt-5">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    {{ \App\Models\GlobalHelper::diplayPrice($product->price_gross)}} zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                
                                <button class="minus px-3 w-10 hover:bg-wdoz-border" onclick="executedecrementQuantity(this)">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                             
                                <input placeholder="0" type="text" class="product-quantity-input price w-6 text-center outline-transparent transition-all" value="1">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border" onclick="executeIncrementQuantity(this)">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class=" flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button onclick="addToBasket(this,{{$product->id}})" class="@if($product->availability <=0) opacity-50 cursor-not-allowed grayscale pointer-events-none @endif flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="pointer-events-none flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">@if($product->availability <=0) produkt niedostępny @else Do koszyka @endif</p>
                        </button>
                        <span class="add-to-basker-error-info hidden font-['Open_Sans'] text-[#d71921]"></span>
                    </div>


                    @if ($product->short_expiration_stock > 0)
                        <div
                            class="short-box mt-5 w-full overflow-hidden rounded-2xl border-[1px] border-[#005529] bg-[#008641]/10"
                            data-max="{{ $product->short_expiration_stock }}"
                            data-expiration-date="{{ $product->short_expiration_date }}"
                        >
                            {{-- Header --}}
                            <div class="bg-[#005529] px-4 py-3">
                            <p class="text-base font-semibold leading-snug text-white">
                                Możesz kupić ten pełnowartościowy produkt z krótszym terminem ważności.
                            </p>
                            </div>
                            <div class="px-4 py-4 xl:py-3">
                            <div class="text-sm text-gray-900 py-4">
                                <div class="flex flex-col gap-1 xl:flex-row xl:items-center xl:gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="font-normal">Data ważności:</span>
                                    <span class="font-semibold">{{ $product->short_expiration_date ?? '' }}</span>
                                </div>

                                <span class="hidden xl:inline-block text-gray-700">|</span>

                                <div class="flex items-center gap-2">
                                    <span class="font-normal">Ilość dostępnych:</span>
                                    <span class="font-semibold">{{ $product->short_expiration_stock }}</span>
                                </div>
                                </div>
                            </div>

                        {{-- Controls --}}
                        <div class="mt-4 flex flex-col gap-4 xl:mt-3 xl:flex-row xl:items-center xl:justify-between xl:gap-6">
                        <div
                            class="short-product-container flex w-full items-center justify-between gap-4 xl:w-auto xl:gap-24">
                            {{-- Price --}}
                            <p class="shrink-0 text-[28px] font-semibold leading-none text-[#eb442d] xl:text-[32px]">
                            {{ \App\Models\GlobalHelper::diplayPrice($product->short_price_gross) }} zł
                            </p>

                            {{-- Quantity --}}
                            <div class="flex h-11 items-center overflow-hidden rounded-xl border border-[#005529]/40 bg-white">
                            <button
                                type="button"
                                class="minus flex h-11 w-12 items-center justify-center hover:bg-gray-100 transition-colors"
                                onclick="shortDecrementQuantity(this)"
                                aria-label="Zmniejsz ilość"
                            >
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-[#959595]">
                                <path d="M1 .9h20" stroke-width="2" stroke-linecap="round"></path>
                                </svg>
                            </button>

                            <input
                                placeholder="0"
                                type="text"
                                class="short-quantity-input h-11 w-14 border-l border-r border-[#005529]/20 text-center text-base font-semibold leading-none outline-none"
                                value="1"
                                inputmode="numeric"
                            />

                            <button
                                type="button"
                                class="plus flex h-11 w-12 items-center justify-center hover:bg-gray-100 transition-colors"
                                onclick="shortIncrementQuantity(this)"
                                aria-label="Zwiększ ilość"
                            >
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M1 6.96H14" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                            </div>
                        </div>
                        <p class="short-stock-info hidden mt-2 text-sm font-semibold text-[#d71921]"></p>

                        {{-- CTA (mobile: full width below, desktop: button on the right) --}}
                        <button
                            type="button"
                            onclick="addToBasket(this,{{ $product->id }})"
                            class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-[#eb442d] px-4 font-bold text-white hover:bg-[#d03e26] transition-colors xl:w-[240px]"
                        >
                            <svg width="26" height="26" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="pointer-events-none">
                            <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                            <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                            <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <span>Do koszyka</span>
                        </button>
                        </div>
                        <span class="add-to-basker-error-info hidden mt-2 text-sm font-semibold text-[#d71921]"></span>
                        </div>
                    </div>
                    @endif


                    </div>
                </div>
                <div class="w-full text-black mt-10 max-md:max-w-full">




  <!--<section class="overflow-hidden flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-5 py-[60px]   ">
    <div class="flex w-full pb-6  ">
        <div class=" items-center justify-between w-full flex flex-col lg:flex-row gap-3 ">
            <h2 class="text-2xl font-bold text-gray-900">Oferta Specjalna</h2>
            <div class="flex-grow mx-5">
                <div class="h-px bg-gray-300 w-full"></div>
            </div>
            <a href="#" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-green-600 hover:bg-green-700 text-white font-medium transition-colors">
                Zobacz wszystkie
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
    <div class="flex flex-row w-full max-w-[1280px] gap-5 overflow-hidden">
    

        <div class="slider-container relative flex flex-grow justify-start items-center flex-shrink-0 overflow-hidden touch-pan-y " data-slider-id="slider1" style="border: none;">
            <div class="slider-track flex transition-transform duration-300 ease-in-out gap-5 max-w-[1280px]">
    
                
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>                     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>                     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>                     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>                     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>                     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>                     
                <div class="produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd] min-w-[280px] lg:min-w-[305px]">
                    <div class="heart coursor-pointer flex flex-col justify-center items-center flex-grow-0 flex-shrink-0 h-[40px] w-[40x] absolute right-[12px] top-[12px] gap-2.5 px-[7px] py-1 rounded bg-white">
                        <svg  width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-7 h-7 relative" preserveAspectRatio="none">
                            <path d="M14.2754 9.5686C11.9421 4.09176 3.77539 4.67509 3.77539 11.6751C3.77539 18.6752 14.2754 24.5087 14.2754 24.5087C14.2754 24.5087 24.7754 18.6752 24.7754 11.6751C24.7754 4.67509 16.6087 4.09176 14.2754 9.5686Z" stroke="#353535" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </div>
                    <a href="" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                        <img src="assets/zdjecie.png" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] object-none" />
                    </a>
                    <a href="" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">BIFLORIN LGG BABY data ważności 30-07-2025</a> 
                    <p class="flex-grow-0 flex-shrink-0 w-full text-base text-left text-[#595959]">krople, 5 ml</p>
                    <div class="flex flex-col justify-end items-center self-stretch flex-grow gap-4">
                        <div class="flex justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-2.5">
                            <div class="flex flex-col justify-center items-start flex-grow h-11 relative gap-1">
                                <p class="flex-grow-0 flex-shrink-0 text-[24px] lg:text-[32px] font-semibold text-left text-[#eb442d]">
                                    33,54 zł
                                </p>
                            </div>
                            <div class="border flex flex-row h-10 rounded-lg overflow-hidden grow-0 shrink-0 basis-auto" >
                                <button class="minus px-3 w-10 hover:bg-wdoz-border">
                                    <g clip-path="url(#clip0_2091_1471)"><path d="M1 7H14" stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                    <defs><clipPath id="clip0_2091_1471"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                    </clipPath>
                                    </defs>
                                    </svg>
                                <svg width="14" height="2" viewBox="0 0 22 2" xmlns="http://www.w3.org/2000/svg" class="stroke-black"><path d="M1 .588h20" ></path></svg>
                                </button>
                                <input placeholder="0" type="text" class="price w-6 text-center outline-transparent transition-all" value="3">
                                <button class="plus px-3 w-10 hover:bg-wdoz-border">
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-3.5 h-3.5 relative" preserveAspectRatio="none">
                                        <g clip-path="url(#clip0_2091_1476)"><path d="M7.5 0.5V13.5" stroke="#EB442D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M1 6.95996H14" stroke="#EB442D"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g>
                                        <defs><clipPath id="clip0_2091_1476"><rect width="14" height="14" fill="white" transform="translate(0.5)"></rect></clipPath></defs>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg" class="flex-grow-0 flex-shrink-0 w-[43px] h-11 relative" preserveAspectRatio="none">
                                <path d="M6.771 8.25H10.6941C11.3945 8.25 11.7447 8.25 12.0075 8.44076C12.2703 8.63152 12.3788 8.96452 12.5957 9.63052L13.9377 13.75" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M31.8543 32.0834H14.901C13.6428 32.0834 13.0137 32.0834 12.7142 31.6709C12.4148 31.2583 12.6096 30.6602 12.9993 29.4639L13.0382 29.3444C13.4721 28.0124 13.6891 27.3464 14.2146 26.9649C14.7402 26.5834 15.4406 26.5834 16.8415 26.5834H26.4793" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M27.7147 26.5833H18.3904C17.1002 26.5833 16.4551 26.5833 15.9518 26.2485C15.4485 25.9136 15.1993 25.3186 14.7009 24.1286L12.0959 17.9089C11.3083 16.0284 10.9145 15.0882 11.3597 14.4191C11.8048 13.75 12.8242 13.75 14.863 13.75H32.1176C34.394 13.75 35.5322 13.75 35.9669 14.4907C36.4017 15.2315 35.8467 16.2252 34.7368 18.2127L31.207 24.5336C30.6488 25.5332 30.3696 26.033 29.9009 26.3082C29.4321 26.5833 28.8596 26.5833 27.7147 26.5833Z" stroke="white" stroke-width="1.5" stroke-linecap="round"></path>
                                <ellipse cx="30.9582" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                                <ellipse cx="16.6252" cy="36.6667" rx="1.79167" ry="1.83333" stroke="white" stroke-width="1.5" stroke-linecap="round"></ellipse>
                            </svg>
                            <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">Do koszyka</p>
                        </button>
                    </div>
                </div>      
        
            </div>
        </div>
    </div>
    
   
    <div class="slider-navigation flex justify-center items-center mt-8 gap-4" data-slider-id="slider1">
        <button class="slider-prev flex justify-center items-center p-3  w-10 h-10 rounded-sm bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309] ">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="slider-next flex justify-center items-center p-3 w-10 h-10 rounded-sm bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
    </div>
</section> -->
 
                    <section class="w-full max-md:max-w-full">
                        @if (!empty($product->description ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Opis</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->description }}</p>
                        @endif
                        @if (!empty($product->composition ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Skład</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->composition }}</p>
                        @endif
                        @if (!empty($product->active_substance) && $product->active_substance != null )
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Substancje czynne</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->active_substance }}</p>
                        @endif
                        @if (!empty($product->action ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Działanie</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->action}}</p>
                        @endif
                        @if (!empty($product->indication ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Wskazania</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->indication}}</p>
                        @endif
                        @if (!empty($product->dosage ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Dawkowanie</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->dosage}}</p>
                        @endif
                        @if (!empty($product->contraindication ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Przeciwwskazania</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->contraindication}}</p>
                        @endif
                        
                        
                        @if (!empty($product->warnings ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Ostrzeżenia i środki ostrożności</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->warnings}}</p>
                        @endif
                        
                        @if (!empty($product->comments ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Uwagi</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->comments}}</p>
                        @endif
                        
                        @if (!empty($product->responsible_entity) || !empty($product->responsible_entity_adress) || !empty($product->responsible_entity_contact ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Podmiot odpowiedzialny</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->responsible_entity}}</p>
                            <p class="text-[15px] font-normal leading-[22px] mt-1 max-md:max-w-full">{{ $product->responsible_entity_adress}}</p>
                            <p class="text-[15px] font-normal leading-[22px] mt-1 max-md:max-w-full">{{ $product->responsible_entity_contact}}</p>
                        @endif
                        
                        @if (!empty($product->producent) || !empty($product->producent_adres) || !empty($product->producent_kontakt ))
                            <h2 class="text-lg font-semibold leading-loose max-md:max-w-full mt-8">Producent</h2>
                            <p class="text-[15px] font-normal leading-[22px] mt-2 max-md:max-w-full">{{ $product->producent}}</p>
                            <p class="text-[15px] font-normal leading-[22px] mt-1 max-md:max-w-full">{{ $product->producent_adres}}</p>
                            <p class="text-[15px] font-normal leading-[22px] mt-1 max-md:max-w-full">{{ $product->producent_kontakt}}</p>
                        @endif
                    
                    </section>
             
       
                        </div>
                        </div></div>
    
@endsection