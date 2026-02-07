@extends('user.layouts')

@section('content')


    
<div class="row">
    <div class="col-md-12">
        <h2>Statystyki globalne</h2>
        
    </div>
</div>

<div class="row">
    <div class="col-md-6 pt-4 pb-4">
        <h3 class="fs-5">Użytkownicy - globalnie</h3>
        <p>Ilość zarejestrowanych użytkowników: <?=count($users)?></p>
        <p>Ilość użytkowników, którzy udzielili przynajmniej 10 odpowiedzi: <?=$usersWithAnswersCount?></p>
    </div>
</div>
                
@endsection
