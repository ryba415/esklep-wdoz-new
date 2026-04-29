<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>sklep</title>
    <meta name="description" content="">
    
    <link rel="preload" as="style" href="/build/assets/app-ffe8a325.css" />
    <link rel="stylesheet" href="/build/assets/app-ffe8a325.css" />
    <link rel="stylesheet" href="/css/front-layout.css" />  
    <link rel="stylesheet" href="/css/tailwind.css" /> 
    <script type="text/javascript" src="/js/scripts.js?v=1"></script>
    
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    
    <!--@ vite('resources/css/app.css')-->
    
    
    <meta id="cform" name="csrf-token" content="{{ csrf_token() }}">
    
    <script>(function(w,d,s,i,dl){w._ceneo = w._ceneo || function () {
    w._ceneo.e = w._ceneo.e || []; w._ceneo.e.push(arguments); };
    w._ceneo.e = w._ceneo.e || [];dl=dl===undefined?"dataLayer":dl;
    const f = d.getElementsByTagName(s)[0], j = d.createElement(s); 
    j.defer = true;
    j.src = "https://ssl.ceneo.pl/ct/v5/script.js?accountGuid=" + i + "&t=" + 
    Date.now() + (dl ? "&dl=" + dl : ''); f.parentNode.insertBefore(j, f);
    })(window, document, "script", "13dc119a-c053-4dcd-b5db-1b0acb2308cc");</script>
</head>
<body>
    
    <div class="snap-content" >
        
    @include('layouts/header')    
    
    @include('layouts/menu')    
    
    <div id="front-content-container" class="front-content-container">
        @yield('content')
    </div>  
    
    @include('layouts/footer')   
    
    @include('product/product-scripts')
    
    </div>
    
    <script>
    window.addEventListener('scroll', function() {
        const menu = document.getElementById('main-menu-container');
        const topMenu = document.getElementById('header-top-desktop-menu');
        const frontContainer = document.getElementById('front-content-container');
        if (window.scrollY > 270) {
            menu.classList.add('scrolled-small-menu');
            topMenu.classList.add('scrolled-header-top-desktop-menu');
            frontContainer.classList.add('scrolled-front-content-container');
        } else {
            menu.classList.remove('scrolled-small-menu');
            topMenu.classList.remove('scrolled-header-top-desktop-menu');
            frontContainer.classList.remove('scrolled-front-content-container');
        }
      });
    </script>
</body>
</html>