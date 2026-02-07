@extends('emails.standard-mail-template')

@section('content')

    Dzień Dobry, 
    <br><br>
    Aby zresetować hasło kliknij w link poniżej:
    <br><br>
    <a href="{{$activateLink}}">{{$activateLink}}</a><br>
    
@endsection