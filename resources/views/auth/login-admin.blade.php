@extends('layouts.front')

@section('content')
<div class="flex justify-center">
    <div class="login-container flex justify-center p-10  flex-wrap left flex flex-col  rounded-b-md drop-shadow-lg p-5 mb-5 bg-white gap-4" style="max-width: 426px; width: 100%;">
            <h1 class="w-[100%] text-center">Logowanie</h1>
            <div class="login-card flex flex-wrap">

                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf

                        <div class="inputconatiner w-[100%] ">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Adres e-mail:</label>

                              <input type="email" class="form-control @error('email') is-invalid @enderror drop-shadow-lg border-1 border-solid block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded-lg border-1 border-wdoz-input-border appearance-none  focus:outline-none focus:ring-0  peer" id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{!! $errors->first('email') !!}</span>
                                @endif
                        </div>
                        <div class="inputconatiner w-[100%]">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Hasło:</label>

                              <input type="password" class="form-control @error('password') is-invalid @enderror drop-shadow-lg border-1 border-solid block px-2.5 pb-2.5 pt-4 w-full text-sm text-wdoz-text-gray bg-transparent rounded-lg border-1 border-wdoz-input-border appearance-none  focus:outline-none focus:ring-0  peer" id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif

                        </div>
                        <div class="remind-password-container w-[100%]">
                            <a href="/reset-password" class="underline text-sm font-light w-full text-center hover:text-wdoz-primary-900">Nie pamiętam hasła</a><br>
                        </div>
                        <div class="button-container">
                            <input type="submit" class="bg-wdoz-primary hover:bg-wdoz-primary-900 text-white mt-4 rounded p-3 shadow text-base  " value="Zaloguj">
                        </div>

                    </form>

            </div>

    </div>
</div> 
@endsection