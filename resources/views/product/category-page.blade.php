@extends('layouts.front')

@section('content')

@include('loader')

<div class="max-w-[1620px] mx-auto px-4 sm:px-6 lg:px-8 ">
  <nav class="text-black text-sm font-semibold pr-0 pt-5 pb-10  ">
      @include('product/bread-crumbs')
  </nav>

    <div class="flex flex-col lg:flex-row gap-10">
    <?php
    $itemLv0 = $category;
    $menuArray = \App\Models\GlobalHelper::getMenuTree();
    $existLevelMenu = false;
    if (isset($menuArray[$category->lvl+1])):
    foreach ($menuArray[$category->lvl+1] as $itemLv1):
    if ($itemLv1->parent_id == $itemLv0->id):
    $existLevelMenu = true; break; 
    endif;
    endforeach;
    endif;
    ?>
    @if ($existLevelMenu)
    <aside class="min-w-[300px] hidden lg:block">
      <nav aria-label="Kategorie produktów">
        <div class="border border-gray-200 bg-white rounded-lg shadow-sm">
          <ul class="list-none m-0 p-0" role="menu">
            
            @if (isset($menuArray[$category->lvl+1]))
            @foreach ($menuArray[$category->lvl+1] as $itemLv1)
            @if ($itemLv1->parent_id == $itemLv0->id)
            <?php $existNextLevel= false; ?>
            <li class="border-b border-gray-200" role="none">
                <div class="flex">
                  <button 
                    class="category-toggle flex justify-between items-center w-full h-[60px] px-4 text-base font-semibold text-gray-700 hover:text-[#eb442d] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#eb442d] focus-visible:ring-offset-2" 
                    data-open="false" 
                    aria-expanded="false" 
                    aria-controls="category-1"
                    role="menuitem">
                      <span><a href="{{$itemLv1->slug}}">{{$itemLv1->name}}</a></span>
                      
                        <?php if (isset($menuArray[$category->lvl+2])):
                        foreach ($menuArray[$category->lvl+2] as $itemLv2):
                        if ($itemLv2->parent_id == $itemLv1->id):
                        $existNextLevel = true; break; 
                        endif;
                        endforeach;
                        endif; ?>
                      @if ($existNextLevel)
                        <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="transform transition-transform duration-200" aria-hidden="true">
                          <path d="M 4 7 L 10 13 L 16 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                fill="none" />
                        </svg>
                      @endif
                  </button>
                </div>
                @if (isset($menuArray[$category->lvl+2]))
                @foreach ($menuArray[$category->lvl+2] as $itemLv2)
                @if ($itemLv2->parent_id == $itemLv1->id)
                <?php $existNextLevel2 = false; ?>
                <ul id="category-1" class="subcategory-container pl-4 pb-2 bg-white list-none m-0" role="menu"><!--hidden -->
                    
                    <li class="relative ml-2" role="none">
                      <ul class="list-none m-0 p-0" role="menu">
                        <li class="mt-1" role="none">
                          <button 
                            class="subcategory-toggle flex justify-between items-center w-full pl-4 pr-4 text-sm font-medium text-gray-600 hover:text-[#eb442d] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#eb442d] focus-visible:ring-offset-1" 
                            data-open="false" 
                            aria-expanded="false" 
                            aria-controls="subcategory-1"
                            role="menuitem">
                              <a href="{{$itemLv2->slug}}">{{$itemLv2->name}}</a>
                              <?php if (isset($menuArray[$category->lvl+3])):
                                foreach ($menuArray[$category->lvl+3] as $itemLv3):
                                if ($itemLv3->parent_id == $itemLv2->id):
                                $existNextLevel2 = true; break; 
                                endif;
                                endforeach;
                                endif; ?>
                              @if ($existNextLevel2)
                            <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="transform transition-transform duration-200" aria-hidden="true">
                              <path d="M 4 7 L 10 13 L 16 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
                            </svg>
                              @endif
                          </button>
                          <ul id="subcategory-1" class="sub-subcategory-container  pl-4 pb-1 list-none m-0" role="menu"> <!--hidden-->
                            @if (isset($menuArray[$category->lvl+3]))
                            @foreach ($menuArray[$category->lvl+3] as $itemLv3)
                            @if ($itemLv3->parent_id == $itemLv2->id)
                            <li role="none"><a href="{{$itemLv3->slug}}" class="flex items-center h-[40px] pl-4 text-xs text-gray-500 hover:text-[#eb442d] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-[#eb442d] focus-visible:underline" role="menuitem">{{$itemLv3->name}}</a></li>
                            @endif
                            @endforeach
                            @endif
                          </ul>
                        </li>
                      </ul>
                    </li>
                </ul>
                @endif
                @endforeach
                @endif
            </li>
            @endif
            @endforeach
            @endif

          </ul>
        </div>
      </nav>
    </aside>
    @else

    @endif

<div class="flex-1">

    <header class="mb-8">
        <h1 class="flex w-full pt-0 pl-0 pr-0 text-xl sm:text-2xl font-bold text-[#008641]">{{$category->name}}</h1>

      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200 pb-4">
        @if ($allProductsInCategoryCount == 0)
        <div class="text-sm text-gray-500">Nie znaleziono produktów</div>
        @else
        <div class="text-sm text-gray-500">Wyświetlanie {{$productsStartFor}}-{{$productsEndFor}} z {{$allProductsInCategoryCount}} produktów</div>
        @endif
        
        <div class="flex flex-wrap gap-2 ">
          <div class="relative">
            <select id="sort-select-options" aria-label="Sortuj produkty" autocomplete="off" class="appearance-none w-full border border-gray-300 rounded-md px-4 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#eb442d] focus:border-[#eb442d] cursor-pointer pr-10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#eb442d] focus-visible:outline-offset-1" aria-describedby="sort-description">
              <option value="best-sort">Sortuj: najlepsze dopasowanie</option>
              <option value="price-asc" @if($sortBy=='price-asc') selected @endif>Sortuj - cena: od najniższej</option>
              <option value="price-desc" @if($sortBy=='price-desc') selected @endif>Sortuj - cena: od najwyższej</option>
              <option value="alphabetically-asc" @if($sortBy=='alphabetically-asc') selected @endif>Sortuj - alfabetycznie: rosnąco</option>
              <option value="alphabetically-desc" @if($sortBy=='alphabetically-desc') selected @endif>Sortuj - alfabetycznie: malejąco</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
              <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="transform transition-transform duration-200">
                <path d="M 4 7 L 10 13 L 16 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
              </svg>
            </div>
            <span id="sort-description" class="sr-only">Wybierz sposób sortowania produktów na stronie</span>
          </div>
          
   
        </div>
      </div>
    </header>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
      
      @foreach ($products as $product)
        @include('product/product-on-list')
      @endforeach


    </div>

        @if ($allPagesCount > 1)
        <div class="m-10 flex justify-center">
          <nav aria-label="Paginacja" class="flex items-center space-x-2">

            @if ($currentPage > 1)
            <a href="{{$category->slug}}?page={{$currentPage-1}}" rel="prev" aria-label="Przejdź do poprzedniej strony" class="flex items-center justify-center w-10 h-10 rounded-md border-2 border-gray-200 text-gray-400 hover:text-[#38900D] hover:border-[#38900D] hover:bg-[#f0f8ee] transition-all duration-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only">Poprzednia strona</span>
            </a>
            @endif

            <div role="group" aria-label="Numeracja stron" class="flex space-x-2">

            @if ($currentPage > 2)

              <a href="{{$category->slug}}" aria-label="Przejdź do strony 1" class="flex items-center justify-center w-10 h-10 rounded-md bg-white border-2 border-gray-200 text-gray-700 font-medium hover:border-[#38900D] hover:text-[#38900D] hover:bg-[#f0f8ee] transition-all duration-200">
                1
              </a>
            @endif
            @if ($currentPage > 3)
            <span aria-hidden="true" class="flex items-center justify-center w-10 h-10 text-gray-400">
                ...
            </span>
            @endif

              @for ($i=$startPaginationNumber;$i<=$finishPaginationNumber;$i++)
              @if ($i==$currentPage)
              <a href="@if(!str_contains($category->slug,'?')) {{$category->slug}}?page={{$i}} @else {{$category->slug}}&page={{$i}} @endif" aria-current="page" aria-label="Strona 1, aktualna strona" class="flex items-center justify-center w-10 h-10 rounded-md bg-[#38900D] text-white font-medium shadow-sm hover:bg-[#2d7109] transition-all duration-200">
                {{$i}}
              </a>
              @else 
              <a href="@if(!str_contains($category->slug,'?')) {{$category->slug}}?page={{$i}} @else {{$category->slug}}&page={{$i}} @endif" aria-label="Przejdź do strony 3" class="flex items-center justify-center w-10 h-10 rounded-md bg-white border-2 border-gray-200 text-gray-700 font-medium hover:border-[#38900D] hover:text-[#38900D] hover:bg-[#f0f8ee] transition-all duration-200">
                {{$i}}
              </a>
              @endif

              @endfor

              @if ($allPagesCount > 2 && $currentPage < $allPagesCount - 1)
              @if ($currentPage < $allPagesCount - 2)
              <span aria-hidden="true" class="flex items-center justify-center w-10 h-10 text-gray-400">
                ...
              </span>
              @endif
              <a href="@if(!str_contains($category->slug,'?')){{$category->slug}}?page={{$allPagesCount}}@else{{$category->slug}}&page={{$allPagesCount}}@endif" aria-label="Przejdź do strony 8" class="flex items-center justify-center w-10 h-10 rounded-md bg-white border-2 border-gray-200 text-gray-700 font-medium hover:border-[#38900D] hover:text-[#38900D] hover:bg-[#f0f8ee] transition-all duration-200">
                {{$allPagesCount}}
              </a>
              @endif
            </div>
            @if ($currentPage < $allPagesCount)
            <a href="@if(!str_contains($category->slug,'?')){{$category->slug}}?page={{$currentPage+1}}@else{{$category->slug}}&page={{$currentPage+1}}@endif" rel="next" aria-label="Przejdź do następnej strony" class="flex items-center justify-center w-10 h-10 rounded-md border-2 border-gray-200 text-gray-400 hover:text-[#38900D] hover:border-[#38900D] hover:bg-[#f0f8ee] transition-all duration-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
              <span class="sr-only">Następna strona</span>
            </a>
            @endif
          </nav>
        </div>
        @endif

      </div>
    </div>
    
    <!-- Mobile filter drawer (ukryty domyślnie, pojawia się po kliknięciu przycisku "Filtry") -->
    <div class="md:hidden">
      <!-- Tu dodać mobilny drawer z filtrami, który otwiera się po kliknięciu przycisku "Filtry" -->
    </div>
  </div>


<script>
    
    document.getElementById("sort-select-options").addEventListener("change", (event) => {
        const url = new URL(window.location.href);

        // Ustaw lub zmodyfikuj parametr
        url.searchParams.set('sort-by', document.getElementById("sort-select-options").value);

        // Przeładuj stronę z nowym URL-em
        window.location.href = url.toString();
    });
</script>


@endsection