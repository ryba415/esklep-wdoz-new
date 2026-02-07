@extends('layouts.front')

@section('content')

@include('loader')

<input type="hidden" id="single-login-type" value="1">

<div class="login-container">
    <div class="flex flex-col md:flex-row w-full gap-5 items-center justify-center pt-10 pb-8">
        @include('auth/login-form')
        <div class="right rounded-b-lg drop-shadow-lg flex  w-full gap-9 flex-col md:self-start " style="max-width: 426px; height: 100%;   ">
            @include('auth/register-form')
        </div>    
    </div>
</div>
    
@endsection