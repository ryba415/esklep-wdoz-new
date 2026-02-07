@extends('layouts.front')

@section('content')
<div class="text-center p-4 pt-5 pb-5 mt-10 mb-10">
@if ($status)
<div><span class="text-xl leading-none	h-[28px] py-2 px-2 bg-wdoz-primary-10 rounded-lg">{{$message}}</span></div>
@else
<div class="inline-block bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 ml-3 mr-5 md:ml-0 md:mr-0">
    <ul class="text-red-700 p-3 pl-5 pr-5 text-sm">
        <li>{{$message}}</li>
    </ul>
</div>
@endif
</div>

@endsection