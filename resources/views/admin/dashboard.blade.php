@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">

<div class="all-content-big cms-list-container admin-dashboard-container">
    <p>Witaj  <strong>{{Auth::user()->email}}</strong> !<br>
        w panelu administracyjnym</p>
    
    <h2>Zmówienia</h2>
    <a href="/panel/orders-list" class="admin-dashboard-link">Lista zamówień<br><span>zamówienia użytkowników</span></a>
    
    <h2>Strona główna</h2>
    <a href="/panel/slides/" class="admin-dashboard-link"> Slider<br><span>Sliderem na stronie głównej</span></a>
    
    <h2>Wiedza</h2>
    <a href="/panel/articles/" class="admin-dashboard-link">Artykuły<br><span>Artykułami w zakładce wiedza</span></a>
    
    <a href="/panel/articlesCategory/" class="admin-dashboard-link">Kategorie artykułów<br><span>Kategorie artykułów w zakładce wiedza</span></a>
    
    <h2>Użytkownicy</h2>
    
    <a href="/panel/newsletter/" class="admin-dashboard-link">Newsletter<br><span>Adresy e-mail zapisane do newletera</span></a>
    <a href="/panel/users/" class="admin-dashboard-link">Użytkownicy<br><span>Konta użytkowników w sklepie</span></a>
    
    <h2>Administratorzy</h2>
    
    <a href="/panel/newsletter/" class="admin-dashboard-link">Administratorzy<br><span>Konta administratorów w sklepie</span></a>
    
    <h2>Sklep</h2>
    <a href="/panel/settings/" class="admin-dashboard-link">Wartości konfiguracyjne<br><span>ustawienia sklepu</span></a>
    <a href="/panel/statistics" class="admin-dashboard-link">Statystyki<br><span>statystyki sprzedaży i inne</span></a>
</div>  
@endsection