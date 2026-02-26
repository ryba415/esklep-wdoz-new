@extends('layouts.front')

@section('content')

@include('loader')
<div class="bg-white flex flex-col overflow-hidden items-center pt-7 pb-[46px] px-20 max-md:px-5">
    <div class="w-[1280px] max-w-full">
        <h1 class="m-auto text-center pt-1 pb-4 sm:pt-8 pl-1 pr-1 text-xl sm:text-2xl font-bold max-w-[250px] sm:max-w-[100%] text-[#008641]">{!!$title!!}</h1>
Apteka Wracam do zdrowia funkcjonuje na rynku już od ponad 30 lat. W sprzedaży posiadamy między innymi artykuły higieniczne, dermokosmetyki przeznaczone do różnych potrzeb skóry, leki bez recepty, suplementy diety, sprzęt medyczny, jak również zioła i preparaty ziołowe. Można tutaj zamówić z wygodną dostawą do domu ciśnieniomierz, inhalator, wybrany test diagnostyczny, tabletki łagodzące objawy alergii, środki przeciwbólowe, żel na ukąszenia owadów, witaminy, minerały, elektrolity oraz wiele innych artykułów. Zapraszamy do zapoznania się z ofertą.
    </div>
</div>
@endsection