@extends('emails.standard-mail-template')

@section('content')

    Dzień Dobry, 
    <br><br>
    Dziękujemy za rejestrację konta. 
    <br>
    Aby aktywować konto kliknij w link poniżej:
    <br><br>
    <a href="{{$activateLink}}">{{$activateLink}}</a><br>
    
@endsection