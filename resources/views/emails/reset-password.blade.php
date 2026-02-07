@extends('emails.standard-mail-template')

@section('content')

    Dzień Dobry, 
    <br>
    <br>
    link do resetu hasła jest ważny przez 2h. 
    <br>
    Aby zresetować hasło kliknij w link poniżej:
    <br><br>
    <a href="{{$activateLink}}">{{$activateLink}}</a><br>
    
@endsection