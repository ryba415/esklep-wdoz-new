@extends('user.layouts')

@section('content')

<div class="buy-now-description-container">
    <h1>Wykup dostęp do pełnej wersji systemu (wersji PRO)</h1>
    <p class="info-text">Po wykupieniu wersji PRO otrzymasz dostęp do wszystkich <strong>kazusów</strong> w naszej bazie - w chwili obecnej jest ich: <strong>{{ $legalTasksCount }}</strong></p>
    <p class="info-text">oraz wszystkich <strong>zadań testowych</strong> - w chwili obecnej jest ich: <strong>{{ $legalTestsCount }}</strong></p>
    <p class="info-text">Twój dostęp będzie ważny przez: <strong>{{ $accesDuration }} dni</strong><br></p>
    <p class="info-text">Jednorazowy koszt wykupienia konta PRO to: <strong>{{ $accesPrice }} zł</strong> brutto</p>
    <div class="buy-pro-button-cntainer">
        <a class="standard-button standard-big-button-orange" href="/buy-pro-version-form">Chcę kupić wersję PRO</a>
    </div>
</div>
    
@endsection