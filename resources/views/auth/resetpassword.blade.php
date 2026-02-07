@extends('auth.layouts')

@section('content')

<div class="login-container">
        <h1>Reset hasła</h1>
        <div class="login-card">
            
                <form action="/reset-password-sumbmit" method="post">
                    @csrf
                    <div class="repeat-password-container">
                        @if(session()->has('message'))
                            <div class="alert alert-success text-center">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div class="inputconatiner">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Adres e-mail: </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                          @if ($errors->has('email'))
                              <span class="text-danger">{{ $errors->first('email') }}</span>
                          @endif
                        </div>
                        
                    </div>
                    <div class="button-container">
                        <input type="submit" class="standard-big-button standard-big-button-orange" value="Wyślij link do zresetowania hasła">
                    </div>
                    
                </form>
        </div>
</div>
    
@endsection