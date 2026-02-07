@extends('auth.layouts')

@section('content')

<div class="login-container">
        <h1>Rejestracja</h1>
        <div class="login-card">
                @if(session()->has('message'))
                    <div class="alert alert-success text-center">
                        {!! session()->get('message') !!}
                    </div>
                @endif
                <form action="{{ route('store') }}" method="post">
                    @csrf
                    <div class="inputconatiner">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><span class="red-star">*</span>Imie: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                    </div>
                    <div class="inputconatiner">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start"><span class="red-star">*</span>Adres e-mail: </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                    </div>
                    <div class="inputconatiner">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start"><span class="red-star">*</span>Hasło: </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                    </div>
                    <div class="inputconatiner">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start"><span class="red-star">*</span>Powtórz hasło:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="button-container">
                        <input type="submit" class="standard-big-button standard-big-button-orange" value="Zarejestruj">
                    </div>
                    
                </form>
        </div>
    
</div>
    
@endsection