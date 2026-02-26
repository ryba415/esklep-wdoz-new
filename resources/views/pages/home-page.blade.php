@extends('layouts.front')

@section('content')

@include('loader')

 <section class="flex w-full flex-col items-center justify-center py-5 sm:py-10 p-4">
        <div class="w-full max-w-[1620px]">
            <div class="flex w-full flex-col items-stretch">
                <div class="slider-container">
                    <div class="slider-content" id="sliderContent">
                        @foreach ($topSlider as $i => $slide)
                        
                        <div class="slide">
                            @if ($slide->url != null && !empty($slide->url))
                            <a href="{{$slide->url}}">
                            @endif
                            <picture>
                                @if ($slide->imageMobile != null && !empty($slide->imageMobile))
                                    <source type="image/jpeg" srcset="/uploads/media/default/0001/01/{{$slide->imageMobile}}" >
                                @endif
                                    <source type="image/jpeg" srcset="/uploads/media/default/0001/01/{{$slide->imageMobile}}" >
                                <img @if ($i>0) loading="lazy" @endif src="/uploads/media/default/0001/01/{{$slide->imageMobile}}" alt="{{$slide->title}}" class="w-[100%] aspect-[2.09] object-contain w-full">
                            </picture>
                            @if ($slide->url != null && !empty($slide->url))
                            </a>
                            @endif  
                        </div>
                         
                        @endforeach
                    </div>
                    
                    <button class="nav-button prev" id="prevButton">
                        <img src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/c632ac6ee472260e54f40af416756c45f7d8eb97" alt="Previous" class="w-[7px]">
                    </button>
                    <button class="nav-button next" id="nextButton">
                        <img src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/9a118f85637bd768deb9901acd4aa4000337d463" alt="Next" class="w-[7px]">
                    </button>
                </div>
                
                 <div class="self-center flex items-center gap-5 mt-10 max-w-[calc(100vw-30px)] overflow-hidden" id="dotsContainer">
                    <div class="flex justify-start items-center flex-grow-0 flex-shrink-0 relative gap-5">
                        @foreach ($topSlider as $i => $slide)
                        @if ($i==0)
                        <div class="nav-dot" data-index="{{$i}}"></div>
                        @elseif($i==1)
                        <div class="nav-dot active flex-grow-0 flex-shrink-0 w-[18px] h-2.5 rounded bg-[#d9d9d9]" data-index="{{$i}}"></div>
                        @else
                        <div class="nav-dot flex-grow-0 flex-shrink-0 w-[18px] h-2.5 rounded bg-[#d9d9d9]" data-index="{{$i}}"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementy DOM
            const sliderContent = document.getElementById('sliderContent');
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.nav-dot');
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            
            // Ustawienia slidera
            let currentSlide = 1; // zaczynamy od drugiego slajdu (zgodnie z Twoim kodem)
            const totalSlides = slides.length;
            let autoPlayInterval;
            const autoPlayDelay = 5000; // 5 sekund między automatycznym przełączaniem slajdów
            
            // Funkcja do przejścia do konkretnego slajdu
            function goToSlide(index) {
                // Obsługa pętli
                if (index < 0) {
                    index = totalSlides - 1;
                } else if (index >= totalSlides) {
                    index = 0;
                }
                
                currentSlide = index;
                const translateValue = -currentSlide * 100;
                sliderContent.style.transform = `translateX(${translateValue}%)`;
                
                // Aktualizacja kropek
                dots.forEach((dot, i) => {
                    if (i === currentSlide) {
                        dot.classList.add('active');
                    } else {
                        dot.classList.remove('active');
                    }
                });
                
                // Resetowanie automatycznego odtwarzania
                resetAutoPlay();
            }
            
            // Funkcja do przejścia do następnego slajdu
            function nextSlide() {
                goToSlide(currentSlide + 1);
            }
            
            // Funkcja do przejścia do poprzedniego slajdu
            function prevSlide() {
                goToSlide(currentSlide - 1);
            }
            
            // Funkcja resetująca automatyczne odtwarzanie
            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                autoPlayInterval = setInterval(nextSlide, autoPlayDelay);
            }
            
            // Ustawienie nasłuchiwania dla przycisków nawigacyjnych
            prevButton.addEventListener('click', prevSlide);
            nextButton.addEventListener('click', nextSlide);
            
            // Ustawienie nasłuchiwania dla kropek nawigacyjnych
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                });
            });
            
            // Nasłuchiwanie klawiszy strzałek
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                }
            });
            
            // Zatrzymanie automatycznego odtwarzania po najechaniu na slider
            const sliderContainer = document.querySelector('.slider-container');
            sliderContainer.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });
            
            // Wznowienie automatycznego odtwarzania po opuszczeniu slidera
            sliderContainer.addEventListener('mouseleave', () => {
                resetAutoPlay();
            });
            
            // Obsługa interakcji dotykowych (swipe)
            let touchStartX = 0;
            let touchEndX = 0;
            
            sliderContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                clearInterval(autoPlayInterval);
            });
            
            sliderContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                resetAutoPlay();
            });
            
            function handleSwipe() {
                const swipeThreshold = 50; // minimalna odległość przesunięcia uznawana za swipe
                if (touchEndX - touchStartX > swipeThreshold) {
                    // Swipe w prawo - poprzedni slajd
                    prevSlide();
                } else if (touchStartX - touchEndX > swipeThreshold) {
                    // Swipe w lewo - następny slajd
                    nextSlide();
                }
            }
            
            // Inicjalizacja slidera
            goToSlide(currentSlide);
            resetAutoPlay();
        });
    </script>

    <section id="popularne-marki" class="bg-white flex w-full items-center justify-center py-7 xs:py-10 px-5">
        <div class="self-stretch min-w-60 min-h-[197px] w-[1620px] max-w-[1620px] my-auto">
            <div class="flex w-full items-center gap-5 text-[26px] text-[rgba(61,61,61,1)] font-semibold leading-none flex-wrap">
                <h2 class="self-stretch my-auto">Popularne marki</h2>
                <img src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/d8237285418a5e0510520b0cd5db6e35a4d83c87?placeholderIfAbsent=true" alt="Brand logo decoration" class="object-contain w-full self-stretch min-w-60 flex-1 shrink basis-[0%]" />
            </div>
            
            <!-- Logo slider container -->
            <div class="logo-slider w-full mt-10 relative overflow-hidden">
                <!-- Przyciski nawigacyjne -->
                <button id="prevButton" class="hidden absolute left-3 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center cursor-pointer z-10 transition-opacity duration-300 opacity-0 hover:opacity-100 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextButton" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center cursor-pointer z-10 transition-opacity duration-300 opacity-0 hover:opacity-100 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                
                <!-- Kontener logotypów -->
                <div id="logoTrack" class="logo-track flex justify-between transition-transform duration-500 ease-in-out w-full">
                    <div class="logo-item flex items-center justify-center p-2 md:p-4">
                        <a href="/bayer">
                        <img class="h-[55px] max-w-none" loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/6ca037ce63807d8949356ff1e1f594f6c355e998?placeholderIfAbsent=true" alt="Bayer - popularna marka sprzedawana w sklepie" class="aspect-[1] object-contain w-14 sm:w-16 md:w-20 h-auto shrink-0 rounded-[300px]" />
                        </a>
                    </div>
                    
                    <div class="logo-item flex items-center justify-center p-2 md:p-4">
                         <a href="/mollers">
                            <img class="h-[55px] max-w-none" loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/74ac8f1f4a02bcd2afd7092a226fb6e09e1f8d21?placeholderIfAbsent=true" alt="Mollers - popularna marka sprzedawana w sklepie" class="aspect-[2.8] object-contain w-32 sm:w-40 md:w-56 h-auto shrink-0" />
                         </a>
                    </div>

                    <div class="logo-item flex items-center justify-center p-2 md:p-4">
                        <a href="/zdrovit">
                            <img class="h-[55px] max-w-none" loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/e39d63bce1e82047fd2ffc87b96aed3573c144b8?placeholderIfAbsent=true" alt="Zdrovit - popularna marka sprzedawana w sklepie" class="aspect-[1.1] object-contain w-[60px] sm:w-[70px] md:w-[88px] h-auto shrink-0" />
                        </a>
                    </div>

                    <div class="logo-item flex items-center justify-center p-2 md:p-4">
                        <a href="/nutricia">
                            <img class="h-[55px] max-w-none" loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/515e30f0ff6941de235b241cf2f942a082a4412e?placeholderIfAbsent=true" alt="Nutricia - popularna marka sprzedawana w sklepie" class="aspect-[2.7] object-contain w-[140px] sm:w-[180px] md:w-[216px] h-auto shrink-0" />
                        </a>
                    </div>

                    <div class="logo-item flex items-center justify-center p-2 md:p-4">
                        <a href="/dermedic">
                            <img class="h-[55px] max-w-none" loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/0c9edeb35ef34a48cb4398f4a4372eaeb6af12a9?placeholderIfAbsent=true" alt="Dermedic - popularna marka sprzedawana w sklepie" class="aspect-[4.52] object-contain w-[200px] sm:w-[280px] md:w-[362px] h-auto shrink-0" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementy DOM
            const logoTrack = document.getElementById('logoTrack');
            const logoItems = document.querySelectorAll('.logo-item');
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const logoSlider = document.querySelector('.logo-slider');
            
            // Stan slidera
            let isSliderMode = false;
            let currentPosition = 0;
            let clonedItems = false;
            
            // Funkcja sprawdzająca czy logotypy mieszczą się w kontenerze
            function checkOverflow() {
                if (window.innerWidth < 1024) {
                    enableSliderMode();
                } else {
                    disableSliderMode();
                }
                // Pobierz szerokość kontenera slidera
                /*const sliderWidth = logoSlider.offsetWidth;
                
                // Oblicz całkowitą szerokość wszystkich oryginalnych elementów
                let totalWidth = 0;
                logoItems.forEach(item => {
                    totalWidth += item.offsetWidth;
                });
                // Sprawdź, czy należy włączyć tryb slidera
                if (totalWidth > sliderWidth) {
                    enableSliderMode();
                    console.log('enable slider!');
                } else {
                    disableSliderMode();
                    console.log('disable slider!');
                }*/
            }
            
            // Funkcja włączająca tryb slidera
            function enableSliderMode() {
                if (isSliderMode) return;
                
                isSliderMode = true;
                
                // Zmień klasy na tryb slidera
                logoTrack.classList.remove('flex-wrap', 'justify-between');
                logoTrack.classList.add('slider-mode', 'flex-nowrap');
                
                // Pokaż przyciski nawigacyjne
                prevButton.classList.remove('hidden');
                nextButton.classList.remove('hidden');
                
                // Pokaż przyciski na urządzeniach mobilnych
                if (window.innerWidth <= 768) {
                    prevButton.classList.remove('opacity-0');
                    nextButton.classList.remove('opacity-0');
                }
                
                // Klonuj elementy, jeśli jeszcze nie zostały sklonowane
                if (!clonedItems) {
                    logoItems.forEach(item => {
                        const clone = item.cloneNode(true);
                        logoTrack.appendChild(clone);
                    });
                    clonedItems = true;
                }
                
                // Dodaj klasę animacji po małym opóźnieniu
                setTimeout(() => {
                    logoTrack.classList.add('animate');
                }, 50);
            }
            
            // Funkcja wyłączająca tryb slidera
            function disableSliderMode() {
                if (!isSliderMode) return;
                
                isSliderMode = false;
                
                // Zmień klasy na tryb normalny
                logoTrack.classList.remove('slider-mode', 'animate', 'flex-nowrap');
                logoTrack.classList.add('flex-wrap', 'justify-between');
                
                // Ukryj przyciski nawigacyjne
                prevButton.classList.add('hidden');
                nextButton.classList.add('hidden');
                
                // Resetuj pozycję
                logoTrack.style.transform = 'translateX(0)';
                currentPosition = 0;
            }
            
            // Funkcja przesuwająca slider do przodu
            function nextSlide() {
                if (!isSliderMode) return;
                
                // Zatrzymaj animację
                logoTrack.classList.remove('animate');
                
                // Pobierz szerokość kontenera i obliczy rozmiar jednego przesunięcia
                const sliderWidth = logoSlider.offsetWidth;
                const step = sliderWidth / 2;
                
                // Oblicz całkowitą szerokość wszystkich oryginalnych elementów
                let totalWidth = 0;
                logoItems.forEach(item => {
                    totalWidth += item.offsetWidth;
                });
                
                // Przesuń do następnej pozycji
                currentPosition -= step;
                
                // Jeśli przesunięcie jest zbyt duże, wróć na początek
                if (Math.abs(currentPosition) >= totalWidth) {
                    currentPosition = 0;
                }
                
                // Zastosuj transformację
                logoTrack.style.transition = 'transform 0.5s ease-in-out';
                logoTrack.style.transform = `translateX(${currentPosition}px)`;
                
                // Przywróć animację po zakończeniu przejścia
                setTimeout(() => {
                    logoTrack.classList.add('animate');
                }, 500);
            }
            
            // Funkcja przesuwająca slider do tyłu
            function prevSlide() {
                if (!isSliderMode) return;
                
                // Zatrzymaj animację
                logoTrack.classList.remove('animate');
                
                // Pobierz szerokość kontenera i obliczy rozmiar jednego przesunięcia
                const sliderWidth = logoSlider.offsetWidth;
                const step = sliderWidth / 2;
                
                // Oblicz całkowitą szerokość wszystkich oryginalnych elementów
                let totalWidth = 0;
                logoItems.forEach(item => {
                    totalWidth += item.offsetWidth;
                });
                
                // Przesuń do poprzedniej pozycji
                currentPosition += step;
                
                // Jeśli przesunięcie jest zbyt duże (w drugą stronę), przejdź na koniec
                if (currentPosition > 0) {
                    currentPosition = -totalWidth + step;
                }
                
                // Zastosuj transformację
                logoTrack.style.transition = 'transform 0.5s ease-in-out';
                logoTrack.style.transform = `translateX(${currentPosition}px)`;
                
                // Przywróć animację po zakończeniu przejścia
                setTimeout(() => {
                    logoTrack.classList.add('animate');
                }, 500);
            }
            
            // Pokazywanie/ukrywanie przycisków przy hover na urządzeniach desktopowych
            logoSlider.addEventListener('mouseenter', () => {
                if (isSliderMode && window.innerWidth > 768) {
                    prevButton.classList.remove('opacity-0');
                    nextButton.classList.remove('opacity-0');
                }
            });
            
            logoSlider.addEventListener('mouseleave', () => {
                if (isSliderMode && window.innerWidth > 768) {
                    prevButton.classList.add('opacity-0');
                    nextButton.classList.add('opacity-0');
                }
            });
            
            // Ustawienie nasłuchiwania dla przycisków nawigacyjnych
            prevButton.addEventListener('click', prevSlide);
            nextButton.addEventListener('click', nextSlide);
            
            // Sprawdź, czy logotypy mieszczą się przy załadowaniu strony
            checkOverflow();
            
            // Sprawdź ponownie, gdy okno zmienia rozmiar
            window.addEventListener('resize', checkOverflow);
        });
    </script>



    
 
    <section class="bg-[#f7f7f7] flex w-full items-center justify-center py-16 min-h-[200px]">
        <div class="w-full max-w-[1620px] mx-auto px-5 gap-5">
            <div class="flex flex-wrap 2xl:flex-nowrap  justify-center gap-5">
                <div class=" w-[20%] flex-grow flex-shrink-0 min-w-[180px]  ">
                    <div class="h-[450px] flex justify-end bg-contain bg-no-repeat bg-[rgba(201,228,223,1)] flex flex-col items-center p-6 pb-3 rounded-2xl 2xl:h-[450px] bg-contain bg-center-center" 
                         @if (isset($topCategories[0]) && $topCategories[0]->image_mobile != '' && $topCategories[0]->image_mobile != null) style="@if ($topCategories[0]->color != '') background-color: {{$topCategories[0]->color}}; @endif background-image: url('/images/category-images/{{$topCategories[0]->image_mobile}}')" @endif>
                        <h3 class="min-h-[64px] text-[rgba(37,95,67,1)] text-2xl font-bold text-center">@if (isset($topCategories[0])) {{$topCategories[0]->name}} @endif</h3>
                        @if (isset($topCategories[0])) <a href="/{{$topCategories[0]->slug}}"> @endif
                        <button class="mt-2 px-10 py-3 bg-[rgba(254,215,0,1)] hover:bg-[rgba(234,195,0,1)] transition-colors text-base text-black font-medium rounded-2xl">
                            Zobacz więcej
                        </button>
                        @if (isset($topCategories[0])) </a> @endif
                    </div>
                </div>
                <div style="width: 20%" class="flex-grow flex-shrink-0    min-w-[180px] ">
                    <div class="h-[450px] flex justify-end bg-contain bg-no-repeat bg-[rgba(197,222,242,1)] flex-col items-center p-6 pb-3 rounded-2xl 2xl:h-[450px] bg-center-center" 
                         @if (isset($topCategories[1]) && $topCategories[1]->image_mobile != '' && $topCategories[1]->image_mobile != null) style="@if ($topCategories[1]->color != '') background-color: {{$topCategories[1]->color}}; @endif background-image: url('/images/category-images/{{$topCategories[1]->image_mobile}}')" @endif">
                        <h3 class="min-h-[64px] text-[rgba(43,87,122,1)] text-2xl font-bold text-center">@if (isset($topCategories[1])) {{$topCategories[1]->name}} @endif</h3>
                        @if (isset($topCategories[1])) <a href="/{{$topCategories[1]->slug}}"> @endif
                        <button class="mt-2 px-10 py-3 bg-[rgba(254,215,0,1)] hover:bg-[rgba(234,195,0,1)] transition-colors text-base text-black font-medium rounded-2xl">
                            Zobacz więcej
                        </button>
                        @if (isset($topCategories[1])) </a> @endif
                    </div>
                </div>
                <div style="width: 20%" class="flex-grow flex-shrink-0   min-w-[180px] ">
                    <div class="h-[450px] flex justify-end bg-contain bg-no-repeat bg-[rgba(219,205,240,1)] flex-col items-center p-6 pb-3 rounded-2xl 2xl:h-[450px] bg-center-center" 
                         @if (isset($topCategories[2]) && $topCategories[2]->image_mobile != '' && $topCategories[2]->image_mobile != null) style="@if ($topCategories[2]->color != '') background-color: {{$topCategories[2]->color}}; @endif background-image: url('images/category-images/{{$topCategories[2]->image_mobile}}')" @endif">
                        <h3 class="min-h-[64px] text-[rgba(71,43,112,1)] text-2xl font-bold text-center">@if (isset($topCategories[2])) {{$topCategories[2]->name}} @endif</h3>
                        @if (isset($topCategories[2])) <a href="/{{$topCategories[2]->slug}}"> @endif
                        <button class="mt-2 px-10 py-3 bg-[rgba(254,215,0,1)] hover:bg-[rgba(234,195,0,1)] transition-colors text-base text-black font-medium rounded-2xl">
                            Zobacz więcej
                        </button>
                        @if (isset($topCategories[2])) </a> @endif
                    </div>
                </div>
                <div style="width: 20%" class="flex-grow flex-shrink-0   min-w-[180px] ">
                    <div class="h-[450px] flex justify-end bg-contain bg-no-repeat bg-[rgba(242,198,223,1)] flex-col items-center p-6 pb-3 rounded-2xl 2xl:h-[450px] bg-center-center" 
                         @if (isset($topCategories[3]) && $topCategories[3]->image_mobile != '' && $topCategories[3]->image_mobile != null) style="@if ($topCategories[3]->color != '') background-color: {{$topCategories[3]->color}}; @endif background-image: url('/images/category-images/{{$topCategories[3]->image_mobile}}')" @endif">
                        <h3 class="min-h-[64px] text-[rgba(117,29,105,1)] text-2xl font-bold text-center">@if (isset($topCategories[3])) {{$topCategories[3]->name}} @endif</h3>
                        @if (isset($topCategories[3])) <a href="/{{$topCategories[3]->slug}}"> @endif
                        <button class="mt-2 px-10 py-3 bg-[rgba(254,215,0,1)] hover:bg-[rgba(234,195,0,1)] transition-colors text-base text-black font-medium rounded-2xl">
                            Zobacz więcej
                        </button>
                        @if (isset($topCategories[3])) </a> @endif
                    </div>
                </div>
                <div style="width: 20%" class="flex-grow flex-shrink-0  min-w-[180px] ">
                    <div class="h-[450px] flex justify-end bg-contain bg-no-repeat bg-[rgba(248,217,196,1)] flex-col items-center p-6 pb-3 rounded-2xl 2xl:h-[450px] bg-center-center" 
                         @if (isset($topCategories[4]) && $topCategories[4]->image_mobile != '' && $topCategories[4]->image_mobile != null) style="@if ($topCategories[4]->color != '') background-color: {{$topCategories[4]->color}}; @endif background-image: url('/images/category-images/{{$topCategories[4]->image_mobile}}')" @endif">
                        <h3 class="min-h-[64px] text-[rgba(122,62,21,1)] text-2xl font-bold text-center">@if (isset($topCategories[4])) {{$topCategories[4]->name}} @endif</h3>
                        @if (isset($topCategories[4])) <a href="/{{$topCategories[4]->slug}}"> @endif
                        <button class="mt-2 px-10 py-3 bg-[rgba(254,215,0,1)] hover:bg-[rgba(234,195,0,1)] transition-colors text-base text-black font-medium rounded-2xl">
                            Zobacz więcej
                        </button>
                        @if (isset($topCategories[4])) </a> @endif    
                    </div>
                </div>
            </div>
        </div>
    </section>


       <section class="overflow-hidden flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-5 py-[60px] px-5 bg-[#fffaf1]">
    <div class="flex w-full pb-6 2xl:hidden">
        <div class="items-center justify-between w-full flex flex-col lg:flex-row gap-3">
            <h2 class="text-2xl font-bold text-gray-900">Oferta Specjalna</h2>
            <div class="flex-grow mx-5">
                <div class="h-px bg-gray-300 w-full"></div>
            </div>
            <a href="/search?query=all-special-products1" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-green-600 hover:bg-green-700 text-white font-medium transition-colors">
                Zobacz wszystkie
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
    <div class="flex flex-row w-full max-w-[1620px] gap-4 overflow-hidden">
        <div style="background-image: url(/images/category-images/oferta-specjalna.jpg)" 
             class="flex justify-end bg-contain bg-no-repeat banner hidden 2xl:flex flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 relative gap-3 px-5 pt-[60px] pb-5 rounded-[20px] bg-[#ecdec8] border border-[#ddd] w-[310px] h-[478px]">
            <p class="self-stretch flex-grow-0 flex-shrink-0 text-[34px] font-bold text-center text-black">
                Oferta Specjalna
            </p>
            <div class="flex mt-0 justify-center items-center flex-grow-0 flex-shrink-0 relative gap-3 px-8 py-4 rounded-[32px] bg-[#38900d] ">
                <a href="/search?query=all-special-products1">
                <p class="flex-grow-0 flex-shrink-0 text-lg font-semibold text-left text-white">Zobacz wszystkie</p>
                </a>
            </div>
        </div>
        
        <div class="w-full relative" data-slider-container="slider1">
            <div class="overflow-hidden">
                <div class="product-slider grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 transition-transform duration-300 ease-in-out" data-slider-id="slider1">  
                @foreach ($specialProducts as $product)
                    @include('product/product-on-slider')
                @endforeach
                    
                </div>
            </div>

            <div class="flex justify-center mt-6 gap-4">
                <button class="prev-slide flex items-center justify-center w-10 h-10 rounded bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]" aria-label="Poprzednia strona" data-slider-id="slider1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="next-slide flex items-center justify-center  w-10 h-10 rounded bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]" aria-label="Następna strona" data-slider-id="slider1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
 
  <section class="overflow-hidden flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-5 py-[60px] px-5 bg-[#F1FFE4]">
    <div class="flex w-full pb-6 2xl:hidden">
        <div class="items-center justify-between w-full flex flex-col lg:flex-row gap-3">
            <h2 class="text-2xl font-bold text-gray-900">Oferta Specjalna</h2>
            <div class="flex-grow mx-5">
                <div class="h-px bg-gray-300 w-full"></div>
            </div>
            <a href="/search?query=all-bestseller-products1" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-green-600 hover:bg-green-700 text-white font-medium transition-colors">
                Zobacz wszystkie
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
    <div class="flex flex-row w-full max-w-[1620px] gap-4 overflow-hidden">

        <div class="w-full relative" data-slider-container="slider1">
            <!-- Kontener slidera z overflow -->
            <div class="overflow-hidden">
                <!-- Grid z produktami zamiast flex -->
                <div class="product-slider grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 transition-transform duration-300 ease-in-out" data-slider-id="slider1">
                    @foreach ($bestSellersProducts as $product)
                        @include('product/product-on-slider')
                    @endforeach
                </div>
            </div>
            
            <!-- Przyciski nawigacyjne slidera -->
            <div class="flex justify-center mt-6 gap-4">
                <button class="prev-slide flex items-center justify-center w-10 h-10 rounded bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]" aria-label="Poprzednia strona" data-slider-id="slider1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="next-slide flex items-center justify-center  w-10 h-10 rounded bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]" aria-label="Następna strona" data-slider-id="slider1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

                <!-- Baner po lewej stronie - nie zmienia położenia -->
        <div style="background-image: url(/images/category-images/bestsellery.jpg)"  
             class="flex justify-end bg-contain bg-no-repeat banner hidden 2xl:flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 relative gap-3 px-5 pt-[60px] pb-5 rounded-[20px] bg-[#ecdec8] border border-[#ddd] w-[310px] h-[478px]">
            <p class="leading-[35px] self-stretch flex-grow-0 flex-shrink-0 text-[34px] font-bold text-center text-black">
                Polecane dla Ciebie
            </p>
            <div class="flex justify-center items-center flex-grow-0 flex-shrink-0 relative gap-3 px-8 py-4 rounded-[32px] bg-[#38900d]">
                <a href="/search?query=all-bestseller-products1">
                <p class="flex-grow-0 flex-shrink-0 text-lg font-semibold text-left text-white">Zobacz wszystkie</p>
                </a>
            </div>
        </div>
    </div>
</section>


  <section class="overflow-hidden flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 gap-5 py-[60px] px-5 bg-[#FFF2EC]">
    <div class="flex w-full pb-6 2xl:hidden">
        <div class="items-center justify-between w-full flex flex-col lg:flex-row gap-3">
            <h2 class="text-2xl font-bold text-gray-900">Oferta Specjalna</h2>
            <div class="flex-grow mx-5">
                <div class="h-px bg-gray-300 w-full"></div>
            </div>
            <a href="/search?query=all-bestseller-products2" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-green-600 hover:bg-green-700 text-white font-medium transition-colors">
                Zobacz wszystkie
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
    <div class="flex flex-row w-full max-w-[1620px] gap-4 overflow-hidden">
        <div style="background-image: url(/images/category-images/klepsydra.jpg)"  
             class="flex justify-end bg-contain banner bg-no-repeat hidden 2xl:flex flex-col justify-start items-center self-stretch flex-grow-0 flex-shrink-0 relative gap-3 px-5 pt-[60px] pb-5 rounded-[20px] bg-[#F8B18C] border border-[#ddd] w-[310px] h-[478px;]">
            <p class="leading-[35px] self-stretch flex-grow-0 flex-shrink-0 text-[34px] font-bold text-center text-black">
                Produkty z krótką datą
            </p>
            <div class="flex justify-center items-center flex-grow-0 flex-shrink-0 relative gap-3 px-8 py-4 rounded-[32px] bg-[#38900d]">
                <a href="/search?query=all-bestseller-products2">
                <p class="flex-grow-0 flex-shrink-0 text-lg font-semibold text-left text-white">Zobacz wszystkie</p>
                </a>
            </div>
        </div>

        <div class="w-full relative" data-slider-container="slider2">
            <div class="overflow-hidden">
                <div class="product-slider grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 transition-transform duration-300 ease-in-out" data-slider-id="slider1">
                    @foreach ($shortExpirationDatesProducts as $product)
                        @include('product/product-on-slider')
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center mt-6 gap-4"> 
                <button class="prev-slide flex items-center justify-center w-10 h-10 rounded bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]" aria-label="Poprzednia strona" data-slider-id="slider2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>   
                <button class="next-slide flex items-center justify-center  w-10 h-10 rounded bg-[#38900d] text-white transition-all duration-300 focus:outline-none hover:bg-[#2c7309]" aria-label="Następna strona" data-slider-id="slider2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section> 
    
    
<h1 class="m-auto text-center pt-4 sm:pt-8 pl-1 pr-1 text-xl sm:text-2xl font-bold max-w-[250px] sm:max-w-[100%] text-[#008641]">Wracam do zdrowia</h1>

<section class="bg-white flex w-full items-center justify-center py-7 xs:py-10 px-5 mt-8 mb-5">
    <div class="self-stretch min-w-60 min-h-[197px] w-[1620px] max-w-[1620px] my-auto">
        <div class="flex w-full items-center gap-5 text-[26px] text-[rgba(61,61,61,1)] font-semibold leading-none flex-wrap">
            <h2 class="self-stretch my-auto">Płatność i wysyłka</h2>
            <img src="https://cdn.builder.io/api/v1/image/assets/c1af26aca41e46a69245d41457563759/d8237285418a5e0510520b0cd5db6e35a4d83c87?placeholderIfAbsent=true" alt="Brand logo decoration" class="object-contain w-full self-stretch min-w-60 flex-1 shrink basis-[0%]">
        </div>
        <div class="w-full mt-5 relative overflow-hidden">

            <div class="flex justify-between transition-transform duration-500 ease-in-out w-full flex-wrap">
                <div class="flex items-center justify-center p-2 md:p-4 w-[100%] md:w-auto">
                    <img class="h-[55px] md:h-[110px] max-w-none" loading="lazy" src="/images/paynow-payments.png" alt="płatności za pośrednictwem paynow">
                </div>

                <div class="flex items-center justify-center p-2 md:p-4">
                    <img class="h-[41px] max-w-none" loading="lazy" alt="dostawa Dpd - logo" src="/images/dpd-logo.png">
                </div>

                <div class="flex items-center justify-center p-2 md:p-4">
                    <img class="h-[41px] max-w-none" loading="lazy" alt="dostawa Dpd - logo" src="/images/inpost-logo.png">
                </div>

                <div class="flex items-center justify-center p-2 md:p-4">
                    <img class="h-[41px] max-w-none" loading="lazy" alt="Orlenpaczka" src="/images/orlenpaczka.png">
                </div>

            </div>
        </div>
    </div>
</section>    


    
<script>
/**
 * Uproszczony i niezawodny slider produktów z obsługą dotykową
 * - Kompatybilny ze wszystkimi rozmiarami ekranów
 * - Zapewnia pełne przewijanie wszystkich produktów
 */
document.addEventListener('DOMContentLoaded', function() {
    // Znajdź niezbędne elementy
    const sliderTrack = document.getElementById('slider-track');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const sliderContainer = document.getElementById('slider-container');
    
    // Sprawdź czy wszystkie elementy zostały znalezione
    if (!sliderTrack || !prevBtn || !nextBtn || !sliderContainer) {
        console.error('Nie można znaleźć elementów slidera');
        return;
    }
    
    // Znajdź wszystkie produkty w sliderze
    const productItems = sliderTrack.querySelectorAll('.produkt');
    
    // Jeśli nie ma produktów, zakończ
    if (productItems.length === 0) {
        console.error('Nie znaleziono produktów w sliderze');
        return;
    }
    
    // Zmienne kontrolujące slider
    let currentPosition = 0;  // aktualna pozycja
    let productWidth = 0;     // szerokość pojedynczego produktu
    const gap = 20;           // odstęp między produktami
    
    // Zmienne dotykowe
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    const minSwipeDistance = 50;  // minimalna odległość swipe
    
    /**
     * Aktualizuje wymiary slidera i oblicza maksymalną pozycję
     */
    function updateSliderDimensions() {
        // Pobierz rzeczywistą szerokość pierwszego produktu
        const firstProduct = productItems[0];
        const rect = firstProduct.getBoundingClientRect();
        productWidth = Math.floor(rect.width) + gap;
        
        // Sprawdź czy bieżąca pozycja jest prawidłowa
        checkAndFixPosition();
        
        // Aktualizuj stan przycisków
        updateButtonState();
    }
    
    /**
     * Sprawdza i naprawia pozycję slidera, jeśli jest nieprawidłowa
     */
    function checkAndFixPosition() {
        // Upewnij się, że currentPosition jest w dopuszczalnym zakresie
        if (currentPosition < 0) {
            currentPosition = 0;
        }
        
        // Nie pozwól przewinąć poza ostatni element
        const maxPosition = productItems.length - 1;
        if (currentPosition > maxPosition) {
            currentPosition = maxPosition;
        }
        
        // Aktualizuj pozycję slidera
        updateSliderPosition();
    }
    
    /**
     * Aktualizuje wizualną pozycję slidera
     */
    function updateSliderPosition() {
        // Przesuń slider do bieżącej pozycji
        const translateValue = -currentPosition * productWidth;
        sliderTrack.style.transform = `translateX(${translateValue}px)`;
    }
    
    /**
     * Aktualizuje stan przycisków (włączone/wyłączone)
     */
    function updateButtonState() {
        // Przycisk "poprzedni" jest wyłączony na pierwszym elemencie
        const isPrevDisabled = currentPosition <= 0;
        // Przycisk "następny" jest wyłączony na ostatnim elemencie
        const isNextDisabled = currentPosition >= productItems.length - 1;
        
        // Ustaw atrybuty i klasy
        prevBtn.disabled = isPrevDisabled;
        nextBtn.disabled = isNextDisabled;
        
        // Dodaj lub usuń klasy wizualne
        if (isPrevDisabled) {
            prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        
        if (isNextDisabled) {
            nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }
    
    /**
     * Przewija slider o jeden element
     * @param {string} direction - Kierunek przewijania ('prev' lub 'next')
     */
    function scrollSlider(direction) {
        if (direction === 'next' && currentPosition < productItems.length - 1) {
            // Przewiń do następnego produktu
            currentPosition++;
        } else if (direction === 'prev' && currentPosition > 0) {
            // Przewiń do poprzedniego produktu
            currentPosition--;
        }
        
        // Aktualizuj pozycję i stan przycisków
        updateSliderPosition();
        updateButtonState();
    }
    
    // Obsługa zdarzeń dotykowych
    function handleTouchStart(e) {
        touchStartX = e.touches[0].clientX;
        touchStartY = e.touches[0].clientY;
    }
    
    function handleTouchMove(e) {
        if (!e.touches || e.touches.length === 0) return;
        
        const touchCurrentX = e.touches[0].clientX;
        const touchCurrentY = e.touches[0].clientY;
        
        // Określ czy gest jest poziomy czy pionowy
        const horizontalDiff = Math.abs(touchCurrentX - touchStartX);
        const verticalDiff = Math.abs(touchCurrentY - touchStartY);
        
        // Jeśli gest jest bardziej poziomy, blokuj przewijanie strony
        if (horizontalDiff > verticalDiff) {
            e.preventDefault();
        }
    }
    
    function handleTouchEnd(e) {
        if (!e.changedTouches || e.changedTouches.length === 0) return;
        
        touchEndX = e.changedTouches[0].clientX;
        const swipeDistance = touchEndX - touchStartX;
        
        // Jeśli przesunięcie jest wystarczająco duże
        if (Math.abs(swipeDistance) > minSwipeDistance) {
            if (swipeDistance > 0) {
                // Przesunięcie w prawo - przewiń w lewo
                scrollSlider('prev');
            } else {
                // Przesunięcie w lewo - przewiń w prawo
                scrollSlider('next');
            }
        }
    }
    
    // Podłącz zdarzenia dotykowe
    sliderContainer.addEventListener('touchstart', handleTouchStart, { passive: false });
    sliderContainer.addEventListener('touchmove', handleTouchMove, { passive: false });
    sliderContainer.addEventListener('touchend', handleTouchEnd);
    
    // Podłącz zdarzenia kliknięć przycisków
    prevBtn.addEventListener('click', () => scrollSlider('prev'));
    nextBtn.addEventListener('click', () => scrollSlider('next'));
    
    // Inicjalizacja slidera
    updateSliderDimensions();
    
    // Dodatkowa inicjalizacja po opóźnieniu (dla załadowania obrazów i CSS)
    setTimeout(updateSliderDimensions, 300);
    
    // Obsługa zmiany rozmiaru okna
    window.addEventListener('resize', function() {
        // Odczekaj chwilę na stabilizację po zmianie rozmiaru
        setTimeout(updateSliderDimensions, 100);
    });
});
</script>


@endsection