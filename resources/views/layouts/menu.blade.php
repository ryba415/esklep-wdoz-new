
<div id="menu-overlay" class="fixed inset-0 z-50 bg-black/80 animate-in fade-in-0 hidden"></div>

    <?php $menuArray = \App\Models\GlobalHelper::getMenuTree() ?>
    <div id="menu-panel" role="dialog" class="fixed z-50 gap-2 bg-background shadow-lg transition ease-in-out inset-y-0 right-0 h-full w-3/4 border-l animate-in slide-in-from-right sm:max-w-sm p-0 hidden">
        <div class="h-full bg-white">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-[rgba(56,144,13,1)]">Menu</h2>
            </div>
            <div class="p-4 overflow-auto">
               
                <div class=" ">
                   
                    <ul class="space-y-1">
                        @foreach ($menuArray[0] as $itemLv0)
                        <li class="relative">
                            <div class="category-item flex items-center justify-between p-2 hover:bg-gray-100 rounded-md transition-colors cursor-pointer">
                                <a @if (str_contains($itemLv0->slug,'https://'))target="_blank"@endif  href="@if (!str_contains($itemLv0->slug,'https://'))/@endif{{ $itemLv0->slug }}">
                                <span class="text-gray-800">{{$itemLv0->name}}</span>
                                </a>
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon transform transition-transform duration-300 ease-in-out h-4 w-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                            <div class="submenu transform transition-all duration-300 ease-in-out h-0 overflow-hidden pl-6 py-0 space-y-1">
                                <ul>@foreach ($menuArray[1] as $itemLv1)
                                    @if ($itemLv1->parent_id == $itemLv0->id)
                                    <li class="p-2 text-sm text-gray-700 hover:bg-gray-50 rounded cursor-pointer"><a href="/{{ $itemLv1->slug }}">{{$itemLv1->name}}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const categoryItems = document.querySelectorAll('.category-item');
                            categoryItems.forEach(item => {
                                item.addEventListener('click', function() {
                                    const submenu = this.nextElementSibling;
                                    const arrow = this.querySelector('.arrow-icon');
                                    const isOpen = submenu.classList.contains('h-auto');
                                    document.querySelectorAll('.submenu.h-auto').forEach(openSubmenu => {
                                        openSubmenu.classList.remove('h-auto', 'py-1');
                                        openSubmenu.classList.add('h-0', 'py-0');
                                    });
                                    document.querySelectorAll('.arrow-icon.rotate-90').forEach(rotatedArrow => {
                                        rotatedArrow.classList.remove('rotate-90');
                                    });
                                    if (!isOpen) {
                                        submenu.classList.remove('h-0', 'py-0');
                                        submenu.classList.add('h-auto', 'py-1');
                                        arrow.classList.add('rotate-90');
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        <button id="close-menu" type="button" class="absolute right-4 top-4 rounded-sm opacity-70 transition-opacity hover:opacity-100 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
            <span class="sr-only">Close</span>
        </button>
    </div>

    <div class="hiddent-classet-to-tailwind hidden aspect-[1] object-contain w-[52px] self-stretch my-auto"></div>
     <nav id="header-top-desktop-menu" class=" bg-white min-h-[186px] w-full pt-3 border-t-4 border-[rgba(56,144,13,1)] px-[5px] relative border-b  hidden lg:flex ">
            <div id="desktop-category-menus" class="flex w-full flex-wrap justify-between">
                
                @foreach ($menuArray[0] as $itemLv0)
                <div data-menu-id="{{$itemLv0->id}}" class="desktop-category-container flex flex-col items-center flex-1 shrink basis-[0%] pt-5 justify-start cursor-pointer transition-all category-item"> <!---->
                    <a class="flex flex-col justify-center text-center hover:opacity-90 " @if (str_contains($itemLv0->slug,'https://'))target="_blank"@endif  href="@if (!str_contains($itemLv0->slug,'https://'))/@endif{{ $itemLv0->slug }}" >
                        
                        <div @if (isset($itemLv0->color) ) style="background-color: {{$itemLv0->color}}" @endif class=" m-auto @if (isset($itemLv0->color) ) bg-[#{{$itemLv0->color}}] @else bg-[#d8f0e0] @endif  flex min-h-20 w-20 items-center gap-2.5 justify-center h-20 rounded-xl hover:shadow-md transition-shadow">
                            @if (isset($itemLv0->icon) )
                            {!! $itemLv0->icon !!}
                            @endif
                        </div>
                        <div class="pl-1 pr-1 text-[rgba(61,61,61,1)] text-sm 2xl:text-base font-medium leading-none text-center mt-3 hover:text-[#EB442D] transition-colors">
                            {{$itemLv0->name}}
                        </div>
                        
                    </a>
                    <div class="mega-menu-dektop-dropdown w-full absolute left-0 z-50 bg-gray-100 shadow-lg border-t border-gray-200 p-5  mt-5 top-[160px]" data-menu-category="{{ $itemLv0->id }}" id="mega-menu-container-{{ $itemLv0->id }}" style="z-index: 1000; background-color: #F7F7F7;" >
                        <div class="mega-menu-sub-container ss max-w-[1700px] mx-auto" data-mega-menu>
                            <div class="flex flex-wrap -mx-2 justify-around">
                            @foreach ($menuArray[1] as $itemLv1)
                            @if ($itemLv1->parent_id == $itemLv0->id)
                                <div class="subcategory w-1/5 2xl:w-1/6  px-3 mb-6 mt-1">
                                    <h3 class="font-semibold font-medium text-gray-800 mb-3 border-b pb-2"><a href="/{{ $itemLv1->slug }}">{{$itemLv1->name}}</a></h3>
                                    <ul class="space-y-2">
                                    @foreach ($menuArray[2] as $itemLv2)
                                    @if ($itemLv2->parent_id == $itemLv1->id)
                                        <li><a href="/{{ $itemLv2->slug }}" class="text-sm text-gray-600 hover:text-black">{{$itemLv2->name}}</a></li>
                                    @endif
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                    
                    
                </div> 
                @endforeach

            </div>
            
            @foreach ($menuArray[0] as $itemLv0)
            <div class="w-full absolute left-0 z-50 hidden bg-gray-100 shadow-lg border-t border-gray-200 p-5  mt-5 top-[150px]" data-menu-category="{{ $itemLv0->id }}" id="mega-menu-container-{{ $itemLv0->id }}" style="z-index: 1000; background-color: #F7F7F7;" >
                <div id="mega-menu-sub-container-{{ $itemLv0->id }}" class="mega-menu-sub-container hidden max-w-[1200px] mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                        @foreach ($menuArray[1] as $itemLv1)
                        @if ($itemLv1->parent_id == $itemLv0->id)
                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">{{$itemLv1->name}}</h3>
                            <ul class="space-y-2">
                                @foreach ($menuArray[2] as $itemLv2)
                                @if ($itemLv2->parent_id == $itemLv1->id)
                                <li><a href="/{{$itemLv2->slug}}" class="text-sm text-gray-600 hover:text-black">{{$itemLv2->name}}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>    
            </div>
            @endforeach

            <div class="w-full absolute left-0 z-50 hidden bg-gray-100 shadow-lg border-t border-gray-200 p-5  mt-5 top-[150px]" id="mega-menu-container" style="z-index: 1000; background-color: #F7F7F7;" >

                <div id="zdrowie-menu" class="hidden max-w-[1200px] mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Alergia</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Preparaty do nosa</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Preparaty do oczu</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Preparaty doustne</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>

                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Ból</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Gardła i chrypa</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Głowy i migrena</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Menstruacyjny</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>

                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Choroba lokomocyjna</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Tabletki przeciw chorobie lokomocyjnej</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>

                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Dermatologia</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Blizny i rozstępy</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Brodawki</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Grzybica</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>

                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Przeziębienie i grypa</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Ból gardła i chrypa</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Ból i gorączka</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>

                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Układ krążenia</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Cholesterol</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Nadciśnienie</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>
>
                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Układ krążenia</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Cholesterol</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Nadciśnienie</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>

                        <div class="subcategory w-1/5 px-2 mb-5">
                            <h3 class="font-medium text-gray-800 mb-3 border-b pb-2">Układ krążenia</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Cholesterol</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Nadciśnienie</a></li>
                                <li><a href="#" class="text-sm text-gray-600 hover:text-black">Wszystkie kategorie</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="ciaza-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                      
                    </div>
                </div>
                
                <div id="dziecko-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                       
                    </div>
                </div>

                <div id="higiena-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                     
                    </div>
                </div>

                <div id="tryb-zycia-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                       
                    </div>
                </div>

                <div id="sprzet-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                       
                    </div>
                </div>

                <div id="bestsellery-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                       
                    </div>
                </div>

                <div id="nowosci-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                    
                    </div>
                </div>

                <div id="krotkie-daty-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                       
                    </div>
                </div>

                <div id="wiedza-menu" class="hidden w-full mx-auto" data-mega-menu>
                    <div class="flex flex-wrap -mx-2">
                       </div>
                </div>
            </div> 

        </nav>
 