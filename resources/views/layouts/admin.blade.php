<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Esklep - admin</title>
    <meta name="description" content="Esklep - admin">

    <link href="/css/admin-layout.min.css?v=9" rel="stylesheet">
    @if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ==  '/dashboard')
    <link href="/css/admin-dashboard.min.css?v=9" rel="stylesheet">
    @endif
    @if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/legal-tests' OR str_contains($_SERVER['REQUEST_URI'],'/legal-tests/category-') OR str_contains($_SERVER['REQUEST_URI'],'/legal-tasks'))
    <link href="/css/tests-list.min.css?v=9" rel="stylesheet">
    @endif
    @if(str_contains($_SERVER['REQUEST_URI'],'/legal-test/') OR str_contains($_SERVER['REQUEST_URI'],'/legal-task/') )
    <link href="/css/one-test.min.css?v=9" rel="stylesheet">
    @endif
    @if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/buy-pro-version' OR  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/buy-pro-version-form' OR  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/payment-thank-you-page' )
    <link href="/css/admin-buy-now.min.css?v=9" rel="stylesheet">
    @endif
    @if(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == '/settings' )
        <link href="/css/admin-settings.min.css?v=9" rel="stylesheet">
    @endif
    
    <link rel="preload" as="font" href="/fonts/page-font.woff2" crossorigin>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    
    
    <style>
    /* Główna nakładka */
    .loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.35); /* Ciemne, półprzezroczyste tło */
        z-index: 9999;
        
        /* Flexbox do idealnego centrowania */
        display: flex;
        justify-content: center;
        align-items: center;

        /* Płynność */
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    /* Klasa aktywująca (dodawana przez JS) */
    .loader-overlay.is-active {
        opacity: 1;
        visibility: visible;
    }

    /* Kontener wewnętrzny wymuszający układ pionowy */
    .loader-content {
        display: flex;
        flex-direction: column;
        align-items: center; /* Centrowanie w poziomie */
        justify-content: center; /* Centrowanie w pionie */
        transform: scale(0.8);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* Powiększenie zawartości po aktywacji */
    .loader-overlay.is-active .loader-content {
        transform: scale(1);
    }

    /* Styl spinnera */
    .loader-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid rgba(255, 255, 255, 0.2);
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px; /* Odstęp od tekstu */
    }

    /* Styl tekstu */
    .loader-text {
        color: #ffffff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 1px;
        margin: 0;
        text-align: center;
    }

    /* Animacja obrotu */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

</head>
<body>
<script>
    function hideGlobalLoader() {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.classList.remove('is-active');
        }
    };
    
    function showGlobalLoader() {
        const loader = document.getElementById('global-loader');
        if (loader) {
                loader.classList.add('is-active');
            }
    }
</script>
    <nav class="admin-top-navbar navbar navbar-expand-lg bg-light border-bottom">
        <div class="container">
            
            <button id="show-settings-menu" class="navbar-settings navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)"><path d="m19.122 11.59-.832-.685a1.172 1.172 0 0 1 0-1.81l.832-.685a1.558 1.558 0 0 0 .36-1.987l-1.643-2.846a1.558 1.558 0 0 0-1.901-.682l-1.01.378a1.172 1.172 0 0 1-1.567-.904l-.177-1.063A1.558 1.558 0 0 0 11.643 0H8.357C7.59 0 6.942.55 6.816 1.306l-.177 1.063a1.172 1.172 0 0 1-1.567.904l-1.01-.378a1.558 1.558 0 0 0-1.9.682L.517 6.423c-.383.664-.232 1.5.36 1.987l.832.685c.57.47.57 1.341 0 1.81l-.832.685a1.558 1.558 0 0 0-.36 1.987l1.643 2.846a1.558 1.558 0 0 0 1.902.682l1.009-.378a1.172 1.172 0 0 1 1.567.904l.177 1.063A1.558 1.558 0 0 0 8.357 20h3.286c.767 0 1.415-.55 1.541-1.306l.177-1.063a1.172 1.172 0 0 1 1.567-.904l1.01.378a1.558 1.558 0 0 0 1.9-.682l1.644-2.846c.383-.664.232-1.5-.36-1.987Zm-2.636 4.052-1.01-.379a2.734 2.734 0 0 0-3.656 2.112l-.177 1.063H8.357l-.177-1.063a2.734 2.734 0 0 0-3.656-2.112l-1.01.379-1.642-2.846.832-.685a2.734 2.734 0 0 0 0-4.222l-.832-.685 1.642-2.846 1.01.379A2.734 2.734 0 0 0 8.18 2.626l.177-1.063h3.286l.177 1.063a2.734 2.734 0 0 0 3.656 2.11l1.01-.378 1.643 2.846-.832.685a2.734 2.734 0 0 0 0 4.222l.832.685-1.643 2.846ZM10 6.146A3.859 3.859 0 0 0 6.146 10 3.859 3.859 0 0 0 10 13.854 3.859 3.859 0 0 0 13.854 10 3.859 3.859 0 0 0 10 6.146Zm0 6.146A2.294 2.294 0 0 1 7.708 10 2.294 2.294 0 0 1 10 7.708 2.294 2.294 0 0 1 12.292 10 2.294 2.294 0 0 1 10 12.292Z" fill="#353535"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h20v20H0z"/></clipPath></defs></svg>
            </button>
            <div class="hidden" id="settings-menu">
                
              @guest
              @else
                <p>{{ Auth::user()->name }}</p>
              @endguest
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                >Wyloguj</a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                </form>
              <a class="dropdown-item" href="/settings">Ustawienia</a>
          </div>
            
            
            <a class="navbar-brand" href="/dashboard">
                logo

            </a>
            
            <div id="show-admin-main-menu" class="show-admin-main-menu">
                <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M23.063 11.063H.938a.937.937 0 1 0 0 1.874h22.125a.937.937 0 1 0 0-1.874ZM23.063 3.563H.938a.937.937 0 1 0 0 1.874h22.125a.937.937 0 1 0 0-1.875ZM23.063 18.563H.938a.937.937 0 1 0 0 1.875h22.125a.937.937 0 1 0 0-1.875Z" fill="#353535"/></svg>
            </div>    
            
        </div>
    </nav>  
    
    

    <div id="main-menu-container" class="main-menu-container">
        <nav id="user-left-menu" class="user-left-menu">@include('layouts/admin-left-menu',['user'=>Auth::user()])</nav>
    </div>
    <div class="bread-crumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146ZM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5Z"></path>
                        </svg>
                    </a>
                </li>
                @if(isset($breadCrub1))
                    <li class="breadcrumb-item @if(is_null($breadCrub1['url'])) active @endif"  @if(is_null($breadCrub1['url'])) aria-current="page" @endif >
                        @if(!is_null($breadCrub1['url'])) <a href="{{ $breadCrub1['url'] }}"> @endif
                        {{ $breadCrub1['name'] }}
                        @if(!is_null($breadCrub1['url'])) </a> @endif
                    </li>
                @endif
                @if(isset($breadCrub2))
                    <li class="breadcrumb-item @if(is_null($breadCrub2['url'])) active @endif"  @if(is_null($breadCrub2['url'])) aria-current="page" @endif >
                    @if(!is_null($breadCrub2['url'])) <a href="{{ $breadCrub2['url'] }}"> @endif
                        {{ $breadCrub2['name'] }}
                    @if(!is_null($breadCrub2['url'])) </a> @endif
                    </li>
                @endif
                @if(isset($breadCrub3))
                    <li class="breadcrumb-item @if(is_null($breadCrub3['url'])) active @endif"  @if(is_null($breadCrub3['url'])) aria-current="page" @endif >
                    @if(!is_null($breadCrub3['url'])) <a href="{{ $breadCrub3['url'] }}"> @endif
                        {{ $breadCrub3['name'] }}
                    @if(!is_null($breadCrub3['url'])) </a> @endif
                    </li>
                @endif
                @if(isset($breadCrub4))
                    <li class="breadcrumb-item @if(is_null($breadCrub4['url'])) active @endif"  @if(is_null($breadCrub4['url'])) aria-current="page" @endif >
                    @if(!is_null($breadCrub4['url'])) <a href="{{ $breadCrub4['url'] }}"> @endif
                        {{ $breadCrub4['name'] }}
                    @if(!is_null($breadCrub4['url'])) </a> @endif
                    </li>
                @endif
                @if(isset($breadCrub5))
                    <li class="breadcrumb-item @if(is_null($breadCrub5['url'])) active @endif"  @if(is_null($breadCrub5['url'])) aria-current="page" @endif >
                    @if(!is_null($breadCrub5['url'])) <a href="{{ $breadCrub5['url'] }}"> @endif
                        {{ $breadCrub5['name'] }}
                    @if(!is_null($breadCrub5['url'])) </a> @endif
                    </li>
                @endif
            </ol>
        </nav>
  
        <div class="user-content-container">
        @yield('content')
        </div>
    </div>
    
    <nav class="bottom-bar">
        <a class="bottom-bar-item @if($_SERVER['REQUEST_URI'] == '/dashboard') bottom-bar-item-selected @endif" href="/dashboard">
            <svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.5"><path d="M9.08325 21.2659C9.08325 19.003 9.08325 17.8715 9.54069 16.877C9.99812 15.8824 10.8572 15.146 12.5753 13.6733L14.242 12.2448C17.3475 9.58289 18.9003 8.25195 20.7499 8.25195C22.5995 8.25195 24.1523 9.58289 27.2578 12.2448L28.9245 13.6733C30.6426 15.146 31.5017 15.8824 31.9592 16.877C32.4166 17.8715 32.4166 19.003 32.4166 21.2659V28.3332C32.4166 31.4759 32.4166 33.0473 31.4403 34.0236C30.464 34.9999 28.8926 34.9999 25.7499 34.9999H15.7499C12.6072 34.9999 11.0359 34.9999 10.0596 34.0236C9.08325 33.0473 9.08325 31.4759 9.08325 28.3332V21.2659Z" stroke="#222222" stroke-width="1.5"/><path d="M24.9166 35V26C24.9166 25.4477 24.4689 25 23.9166 25H17.5833C17.031 25 16.5833 25.4477 16.5833 26V35" stroke="#222222" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g></svg> 
            <span class="item-title">Start</span>
        </a>
        <a class="bottom-bar-item @if($_SERVER['REQUEST_URI'] == '/legal-tasks') bottom-bar-item-selected @endif" href="/legal-tasks">
            <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.5" clip-path="url(#clip0_2358_1249)"><path d="M35.5109 20.8985C35.3848 20.6932 35.1657 20.5705 34.9248 20.5705H34.8027L29.8625 9.68678H31.0191C31.7943 9.68678 32.4249 9.0561 32.4249 8.2809C32.4249 7.50571 31.7943 6.87503 31.0191 6.87503H19.7712V5.02386C20.5071 4.5314 20.9928 3.6929 20.9928 2.74285C20.9928 1.23047 19.7623 0 18.25 0C16.7376 0 15.5071 1.23047 15.5071 2.74285C15.5071 3.6929 15.9927 4.5314 16.7287 5.02386V6.87496H5.4808C4.70553 6.87496 4.07492 7.50564 4.07492 8.28083C4.07492 9.05603 4.7056 9.68671 5.4808 9.68671H6.63737L1.69718 20.5705H1.57509C1.33412 20.5705 1.11503 20.6931 0.988978 20.8984C0.862923 21.1038 0.852806 21.3547 0.961976 21.5697L1.85488 23.3272C2.20058 24.0077 2.88957 24.4305 3.65294 24.4305H11.5527C12.3161 24.4305 13.005 24.0078 13.3508 23.3272L14.2436 21.5699C14.3529 21.355 14.3428 21.1041 14.2168 20.8987C14.0908 20.6932 13.8716 20.5705 13.6306 20.5705H13.5086L8.56838 9.68678H16.7286V28.8725H13.019C12.1083 28.8725 11.3674 29.6134 11.3674 30.524V31.4218H10.5459C9.63526 31.4218 8.89438 32.1627 8.89438 33.0733V34.4855C8.89438 34.7696 9.12468 35 9.40885 35H27.091C27.3752 35 27.6055 34.7697 27.6055 34.4855V33.0733C27.6055 32.1627 26.8646 31.4218 25.9539 31.4218H25.1324V30.524C25.1324 29.6134 24.3916 28.8725 23.4809 28.8725H19.7712V14.0158C19.7712 13.7317 19.5409 10.5 19.2568 10.5C18.9726 10.5 18.7423 13.7317 18.7423 14.0158V28.8724H17.7574V9.17231C17.7574 8.88821 17.5271 8.65784 17.243 8.65784H5.4808C5.27291 8.65784 5.10379 8.48871 5.10379 8.28083C5.10379 8.07295 5.27291 7.90383 5.4808 7.90383H17.243C17.5272 7.90383 17.7575 7.67353 17.7575 7.38936V5.44187C17.7767 5.44536 17.7961 5.44796 17.8155 5.45103C17.8253 5.45261 17.8351 5.45425 17.8449 5.45568C17.8779 5.46054 17.9111 5.46471 17.9444 5.4684C17.9567 5.46977 17.969 5.47134 17.9814 5.4725C18.0127 5.47551 18.0441 5.4777 18.0756 5.47968C18.0894 5.48057 18.1031 5.4818 18.117 5.48241C18.1562 5.48426 18.1954 5.48515 18.2346 5.48542C18.2398 5.48542 18.2448 5.48583 18.2499 5.48583C18.255 5.48583 18.2601 5.48549 18.2651 5.48542C18.3044 5.48521 18.3436 5.48433 18.3828 5.48241C18.3967 5.48173 18.4104 5.4805 18.4242 5.47968C18.4557 5.4777 18.4871 5.47551 18.5184 5.4725C18.5308 5.47127 18.5431 5.46977 18.5555 5.4684C18.5887 5.46471 18.6219 5.46061 18.6549 5.45575C18.6648 5.45432 18.6745 5.45267 18.6843 5.4511C18.7036 5.44803 18.7231 5.44543 18.7423 5.44194V7.38943C18.7423 7.67353 18.9726 7.9039 19.2568 7.9039H31.019C31.2269 7.9039 31.396 8.07302 31.396 8.2809C31.396 8.48878 31.2269 8.6579 31.019 8.6579H19.2568C18.9727 8.6579 18.7424 8.88821 18.7424 9.17238L18.7424 15.5C18.7424 15.7841 18.9727 12.0916 19.2568 12.0916C19.541 12.0916 19.7713 15.2842 19.7713 15L19.7713 9.68678H27.9315L22.9914 20.5705H22.8693C22.6283 20.5705 22.4091 20.6932 22.2831 20.8986C22.1571 21.1041 22.1471 21.355 22.2562 21.5697L23.1491 23.3272C23.4948 24.0077 24.1838 24.4305 24.9472 24.4305H32.847C33.6103 24.4305 34.2993 24.0078 34.645 23.3272L35.538 21.5697C35.6471 21.3548 35.637 21.1039 35.5109 20.8985ZM23.4809 29.9014C23.8242 29.9014 24.1036 30.1807 24.1036 30.524V31.4217H16.2319C15.9477 31.4217 15.7174 31.652 15.7174 31.9362C15.7174 32.2203 15.9477 32.4507 16.2319 32.4507H25.9539C26.2972 32.4507 26.5765 32.73 26.5765 33.0733V33.9711H9.92333V33.0733C9.92333 32.73 10.2026 32.4507 10.5459 32.4507H17.8155C18.0996 32.4507 17.8449 32.2204 17.8449 31.9362C23.9862 31.9362 17.7842 31.4217 17.5 31.4217H12.3963V30.524C12.3963 30.1806 12.6756 29.9014 13.0189 29.9014H23.4809ZM12.4335 22.8612C12.2642 23.1945 11.9267 23.4016 11.5527 23.4016H3.65301C3.27908 23.4016 2.94159 23.1945 2.77227 22.8612L2.13119 21.5994H13.0745L12.4335 22.8612ZM12.3848 20.5705H2.82094L7.60287 10.0353L12.3848 20.5705ZM19.0102 4.27847C18.9915 4.28777 18.9725 4.29658 18.9536 4.3052C18.9439 4.30957 18.9344 4.31415 18.9246 4.31832C18.9031 4.32755 18.8815 4.3361 18.8597 4.34444C18.843 4.35079 18.8262 4.35688 18.8092 4.36276C18.7914 4.36898 18.7735 4.3752 18.7554 4.3808C18.739 4.38586 18.7223 4.39037 18.7057 4.39495C18.6931 4.39844 18.6806 4.40199 18.6678 4.40521C18.6507 4.40951 18.6333 4.41341 18.616 4.41724C18.6032 4.41997 18.5905 4.42271 18.5778 4.42517C18.5608 4.42845 18.5438 4.43152 18.5265 4.43433C18.5124 4.43665 18.4982 4.43863 18.484 4.44055C18.4681 4.44274 18.4522 4.44492 18.4362 4.44663C18.4185 4.44855 18.4006 4.44991 18.3828 4.45128C18.3699 4.45231 18.3571 4.45354 18.3443 4.45422C18.313 4.45593 18.2816 4.45695 18.25 4.45695C18.2184 4.45695 18.187 4.45593 18.1558 4.45422C18.1428 4.45354 18.1301 4.45231 18.1173 4.45128C18.0994 4.44991 18.0816 4.44855 18.0638 4.44663C18.0478 4.44492 18.032 4.44274 18.0161 4.44055C18.0019 4.43863 17.9877 4.43658 17.9735 4.43433C17.9564 4.43152 17.9393 4.42845 17.9222 4.42517C17.9095 4.42271 17.8967 4.41997 17.8841 4.41724C17.8667 4.41348 17.8494 4.40958 17.8322 4.40521C17.8196 4.40199 17.807 4.39844 17.7943 4.39495C17.7777 4.39037 17.7611 4.38586 17.7446 4.3808C17.7266 4.3752 17.7088 4.36898 17.6908 4.36276C17.6739 4.35688 17.657 4.35086 17.6403 4.34444C17.6186 4.3361 17.5969 4.32755 17.5755 4.31832C17.5657 4.31415 17.5561 4.30957 17.5465 4.3052C17.5275 4.29658 17.5086 4.28783 17.4899 4.27847C16.9252 3.99779 16.5361 3.41502 16.5361 2.74285C16.5361 1.79778 17.305 1.02887 18.2501 1.02887C19.1952 1.02887 19.9641 1.79778 19.9641 2.74285C19.9639 3.41502 19.5749 3.99779 19.0102 4.27847ZM28.897 10.0353L33.679 20.5705H24.115L28.897 10.0353ZM33.7277 22.8612C33.5583 23.1945 33.2208 23.4016 32.8469 23.4016H24.9471C24.5732 23.4016 24.2357 23.1945 24.0664 22.8612L23.4253 21.5994H34.3687L33.7277 22.8612Z" fill="black"/></g><defs><clipPath id="clip0_2358_1249"><rect width="35" height="35" fill="white" transform="translate(0.75)"/></clipPath></defs></svg>
            <span class="item-title">Ćwiczenia</span>
        </a>
    </nav>

    
    <div class="bg-light border-top  footer-container">
        <div class="container">
            @include('auth/footer')
        </div>
    </div>
    
    <div id="global-loader" class="loader-overlay">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <p class="loader-text">Proszę czekać...</p>
        </div>
    </div>

<script>
    document.getElementById('show-admin-main-menu').addEventListener("click", function(){
        let menuContainer = document.getElementById('main-menu-container');
        if (menuContainer.classList.contains('main-menu-opened')){
            menuContainer.classList.remove('main-menu-opened');
        } else {
            menuContainer.classList.add('main-menu-opened');
        }
    });
    
    document.getElementById('show-settings-menu').addEventListener("click", function(){
        let settinsMenu = document.getElementById('settings-menu');
        let menuContainer = document.getElementById('main-menu-container');
        if (settinsMenu.classList.contains('hidden')){
            settinsMenu.classList.remove('hidden');
            menuContainer.classList.remove('main-menu-opened');
        } else {
            settinsMenu.classList.add('hidden');
        }
    });
    
    
    
    function checkIsSelectEnable(e,taskId){
        
        if (!e.checked){
            return false;
        }
        let thisRowId = e.closest('.workshop-tree-table-row').getAttribute('data-identity');
        let thisLevel = e.closest('.workshop-tree-table-row').getAttribute('data-level');
        let rows = document.querySelectorAll('.workshop-tree-table-row');
        let isStarted = false;
        let isEnabled = true;
        
        for (let i=0;i<rows.length;i++){
            if (isStarted){
                if (rows[i].getAttribute('data-level') <= thisLevel ){
                    isStarted = false;
                }
                if (isStarted){
                    let rowChecbox = rows[i].querySelector('.workshop-action-row input[data-task-id="'+taskId+'"]');
                    if (rowChecbox != null){
                        if (!rowChecbox.checked){
                            isEnabled = false;
                            break;
                        }
                    }
                }
            }
            if (rows[i].getAttribute('data-identity') == thisRowId){
                isStarted = true;
            }
        }
        if (!isEnabled){
            e.checked = false;
            let warningDiv = document.createElement("div");
            warningDiv.classList.add('selected-disabled-warning');
            warningDiv.innerText = 'nie wszystkie elmenty podrzędne są zaznaczone';
            e.after(warningDiv);
            
            waitAndDelete(warningDiv);
        }
    }
    
    function waitAndDelete(item){
        setTimeout(function(){
            item.remove();
        }, 1000);
    }
    
    function trigerSelectChilds(e,taskId){
        let checkoxElemenet = e.parentNode.querySelector('.select-subactions-checbox');
        checkoxElemenet.click();
        
    }
    
    function selectSubactions(e,taskId){
        setTimeout(() => {
        let thisRowId = e.closest('.workshop-tree-table-row').getAttribute('data-identity');
        let thisLevel = e.closest('.workshop-tree-table-row').getAttribute('data-level');
        let rows = document.querySelectorAll('.workshop-tree-table-row');
        let isStarted = false;
        let isChecked = e.checked;
        let isFirst = true;

        for (let i=0;i<rows.length;i++){
            if (isStarted){
                if (rows[i].getAttribute('data-level') <= thisLevel ){
                    isStarted = false;
                }
                if (isStarted){
                    let rowChecbox = rows[i].querySelector('.workshop-action-row input[data-task-id="'+taskId+'"]');
                    if (rowChecbox != null){
                        if (isChecked){
                            rowChecbox.checked = true;
                        } else {
                            rowChecbox.checked = false;
                        }
                    }
                    let rowChecbox2 = rows[i].querySelector('.select-subactions-checbox[data-col-id="'+taskId+'"]');
                    if (rowChecbox2 != null){
                        if (isChecked){
                            rowChecbox2.checked = true;
                        } else {
                            rowChecbox2.checked = false;
                        }
                    }
                }
            }
            if (rows[i].getAttribute('data-identity') == thisRowId){
                isStarted = true;
            }
        }
        }, 100);
    }
    
    function highlightTreeChils(e){
        let thisRowId = e.closest('.workshop-tree-table-row').getAttribute('data-identity');
        let thisLevel = e.closest('.workshop-tree-table-row').getAttribute('data-level');
        let rows = document.querySelectorAll('.workshop-tree-table-row');
        let isStarted = false;
        let isFirst = true;

        for (let i=0;i<rows.length;i++){
            if (isStarted){
                if (rows[i].getAttribute('data-level') <= thisLevel ){
                    isStarted = false;
                }
                if (isStarted){
                    
                    rows[i].classList.add('workshop-tree-hilight');
                }
            }
            if (rows[i].getAttribute('data-identity') == thisRowId){
                isStarted = true;
            }
        }
    }
    
    function unhighlightTreeChils(e){
        let thisRowId = e.closest('.workshop-tree-table-row').getAttribute('data-identity');
        let thisLevel = e.closest('.workshop-tree-table-row').getAttribute('data-level');
        let rows = document.querySelectorAll('.workshop-tree-table-row');
        let isStarted = false;
        let isFirst = true;

        for (let i=0;i<rows.length;i++){
            if (isStarted){
                if (rows[i].getAttribute('data-level') <= thisLevel ){
                    isStarted = false;
                }
                if (isStarted){
                    
                    rows[i].classList.remove('workshop-tree-hilight');
                }
            }
            if (rows[i].getAttribute('data-identity') == thisRowId){
                isStarted = true;
            }
        }
    }

    function showHideTreeRow(e){
        let thisRowId = e.closest('.workshop-tree-table-row').getAttribute('data-identity');
        let thisLevel = parseInt(e.closest('.workshop-tree-table-row').getAttribute('data-level'));
        let rows = document.querySelectorAll('.workshop-tree-table-row');
        let isStarted = false;
        let isVisible = true;
        let isFirst = true;

console.log(thisLevel);

        for (let i=0;i<rows.length;i++){
            if (isStarted){
                if (isFirst){
                    isFirst = false;
                    if (rows[i].getAttribute('data-visible') == 'true'){
                        isVisible = true;
                    } else {
                        isVisible = false;
                    }
                }
                if (rows[i].getAttribute('data-level') <= thisLevel ){
                    isStarted = false;
                }
                if (isStarted){
                    console.log(thisLevel + 1);
                    if (rows[i].getAttribute('data-level') == (thisLevel + 1)){
                        if (isVisible){
                            rows[i].style.opacity = "0";
                            rows[i].style.display = "none";
                            rows[i].setAttribute('data-visible','false');
                        } else {
                            rows[i].style.opacity = "1";
                            rows[i].setAttribute('data-visible','true');
                            rows[i].style.display = "table-row";
                        }
                    }
                }
            }
            if (rows[i].getAttribute('data-identity') == thisRowId){
                isStarted = true;
            }
        }
        if (isVisible){
            e.closest('.workshop-tree-table-row').querySelector('.woksop-tree-more').classList.remove('workshop-tree-more-opened');
        } else {
            e.closest('.workshop-tree-table-row').querySelector('.woksop-tree-more').classList.add('workshop-tree-more-opened');
        }
    }

    
    
</script>   

<script>
  // Inicjalizacja dla wszystkich elementów z klasą .set-calendar
  flatpickr(".set-calendar", {
    dateFormat: "Y-m-d", // Format daty: dzień.miesiąc.rok
    allowInput: true     // Pozwala na ręczne wpisanie daty
  });
</script>
</body>
</html>