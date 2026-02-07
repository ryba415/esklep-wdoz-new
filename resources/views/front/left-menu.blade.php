<ul class="main-menu-list">
    @if(Auth::check())
        <li><a href="/dashboard">Panel użytkownika</a></li>
    @else
        <li><a href="/login">Logowanie</a></li>
    @endif
</ul>
