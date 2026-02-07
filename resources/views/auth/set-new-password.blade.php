@extends('auth.layouts')

@section('content')

<div class="login-container">
        <h1>Resetowanie hasła</h1>
        <div class="login-card">
            
                <form action="/change-password-sumbmit" method="post">
                    @csrf
                    <div class="repeat-password-container">
                        @if(session()->has('message'))
                            <div class="alert alert-success text-center">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        
                        <input name="hash" type="hidden" value="<?=$hash?>">
                        
                        <div class="inputconatiner">
                        <label for="new-password" class="col-md-4 col-form-label text-md-end text-start">Wpisz nowe hasło:</label>
                        <input type="password" class="form-control @error('new-password') is-invalid @enderror" id="new-password" name="new-password" value="{{ old('new-password') }}">
                          @if ($errors->has('new-password'))
                              <span class="text-danger">{{ $errors->first('new-password') }}</span>
                          @endif
                        </div>
                        
                        <div class="inputconatiner">
                        <label for="new-password-repeat" class="col-md-4 col-form-label text-md-end text-start">Powtórz nowe hasło:</label>
                        <input type="password" class="form-control @error('new-password-repeat') is-invalid @enderror" id="new-password-repeat" name="new-password-repeat" value="{{ old('new-password-repeat') }}">
                          @if ($errors->has('new-password-repeat'))
                              <span class="text-danger">{{ $errors->first('new-password-repeat') }}</span>
                          @endif
                        </div>
                        
                    </div>
                    <div class="button-container">
                        <input type="submit" class="standard-big-button standard-big-button-orange" value="Zmień hasło">
                    </div>
                    
                </form>
        </div>
</div>
    
@endsection