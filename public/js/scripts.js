     // Pobieramy wszystkie przyciski z klasą plus i minus
     document.querySelectorAll('.plus').forEach(button => {
        button.addEventListener('click', () => {
            // Znajdujemy sąsiadujące pole input z klasą price
            const input = button.previousElementSibling;
            if (input && input.classList.contains('price')) {
                input.value = parseInt(input.value, 10) + 1;
            }
        });
    });

    document.querySelectorAll('.minus').forEach(button => {
        button.addEventListener('click', () => {
            // Znajdujemy sąsiadujące pole input z klasą price
            const input = button.nextElementSibling;
            if (input && input.classList.contains('price')) {
                const currentValue = parseInt(input.value, 10);
                if (currentValue > 0) {
                    input.value = currentValue - 1;
                }
            }
        });
    });





/* slider hero */
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
        /*slider hero */





    /* skrypty slidera do produktow */
    //do slidera i paginacji nalezy ustawic taki sam data-slider-id

document.addEventListener('DOMContentLoaded', function() {
    initializeAllSliders();
    
    window.addEventListener('resize', function() {
        setTimeout(function() {
            initializeAllSliders();
        }, 100);
    });
});

function initializeAllSliders() {
    const sliderContainers = document.querySelectorAll('.slider-container');
    
    sliderContainers.forEach(container => {
        initializeSlider(container);
    });
}

function initializeSlider(container) {
    // Pobierz unikalny identyfikator slidera
    const sliderId = container.getAttribute('data-slider-id');
    if (!sliderId) {
        console.error('Slider nie ma identyfikatora data-slider-id');
        return;
    }
    
    // Znajdź powiązane elementy slidera
    const sliderTrack = container.querySelector('.slider-track');
    const navigation = document.querySelector(`.slider-navigation[data-slider-id="${sliderId}"]`);
    
    if (!sliderTrack || !navigation) {
        console.error(`Nie można znaleźć elementów slidera dla ID: ${sliderId}`);
        return;
    }
    
    const prevBtn = navigation.querySelector('.slider-prev');
    const nextBtn = navigation.querySelector('.slider-next');
    
    if (!prevBtn || !nextBtn) {
        console.error(`Nie można znaleźć przycisków nawigacji dla slidera ID: ${sliderId}`);
        return;
    }
    
    const productItems = sliderTrack.querySelectorAll('.produkt');
    
    if (productItems.length === 0) {
        console.error(`Nie znaleziono produktów w sliderze ID: ${sliderId}`);
        return;
    }
    
    // Określ szerokość kontenera slidera
    const containerWidth = container.clientWidth;
    
    let sliderData = {
        currentPosition: 0,  
        productWidth: 0,     
        productCount: productItems.length,
        gap: 20,
        containerWidth: containerWidth,
        visibleProducts: 1,  // Ile produktów jest widocznych jednocześnie - będzie obliczone później
        touchStartX: 0,      
        touchStartY: 0,      
        isMoving: false,     
        lastMoveTime: 0      
    };
    
    container.sliderData = sliderData;
    
    updateSliderDimensions(container, sliderTrack, productItems, sliderData);
    
    container.removeEventListener('touchstart', handleTouchStart);
    container.removeEventListener('touchmove', handleTouchMove);
    container.removeEventListener('touchend', handleTouchEnd);
    
    container.addEventListener('touchstart', handleTouchStart, { passive: false });
    container.addEventListener('touchmove', handleTouchMove, { passive: false });
    container.addEventListener('touchend', handleTouchEnd);
    
    prevBtn.removeEventListener('click', prevBtnHandler);
    nextBtn.removeEventListener('click', nextBtnHandler);
    
    prevBtn.addEventListener('click', prevBtnHandler);
    nextBtn.addEventListener('click', nextBtnHandler);
    
    function prevBtnHandler() {
        scrollSlider(container, sliderTrack, sliderData, prevBtn, nextBtn, 'prev');
    }
    
    function nextBtnHandler() {
        scrollSlider(container, sliderTrack, sliderData, prevBtn, nextBtn, 'next');
    }
    
    function handleTouchStart(e) {
        const sliderData = container.sliderData;
        sliderData.touchStartX = e.touches[0].clientX;
        sliderData.touchStartY = e.touches[0].clientY;
        sliderData.isMoving = false; // Resetuj flagę ruchu
    }
    
    function handleTouchMove(e) {
        if (!e.touches || e.touches.length === 0) return;
        
        const sliderData = container.sliderData;
        const touchCurrentX = e.touches[0].clientX;
        const touchCurrentY = e.touches[0].clientY;
        
        // Określ czy gest jest poziomy czy pionowy
        const horizontalDiff = Math.abs(touchCurrentX - sliderData.touchStartX);
        const verticalDiff = Math.abs(touchCurrentY - sliderData.touchStartY);
        
        // Jeśli gest jest bardziej poziomy, blokuj przewijanie strony
        if (horizontalDiff > verticalDiff) {
            e.preventDefault();
        }
    }
    
    function handleTouchEnd(e) {
        if (!e.changedTouches || e.changedTouches.length === 0) return;
        
        const sliderData = container.sliderData;
        
        // Jeśli slider jest już w trakcie przesuwania, ignoruj zdarzenie
        if (sliderData.isMoving) return;
        
        // Upewnij się, że od ostatniego ruchu minęło wystarczająco dużo czasu (300ms)
        const currentTime = new Date().getTime();
        if (currentTime - sliderData.lastMoveTime < 300) return;
        
        // Ustaw flagę ruchu aby uniknąć wielu jednoczesnych ruchów
        sliderData.isMoving = true;
        
        const touchEndX = e.changedTouches[0].clientX;
        const swipeDistance = touchEndX - sliderData.touchStartX;
        const minSwipeDistance = 50;  // minimalna odległość swipe
        
        // Jeśli przesunięcie jest wystarczająco duże
        if (Math.abs(swipeDistance) > minSwipeDistance) {
            if (swipeDistance > 0) {
                // Przesunięcie w prawo - przewiń w lewo
                scrollSlider(container, sliderTrack, sliderData, prevBtn, nextBtn, 'prev');
            } else {
                // Przesunięcie w lewo - przewiń w prawo
                scrollSlider(container, sliderTrack, sliderData, prevBtn, nextBtn, 'next');
            }
            
            // Zapisz czas ostatniego ruchu
            sliderData.lastMoveTime = currentTime;
            
            // Po zakończeniu animacji (300ms), zresetuj flagę ruchu
            setTimeout(function() {
                sliderData.isMoving = false;
            }, 350); // Trochę dłuższy niż czas animacji (300ms) dla pewności
        } else {
            // Jeśli przesunięcie nie było wystarczająco duże, zresetuj flagę ruchu
            sliderData.isMoving = false;
        }
    }
}

/**
 * Aktualizuje wymiary slidera i oblicza maksymalną pozycję
 */
function updateSliderDimensions(container, sliderTrack, productItems, sliderData) {
    // Pobierz rzeczywistą szerokość pierwszego produktu
    const firstProduct = productItems[0];
    const rect = firstProduct.getBoundingClientRect();
    sliderData.productWidth = Math.floor(rect.width) + sliderData.gap;
    
    // Oblicz, ile produktów jest widocznych jednocześnie
    sliderData.containerWidth = container.clientWidth;
    sliderData.visibleProducts = Math.floor(sliderData.containerWidth / sliderData.productWidth);
    
    // Jeśli wszystkie produkty mieszczą się w kontenerze, ukryj nawigację
    const sliderId = container.getAttribute('data-slider-id');
    const navigation = document.querySelector(`.slider-navigation[data-slider-id="${sliderId}"]`);
    
    if (sliderData.productCount <= sliderData.visibleProducts) {
        // Wszystkie produkty mieszczą się, ukryj nawigację
        if (navigation) {
            navigation.style.display = 'none';
        }
    } else {
        // Nie wszystkie produkty mieszczą się, pokaż nawigację
        if (navigation) {
            navigation.style.display = 'flex';
        }
    }
    
    // Sprawdź czy bieżąca pozycja jest prawidłowa
    checkAndFixPosition(container, sliderTrack, sliderData);
    
    // Znajdź przyciski do aktualizacji
    if (navigation) {
        const prevBtn = navigation.querySelector('.slider-prev');
        const nextBtn = navigation.querySelector('.slider-next');
        
        if (prevBtn && nextBtn) {
            // Aktualizuj stan przycisków
            updateButtonState(sliderData, prevBtn, nextBtn);
        }
    }
}

/**
 * Sprawdza i naprawia pozycję slidera, jeśli jest nieprawidłowa
 */
function checkAndFixPosition(container, sliderTrack, sliderData) {
    // Upewnij się, że currentPosition jest w dopuszczalnym zakresie
    if (sliderData.currentPosition < 0) {
        sliderData.currentPosition = 0;
    }
    
    // Oblicz maksymalną pozycję - uwzględniając widoczne produkty
    // Nie pozwól przewinąć poza ostatni element tak, aby wszystkie elementy były widoczne
    let maxPosition = Math.max(0, sliderData.productCount - sliderData.visibleProducts);
    
    // Jeśli aktualna pozycja jest większa niż maksymalna, ustaw ją na maksymalną
    if (sliderData.currentPosition > maxPosition) {
        sliderData.currentPosition = maxPosition;
    }
    
    // Aktualizuj pozycję slidera
    updateSliderPosition(sliderTrack, sliderData);
}

/**
 * Aktualizuje wizualną pozycję slidera
 */
function updateSliderPosition(sliderTrack, sliderData) {
    // Przesuń slider do bieżącej pozycji
    const translateValue = -sliderData.currentPosition * sliderData.productWidth;
    sliderTrack.style.transform = `translateX(${translateValue}px)`;
}

/**
 * Aktualizuje stan przycisków (włączone/wyłączone)
 */
function updateButtonState(sliderData, prevBtn, nextBtn) {
    // Przycisk "poprzedni" jest wyłączony na pierwszym elemencie
    const isPrevDisabled = sliderData.currentPosition <= 0;
    
    // Przycisk "następny" jest wyłączony, gdy wszystkie pozostałe produkty są widoczne
    // Oblicz maksymalną pozycję uwzględniając widoczne produkty
    const maxPosition = Math.max(0, sliderData.productCount - sliderData.visibleProducts);
    const isNextDisabled = sliderData.currentPosition >= maxPosition;
    
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
 * Przewija slider o jeden element, tylko jeśli są dostępne elementy do przewinięcia
 */
function scrollSlider(container, sliderTrack, sliderData, prevBtn, nextBtn, direction) {
    // Oblicz maksymalną pozycję uwzględniając widoczne produkty
    const maxPosition = Math.max(0, sliderData.productCount - sliderData.visibleProducts);
    
    if (direction === 'next' && sliderData.currentPosition < maxPosition) {
        // Przewiń do następnego produktu, ale tylko jeśli nie osiągnęliśmy maksymalnej pozycji
        sliderData.currentPosition++;
    } else if (direction === 'prev' && sliderData.currentPosition > 0) {
        // Przewiń do poprzedniego produktu, ale tylko jeśli nie jesteśmy na początku
        sliderData.currentPosition--;
    }
    
    updateSliderPosition(sliderTrack, sliderData);
    updateButtonState(sliderData, prevBtn, nextBtn);
}

    /* *skrypty slidera do produktow */


    /*checkbox akceptacja warunkow */
        document.addEventListener('DOMContentLoaded', function() {
      const checkboxButton = document.getElementById('newsletter-consent');
      const hiddenCheckbox = document.getElementById('hidden-checkbox');
      if (checkboxButton != null){
        const checkIcon = checkboxButton.querySelector('svg');
    }
      
      if (checkboxButton && hiddenCheckbox && checkIcon) {
        checkboxButton.addEventListener('click', function() {
          // Zmień stan ukrytego checkboxa
          hiddenCheckbox.checked = !hiddenCheckbox.checked;
          
          // Aktualizuj atrybuty przycisku
          if (hiddenCheckbox.checked) {
            checkboxButton.setAttribute('aria-checked', 'true');
            checkboxButton.setAttribute('data-state', 'checked');
            checkboxButton.classList.add('bg-[#38900D]');
            checkIcon.classList.remove('opacity-0');
            checkIcon.classList.add('opacity-100');
          } else {
            checkboxButton.setAttribute('aria-checked', 'false');
            checkboxButton.setAttribute('data-state', 'unchecked');
            checkboxButton.classList.remove('bg-[#38900D]');
            checkIcon.classList.remove('opacity-100');
            checkIcon.classList.add('opacity-0');
          }
        });
        
        // Obsługa kliknięcia etykiety (label)
        const label = document.querySelector('label[for="newsletter-consent"]');
        if (label) {
          label.addEventListener('click', function(e) {
            // Zapobiegaj domyślnemu zachowaniu (podwójnemu kliknięciu)
            e.preventDefault();
            // Zasymuluj kliknięcie przycisku
            checkboxButton.click();
          });
        }
      }
    });
        /*checkbox akceptacja warunkow */




        /* animacja do logotypow */
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
                // Pobierz szerokość kontenera slidera
                const sliderWidth = logoSlider.offsetWidth;
                
                // Oblicz całkowitą szerokość wszystkich oryginalnych elementów
                let totalWidth = 0;
                logoItems.forEach(item => {
                    totalWidth += item.offsetWidth;
                });
                
                // Sprawdź, czy należy włączyć tryb slidera
                if (totalWidth > sliderWidth) {
                    enableSliderMode();
                } else {
                    disableSliderMode();
                }
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
        /* *animacja do logotypow */




          document.addEventListener('DOMContentLoaded', function() {
            // Elementy DOM
            const mobileMenuButton = document.getElementById('mobile-menu');
            const closeMenuButton = document.getElementById('close-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const menuPanel = document.getElementById('menu-panel');
            
            // Funkcja otwierająca menu
            function openMenu() {
                menuOverlay.classList.remove('hidden');
                menuPanel.classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); // Blokuje przewijanie strony
            }
            
            // Funkcja zamykająca menu
            function closeMenu() {
                menuOverlay.classList.add('hidden');
                menuPanel.classList.add('hidden');
                document.body.classList.remove('overflow-hidden'); // Przywraca przewijanie strony
            }
            
            // Obsługa kliknięcia przycisku otwierającego menu
            mobileMenuButton.addEventListener('click', openMenu);
            
            // Obsługa kliknięcia przycisku zamykającego menu
            closeMenuButton.addEventListener('click', closeMenu);
            
            // Obsługa kliknięcia w overlay (poza menu)
            menuOverlay.addEventListener('click', function(event) {
                if (event.target === menuOverlay) {
                    closeMenu();
                }
            });
            
            // Obsługa klawisza Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !menuPanel.classList.contains('hidden')) {
                    closeMenu();
                }
            });
        });






        document.addEventListener('DOMContentLoaded', function() {
    const categoryItems = document.querySelectorAll('.category-item');
    const megaMenus = document.querySelectorAll('[data-mega-menu]');
    const megaMenuContainer = document.getElementById('mega-menu-container');
    
    // Funkcja do ukrywania wszystkich mega menu
    function hideAllMenus() {
        megaMenus.forEach(menu => {
            menu.classList.add('hidden');
        });
        megaMenuContainer.classList.add('hidden');
    }
    
    // Funkcja do pokazywania konkretnego mega menu
    function showMenu(categoryId) {
        hideAllMenus();
        const menuToShow = document.getElementById(`${categoryId}-menu`);
        if (menuToShow) {
            megaMenuContainer.classList.remove('hidden');
            menuToShow.classList.remove('hidden');
        }
    }
    
    // Śledzenie, czy myszka znajduje się nad menu lub kategorią
    let isOverMenuSystem = false;
    
    // Dodanie event listenerów do elementów kategorii
    /*categoryItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            isOverMenuSystem = true;
            const categoryId = this.getAttribute('data-category');
            showMenu(categoryId);
        });
        
        item.addEventListener('mouseleave', function() {
            isOverMenuSystem = false;
            // Opóźnienie ukrywania, aby sprawdzić, czy myszka przesunęła się na mega menu
            setTimeout(() => {
                if (!isOverMenuSystem) {
                    hideAllMenus();
                }
            }, 300); // Zmieniono z 100 na 300 ms (0,3 sekundy)
        });
    });*/
    
    /*
    // Dodanie event listenerów dla kontenera mega menu
    megaMenuContainer.addEventListener('mouseenter', function() {
        isOverMenuSystem = true;
    });
    
    megaMenuContainer.addEventListener('mouseleave', function() {
        isOverMenuSystem = false;
        // Dodanie opóźnienia również przy opuszczaniu mega menu
        setTimeout(() => {
            if (!isOverMenuSystem) {
                hideAllMenus();
            }
        }, 300); // Dodano opóźnienie 0,3 sekundy
    });*/
    
    // Event listener dla dokumentu, aby wykryć, kiedy myszka przesuwa się na inny element
    /*document.addEventListener('mouseover', function(event) {
        const isOverCategory = Array.from(categoryItems).some(item => item.contains(event.target));
        const isOverMegaMenu = megaMenuContainer.contains(event.target);
        
        if (!isOverCategory && !isOverMegaMenu) {
            isOverMenuSystem = false;
            // Dodanie opóźnienia również tutaj
            setTimeout(() => {
                if (!isOverMenuSystem) {
                    hideAllMenus();
                }
            }, 300); // Dodano opóźnienie 0,3 sekundy
        }
    });*/
});


   // Funkcja inicjalizacji menu po załadowaniu DOM
  document.addEventListener('DOMContentLoaded', function() {
    // Obsługa przycisków kategorii
    document.querySelectorAll('.category-toggle').forEach(button => {
      button.addEventListener('click', () => {
        const isOpen = button.getAttribute('data-open') === 'true';
        button.setAttribute('data-open', !isOpen);
        
        // Obracanie ikony strzałki
        const icon = button.querySelector('svg');
        if (isOpen) {
          icon.classList.remove('rotate-180');
        } else {
          icon.classList.add('rotate-180');
        }
        
        // Znajdź kontener podkategorii (następny element siostrzany do div)
        const container = button.closest('div').nextElementSibling;
        if (container) {
          if (isOpen) {
            container.classList.add('hidden');
          } else {
            container.classList.remove('hidden');
          }
        }
      });
    });

    // Obsługa rozwijania/zwijania podkategorii
    document.querySelectorAll('.subcategory-toggle').forEach(button => {
      button.addEventListener('click', () => {
        const isOpen = button.getAttribute('data-open') === 'true';
        button.setAttribute('data-open', !isOpen);
        
        // Obracanie ikony strzałki
        const icon = button.querySelector('svg');
        if (isOpen) {
          icon.classList.remove('rotate-180');
        } else {
          icon.classList.add('rotate-180');
        }
        
        // Znajdź kontener pod-podkategorii (następny element po buttonie)
        const container = button.nextElementSibling;
        if (container) {
          if (isOpen) {
            container.classList.add('hidden');
          } else {
            container.classList.remove('hidden');
          }
        }
      });
    });
  });



// menu mobilne 
        document.addEventListener('DOMContentLoaded', function() {
            // Elementy DOM
            const mobileMenuButton = document.getElementById('mobile-menu');
            const closeMenuButton = document.getElementById('close-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const menuPanel = document.getElementById('menu-panel');
            
            // Funkcja otwierająca menu
            function openMenu() {
                menuOverlay.classList.remove('hidden');
                menuPanel.classList.remove('hidden');
                document.body.classList.add('overflow-hidden'); // Blokuje przewijanie strony
            }
            
            // Funkcja zamykająca menu
            function closeMenu() {
                menuOverlay.classList.add('hidden');
                menuPanel.classList.add('hidden');
                document.body.classList.remove('overflow-hidden'); // Przywraca przewijanie strony
            }
            
            // Obsługa kliknięcia przycisku otwierającego menu
            mobileMenuButton.addEventListener('click', openMenu);
            
            // Obsługa kliknięcia przycisku zamykającego menu
            closeMenuButton.addEventListener('click', closeMenu);
            
            // Obsługa kliknięcia w overlay (poza menu)
            menuOverlay.addEventListener('click', function(event) {
                if (event.target === menuOverlay) {
                    closeMenu();
                }
            });
            
            // Obsługa klawisza Escape
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !menuPanel.classList.contains('hidden')) {
                    closeMenu();
                }
            });
        });





        //slider z col
          document.addEventListener('DOMContentLoaded', function() {
    // Znajdź wszystkie slidery na stronie
    const sliders = document.querySelectorAll('.product-slider');
    
    // Dla każdego slidera zainicjuj jego obsługę
    sliders.forEach(initializeSlider);
    
    // Funkcja inicjalizująca slider
    function initializeSlider(slider) {
        // Pobierz identyfikator slidera lub użyj domyślnego ID w przypadku oryginalnego slidera
        const sliderId = slider.getAttribute('data-slider-id') || 'product-slider';
        const sliderContainer = slider.closest('[data-slider-container]') || slider.closest('.relative') || slider.parentElement.parentElement;
        
        // Znajdź przyciski dla tego konkretnego slidera
        const prevButton = sliderContainer.querySelector('.prev-slide') || document.getElementById('prev-slide');
        const nextButton = sliderContainer.querySelector('.next-slide') || document.getElementById('next-slide');
        
        if (!prevButton || !nextButton) {
            console.error('Nie znaleziono przycisków nawigacyjnych dla slidera', sliderId);
            return;
        }
        
        // Zmienne kontrolujące slider
        let currentIndex = 0;
        let productsPerPage = getProductsPerPage();
        let totalProducts = slider.children.length;
        
        // Funkcja określająca liczbę produktów widocznych na stronie w zależności od rozdzielczości
        function getProductsPerPage() {
            if (window.innerWidth >= 1536) { // 2xl
                return 4;
            } else if (window.innerWidth >= 1280) { // xl
                return 3;
            } else if (window.innerWidth >= 1024) { // lg
                return 2;
            } else if (window.innerWidth >= 768) { // md
                return 2;
            } else if (window.innerWidth >= 640) { // sm
                return 2;
            } else {
                return 1;
            }
        }
        
        // Funkcja aktualizująca widoczność produktów - przesuwanie po jednym produkcie
        function updateVisibleProducts() {
            const products = Array.from(slider.children);
            
            // Ukryj wszystkie produkty
            products.forEach(product => {
                product.style.display = 'none';
            });
            
            // Pokaż tylko produkty w aktualnym "oknie"
            for (let i = currentIndex; i < Math.min(currentIndex + productsPerPage, totalProducts); i++) {
                if (products[i]) {
                    products[i].style.display = 'flex';
                }
            }
        }
        
        // Aktualizacja stanu przycisków (włączenie/wyłączenie)
        function updateButtonStates() {
            prevButton.disabled = currentIndex <= 0;
            prevButton.classList.toggle('opacity-50', currentIndex <= 0);
            
            nextButton.disabled = currentIndex >= totalProducts - productsPerPage;
            nextButton.classList.toggle('opacity-50', currentIndex >= totalProducts - productsPerPage);
        }
        
        // Obsługa kliknięcia przycisku "Poprzedni"
        prevButton.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--; // Przesuń o 1 produkt wstecz
                updateVisibleProducts();
                updateButtonStates();
            }
        });
        
        // Obsługa kliknięcia przycisku "Następny"
        nextButton.addEventListener('click', function() {
            if (currentIndex < totalProducts - productsPerPage) {
                currentIndex++; // Przesuń o 1 produkt do przodu
                updateVisibleProducts();
                updateButtonStates();
            }
        });
        
        // Obsługa zmiany rozmiaru okna
        window.addEventListener('resize', function() {
            const newProductsPerPage = getProductsPerPage();
            
            if (newProductsPerPage !== productsPerPage) {
                // Zachowaj pozycję względną podczas zmiany liczby produktów na stronę
                const visibleRatio = currentIndex / Math.max(1, totalProducts - productsPerPage);
                
                productsPerPage = newProductsPerPage;
                
                // Oblicz nowy indeks, zachowując podobną pozycję przewijania
                if (totalProducts > productsPerPage) {
                    currentIndex = Math.round(visibleRatio * (totalProducts - productsPerPage));
                } else {
                    currentIndex = 0;
                }
                
                // Zapewnij, że indeks jest prawidłowy
                currentIndex = Math.max(0, Math.min(currentIndex, totalProducts - productsPerPage));
                
                // Aktualizuj widok
                updateVisibleProducts();
                updateButtonStates();
            }
        });
        
        // Obsługa klawiszy strzałek
        document.addEventListener('keydown', function(e) {
            // Sprawdź, czy slider jest w widoku
            const rect = slider.getBoundingClientRect();
            const isInViewport = (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
            
            if (isInViewport) {
                if (e.key === 'ArrowLeft' && !prevButton.disabled) {
                    prevButton.click();
                } else if (e.key === 'ArrowRight' && !nextButton.disabled) {
                    nextButton.click();
                }
            }
        });
        
        // Dodaj obsługę przeciągania (swipe) na urządzeniach mobilnych
        let touchStartX = 0;
        let touchEndX = 0;
        
        slider.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        
        slider.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });
        
        function handleSwipe() {
            const minSwipeDistance = 50;
            const swipeDistance = touchEndX - touchStartX;
            
            if (swipeDistance > minSwipeDistance && !prevButton.disabled) {
                // Przesunięcie w prawo - poprzedni slajd
                prevButton.click();
            } 
            else if (swipeDistance < -minSwipeDistance && !nextButton.disabled) {
                // Przesunięcie w lewo - następny slajd
                nextButton.click();
            }
        }
        
        // Inicjalizacja slidera
        updateVisibleProducts();
        updateButtonStates();
        
        // Dodaj klasę wskazującą, że slider jest gotowy
        slider.classList.add('grid-slider-initialized');
    }
});





/* MINICART */
        const toggleButton = document.querySelector('.toggle-minicart');
        const minicart = document.getElementById('minicart');
        const closeButton = document.getElementById('close-minicart');
        let outsideClickListener = null;

        function showMiniCart() {
            // Pozycjonowanie minicart względem ikony koszyka
            const cartRect = toggleButton.getBoundingClientRect();
            const minicartWidth = 320; // w-80 = 320px
            const minicartWidthMd = 384; // md:w-96 = 384px
            
            // Sprawdź szerokość ekranu dla responsywności
            const isDesktop = window.innerWidth >= 768;
            const actualWidth = isDesktop ? minicartWidthMd : minicartWidth;
            
            // Pozycjonuj prawą krawędź minicart przy prawej krawędzi koszyka + 10px w prawo
            const rightPosition = window.innerWidth - cartRect.right - 10;
            const topPosition = cartRect.bottom + 8; // 8px odstępu od koszyka
            
            minicart.style.right = rightPosition + 'px';
            minicart.style.top = topPosition + 'px';
            
            // Sprawdź czy minicart nie wykracza poza lewy brzeg ekranu
            const leftEdge = cartRect.right - actualWidth;
            if (leftEdge < 8) { // 8px marginesu od lewej strony
                minicart.style.right = '8px';
                minicart.style.left = 'auto';
            }
            
            // Pokaż minicart
            minicart.classList.remove('hidden');
            
            // Dodaj animację
            setTimeout(() => {
                minicart.style.opacity = '1';
                minicart.style.transform = 'translateY(0)';
            }, 10);

            // Dodaj listener dla kliknięć poza minicart (z małym opóźnieniem)
            setTimeout(() => {
                outsideClickListener = (e) => {
                    if (!minicart.contains(e.target) && !toggleButton.contains(e.target)) {
                        hideMiniCart();
                    }
                };
                document.addEventListener('click', outsideClickListener);
            }, 100); // 100ms opóźnienia żeby nie zamknąć od razu po otwarciu
        }

        function hideMiniCart() {
            minicart.style.opacity = '0';
            minicart.style.transform = 'translateY(-10px)';
            
            // Usuń listener dla kliknięć poza minicart
            if (outsideClickListener) {
                document.removeEventListener('click', outsideClickListener);
                outsideClickListener = null;
            }
            
            setTimeout(() => {
                minicart.classList.add('hidden');
            }, 200);
        }

        // Event listeners\
        if (toggleButton != null){
            toggleButton.addEventListener('click', (e) => {
                e.stopPropagation();
                if (minicart.classList.contains('hidden')) {
                    showMiniCart();
                } else {
                    hideMiniCart();
                }
            });
        }

        if (closeButton != null){
            closeButton.addEventListener('click', hideMiniCart);
        }

        // Zamknij minicart przy kliknięciu ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !minicart.classList.contains('hidden')) {
                hideMiniCart();
            }
        });

        // Aktualizuj pozycję przy zmianie rozmiaru okna
        window.addEventListener('resize', () => {
            if (!minicart.classList.contains('hidden')) {
                showMiniCart();
            }
        });

        // Ustaw początkowe style dla animacji
        if (minicart != null){
            minicart.style.opacity = '0';
            minicart.style.transform = 'translateY(-10px)';
            minicart.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
        }

        // Funkcje do zarządzania produktami w koszyku
        function updateProductPrice(productId) {
            const quantityElement = document.querySelector(`.quantity-display[data-product-id="${productId}"]`);
            const priceElement = document.querySelector(`.product-price[data-product-id="${productId}"]`);
            
            const quantity = parseInt(quantityElement.textContent);
            const unitPrice = parseFloat(priceElement.dataset.unitPrice);
            const totalPrice = (quantity * unitPrice).toFixed(2);
            
            priceElement.textContent = `${totalPrice} zł`;
            updateTotalPrice();
        }

        function updateTotalPrice() {
            const allPrices = document.querySelectorAll('.product-price');
            let total = 0;
            
            allPrices.forEach(priceElement => {
                const priceText = priceElement.textContent.replace(' zł', '').replace(',', '.');
                total += parseFloat(priceText);
            });
            
            document.getElementById('total-price').textContent = `${total.toFixed(2)} zł`;
        }

        function updateCartItemCount() {
            // Oblicz łączną ilość wszystkich produktów (suma quantity)
            const quantityElements = document.querySelectorAll('.quantity-display');
            let totalQuantity = 0;
            
            quantityElements.forEach(element => {
                totalQuantity += parseInt(element.textContent);
            });
            
            document.getElementById('cart-title').textContent = `Koszyk (${totalQuantity})`;
            
            // Aktualizuj licznik w nawigacji (zielona kropka)
            document.getElementById('nav-cart-badge').textContent = totalQuantity;
        }

        function removeProduct(productId) {
            const productElement = document.querySelector(`.product-item[data-product-id="${productId}"]`);
            if (productElement) {
                productElement.remove();
                updateTotalPrice();
                updateCartItemCount();
            }
        }

        // Event listeners dla przycisków ilości i usuwania
        document.addEventListener('click', function(e) {
            // Zwiększanie ilości
            if (e.target.closest('.quantity-increase')) {
                const button = e.target.closest('.quantity-increase');
                const productId = button.dataset.productId;
                const quantityElement = document.querySelector(`.quantity-display[data-product-id="${productId}"]`);
                
                let quantity = parseInt(quantityElement.textContent);
                quantity++;
                quantityElement.textContent = quantity;
                updateProductPrice(productId);
                updateCartItemCount(); // Dodaj aktualizację licznika
            }
            
            // Zmniejszanie ilości
            if (e.target.closest('.quantity-decrease')) {
                const button = e.target.closest('.quantity-decrease');
                const productId = button.dataset.productId;
                const quantityElement = document.querySelector(`.quantity-display[data-product-id="${productId}"]`);
                
                let quantity = parseInt(quantityElement.textContent);
                if (quantity > 1) {
                    quantity--;
                    quantityElement.textContent = quantity;
                    updateProductPrice(productId);
                    updateCartItemCount(); // Dodaj aktualizację licznika
                } else {
                    // Jeśli ilość = 1 i klikamy minus, usuń produkt
                    removeProduct(productId);
                }
            }
            
            // Usuwanie produktu
            if (e.target.closest('.remove-product')) {
                const button = e.target.closest('.remove-product');
                const productId = button.dataset.productId;
                removeProduct(productId);
            }
        });


        /* *MINICART */