@extends('layouts.front')

@section('content')

@include('loader')

<div class="max-w-[1620px] mx-auto px-4 sm:px-6 lg:px-8 ">

    <div class="flex flex-col lg:flex-row gap-10">

    <div class="flex-1">

        <header class="mb-10 mt-10">
            <h1 class="flex w-full pt-0 pl-0 pr-0 text-xl sm:text-2xl font-bold text-[#008641]">Wiedza farmaceutyczna</h1>

          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gray-200 pb-4">

          </div>
        </header>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
      
      @foreach ($articles as $article)

      <div class="justify-between flex-[1 1 0] produkt flex flex-col justify-start items-center self-stretch flex-grow relative gap-3 p-5 rounded-[20px] bg-white border border-[#ddd]">
            <a href="/wiedza-farmaceutyczna/{{$article->slug}}" class="w-full flex justify-center flex-grow-0 flex-shrink-0">
                <img src="/uploads/media/default/0001/01/{{$article->image_name}}" class="flex-grow-0 flex-shrink-0 w-[200px] h-[200px] " />
            </a>
            
            <a href="/wiedza-farmaceutyczna/{{$article->slug}}" class="self-stretch flex-grow-0 flex-shrink-0 text-lg font-semibold text-left capitalize text-[#3d3d3d]">{{$article->title}}</a> 
            @if ($article->category != null && $article->category != '')
            <div class="px-3 py-1 bg-[rgba(254,215,0,1)] transition-colors text-base text-black text-sm rounded-lg">
                {{$article->category}}
            </div>
            @endif
            <div class="flex flex-col self-stretch flex-grow gap-4 items-start justify-start max-h-[215px] overflow-hidden">
                <span class="add-to-basker-error-info hidden font-['Open_Sans'] text-sm text-[#d71921]"></span>
                <p>{!!strip_tags($article->lead)!!}</p>
            </div>
            <div></div>
            <div class="w-[100%]">
                <a href="/{{$article->slug}}">
                <button class="flex justify-center items-center w-full h-12 gap-2 px-2.5 rounded-xl bg-[#eb442d] hover:bg-[#d03e26] transition-colors">
                    <p class="flex-grow-0 flex-shrink-0 text-lg font-bold text-left text-white">czytaj więcej</p>
                </button>
                </a>    
            </div>    
        </div>
        
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
</div>



@endsection