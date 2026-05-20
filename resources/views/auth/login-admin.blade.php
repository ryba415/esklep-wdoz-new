@extends('layouts.front')

@section('content')
<div class="flex justify-center">
    <div class="login-container flex justify-center p-10  flex-wrap left flex flex-col  rounded-b-md drop-shadow-lg p-5 mb-8 bg-white gap-4 mt-8" style="max-width: 426px; width: 100%;">
            <h1 class="w-[100%] text-center text-lg">Logowanie - admin panel</h1>
            @if ($errors->has('email'))
            <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 ml-3 mr-5 md:ml-0 md:mr-0 text-center p-1">
                <span class="text-danger text-center text-red-700 p-3 pl-5 pr-5 text-sm">{!! $errors->first('email') !!}</span>
            </div>
            @endif
            @if ($errors->has('password'))
                <div class="bg-red-200 rounded-lg mb-5 border-solid border-red-700 border-2 ml-3 mr-5 md:ml-0 md:mr-0 text-center p-1">
                    <span class="text-danger  text-center text-red-700 p-3 pl-5 pr-5 text-sm">{!! $errors->first('password') !!}</span>
                </div>    
            @endif
            <div class="login-card flex flex-wrap">

                    <form action="{{ route('authenticate') }}" method="post" class="w-full">
                        @csrf

                        <div class="inputconatiner w-full mb-6">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Adres e-mail:</label>

                              <input style="border: solid 1px gray;" type="email" class="form-control @error('email') is-invalid @enderror drop-shadow-lg border-1 border-solid block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded-lg border-1 border-wdoz-input-border appearance-none  focus:outline-none focus:ring-0  peer w-full" id="email" name="email" value="{{ old('email') }}">
                                
                        </div>
                        <div class="inputconatiner w-full">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Hasło:</label>

                              <input style="border: solid 1px gray;" type="password" class="form-control @error('password') is-invalid @enderror drop-shadow-lg border-1 border-solid block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded-lg border-1 border-wdoz-input-border appearance-none  focus:outline-none focus:ring-0  peer w-full"  id="password" name="password">
                                

                        </div>
                        <!--<div class="remind-password-container w-[100%]  mb-6">
                            <a href="/reset-password" class="underline text-sm font-light w-full text-center hover:text-wdoz-primary-900">Nie pamiętam hasła</a><br>
                        </div>-->
                        <div class="button-container mt-6">
                            <input type="submit" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base w-full" value="Zaloguj">
                        </div>

                    </form>

            </div>

    </div>
</div> 
@endsection