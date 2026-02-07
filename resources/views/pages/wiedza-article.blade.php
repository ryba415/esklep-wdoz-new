@extends('layouts.front')

@section('content')

@include('loader')

<div class="bg-white flex flex-col overflow-hidden items-center pt-7 pb-[46px] px-20 max-md:px-5">
    <div class="w-[1280px] max-w-full">

        <nav class="text-black text-sm font-semibold leading-[30px] max-md:max-w-full">
        @include('product/bread-crumbs')
        </nav>
        <article class="">
            <h1 class="flex w-full pt-0 pl-0 pr-0 text-xl sm:text-2xl font-bold text-[#008641]">{{$article->title}}</h1>
            
            <div class="w-[100%] md:w-[50%] inline-block float-left md:pr-7 ">
                <img class="w-[100%] mt-5 mb-5" src="https://esklep.wdoz.pl/uploads/media/default/0001/01/{{$article->image_name}}" alt="{{$article->title}}">
                <div class="text-sm text-gray-500 mb-5 md:mb-2">Data publikacji: {{$article->publish_date}}</div>
            </div>
            <div>
                {!!$article->content!!}
            </div>
        </article>    
       
    </div>
</div>
    
@endsection