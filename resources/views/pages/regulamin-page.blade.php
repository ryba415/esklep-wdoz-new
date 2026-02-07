@extends('layouts.front')

@section('content')

@include('loader')

<div class="bg-white flex flex-col overflow-hidden items-center pt-7 pb-[46px] px-20 max-md:px-5">
    <div class="w-[1280px] max-w-full">
        <h1 class="m-auto text-center pt-1 pb-4 sm:pt-8 pl-1 pr-1 text-xl sm:text-2xl font-bold max-w-[250px] sm:max-w-[100%] text-[#008641]">{!!$title!!}</h1>
    
        <p>Sprzedaż wysyłkową produktów leczniczych i innych produktów za pośrednictwem sieci Internet poprzez portal Apteki Internetowej prowadzi Apteka Wracam do Zdrowia przy Pl. Górnośląskim 16 w Gdyni. Podmiotem prowadzącym Aptekę Wracam do Zdrowia, działającą pod adresem www.wracamdozdrowia.pl jest spółka Wracam do zdrowia 8 spółka z ograniczoną odpowiedzialnością, adres: ul. Remusa 6, 81-574 Gdynia, wpisana do Rejestru Przedsiębiorców Krajowego Rejestru Sądowego prowadzonego przez Sąd Rejonowy w Gdańsku, Wydział Gospodarczy Krajowego Rejestru Sądowego pod numerem KRS: 0000674624, posiadająca REGON: 19212264200000, NIP: 5932265550 kapitał zakładowy 5.000,00 zł, pokryty w całości.
        Farmaceuci, stanowiący zespół Apteki Wracam do Zdrowia, w podejmowanych działaniach kierują się zasadami Kodeksu Etyki Aptekarza oraz Kodeksu Dobrych Praktyk.</p>

        <p>Przed rozpoczęciem korzystania z portalu Apteki Internetowej, zachęcamy do dokładnego i starannego zapoznania się z treścią niniejszego Regulaminu oraz Polityki Prywatności.</p>

        <h2>I. Spis treści.</h2>

        <ul style="margin-left: 40px; list-style-type:none">
                <li>2. Definicje.</li>
                <li>3. Ogólne warunki korzystania z Apteki Internetowej.</li>
                <li>4. Rejestracja Konta.</li>
                <li>5. Logowanie.</li>
                <li>6. Zamówienia.</li>
                <li>7. Płatności i dostawa.</li>
                <li>8. Pozostałe prawa i obowiązki Klientów.</li>
                <li>9. Odpowiedzialność.</li>
                <li>10. Ochrona danych osobowych.</li>
                <li>11. Prawo do odstąpienia.</li>
                <li>12. Reklamacje. Rękojmia i gwarancja.</li>
                <li>13. Prawa zastrzeżone.</li>
                <li>14. Postanowienia końcowe.</li>
        </ul>

        <h2>II. Definicje.</h2>

        <p><strong>Administrator / Sprzedający</strong> – Wracam do Zdrowia 8 Spółka z ograniczoną odpowiedzialnością, adres: ul. Remusa 6, 81-574 Gdynia, wpisana do Rejestru Przedsiębiorców Krajowego Rejestru Sądowego prowadzonego przez Sąd Rejonowy w Gdańsku, Wydział Gospodarczy Krajowego Rejestru Sądowego pod numerem KRS: 0000674624, posiadająca REGON: 19212264200000, NIP: 5932265550, będąca podmiotem prowadzącym aptekę Wracam do Zdrowia w Gdyni przy Pl. Górnośląski 16, 81-509 Gdynia, posiadającą zezwolenie Pomorskiego Wojewódzkiego Inspektoratu Farmaceutycznego nr 976/2016 na prowadzenie apteki ogólnodostępnej. Apteka Wracam do Zdrowia prowadzi sprzedaż wysyłkową w formie Apteki Internetowej Wracam do Zdrowia</p>

        <p>Dane do kontaktów ze Sprzedającym:</br>
        Apteka Internetowa Wracam do Zdrowia</br>
        Plac Górnośląski 16, 81-509 Gdynia</br>
        Telefon: 798002314</br>
        Adres email: apteka@wdoz.pl.</p>

        <p><strong>Apteka Internetowa</strong> – portal internetowy o nazwie Apteka Wracam do zdrowia pod domeną internetową www.wracamdozdrowia.pl   oraz domenami partnerskimi …… </p>

        <p><strong>Klient</strong> – osoba fizyczna, osoba prawna lub jednostka organizacyjna posiadająca zdolność do czynności prawnych, korzystająca z portalu Apteki Internetowej lub dokonująca zakupu w Aptece Internetowej - zgodnie z przepisami prawa, w odniesieniu do asortymentu sprzedawanego w ramach Apteki Internetowej.</p>

        <p><strong>Konsument</strong> – osoba fizyczna dokonująca z przedsiębiorcą czynności prawnej niezwiązanej bezpośrednio z jej działalnością gospodarczą lub zawodową (konsument w rozumieniu art. 221 Kodeksy cywilnego);</p>

        <p><strong>Konto</strong> – prawo dostępu do uprawnień oraz zasobów w ramach Portalu, przydzielonych przez Administratora Użytkownikowi, dzięki którym Użytkownik może dokonywać czynności, określonych w Regulaminie;</p>

        <p><strong>Lek OTC</strong> – produkt leczniczy wydawany bez recepty;</p>

        <p><strong>Lek RX</strong> – produkt leczniczy, wydawany na receptę;</p>

        <p><strong>Prawo Farmaceutyczne</strong> – ustawa Prawo farmaceutyczne z dnia 6 września 2001 r. (Dz.U. 2001 r., Nr 126, poz. 1381 z późń. zm.),</p>

        <p><strong>Produkt</strong> - rzecz ruchoma będąca przedmiotem Umowy sprzedaży;</p>

        <p><strong>Produkt leczniczy</strong> - jest substancją lub mieszaniną substancji, przedstawiana jako posiadająca właściwości zapobiegania lub leczenia chorób występujących u ludzi lub zwierząt lub podawana w celu postawienia diagnozy lub w celu przywrócenia, poprawienia lub modyfikacji fizjologicznych funkcji organizmu poprzez działanie farmakologiczne, immunologiczne lub metaboliczne;</p>

        <p><strong>Przedsiębiorca, posiadający uprawnienia konsumenta</strong> - osoba fizyczna, zawierająca umowę bezpośrednio związaną z jej działalnością gospodarczą, gdy z treści tej umowy wynika, że nie posiada ona dla tej osoby charakteru zawodowego, wynikającego w szczególności z przedmiotu wykonywanej przez nią działalności gospodarczej, udostępnionego na podstawie przepisów o Centralnej Ewidencji i Informacji o Działalności Gospodarczej;</p>

        <p><strong>Rozporządzenie</strong> – Rozporządzenie Ministra Zdrowia z dnia 26 marca 2015 r. w sprawie wysyłkowej sprzedaży produktów leczniczych (Dz.U. z 2015 r. poz. 481);</p>

        <p><strong>Regulamin</strong> – niniejszy Regulamin sprzedaży przy wykorzystaniu środków porozumiewania się na odległość;</p>

        <p><strong>RODO</strong> - Rozporządzenie Parlamentu Europejskiego i Rady UE 2016/679 z 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych i w sprawie swobodnego przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (Ogólne rozporządzenie o ochronie danych) (Dz.Urz. UE L 119, s. 1, ze zm.) (dalej: „RODO”);</p>

        <p><strong>Umowa sprzedaży</strong> – umowa sprzedaży Produktu zawierana albo zawarta między Klientem a Sprzedawcą z wykorzystaniem środków porozumiewania się na odległość za pośrednictwem Apteki Internetowej;</p>

        <p><strong>Usługi</strong> – usługa świadczona przez Aptekę Internetową drogą elektroniczną na zasadach określonych w Regulaminie;</p>

        <p><strong>Usługi farmaceutyczne</strong> - usługi w rozumieniu art. 4 ust. 3 ustawy z dnia 10 grudnia 2020 r. o zawodzie farmaceuty, w tym w szczególności:</p>
        <ul style="margin-left: 40px;">
                <li>przeprowadzanie wywiadu farmaceutycznego;</li>
                <li>udzielanie porady farmaceutycznej w celu zapewnienia prawidłowego stosowania produktu leczniczego, wyrobu medycznego lub środka spożywczego specjalnego przeznaczenia żywieniowego, w szczególności w zakresie wydania właściwego produktu leczniczego wydawanego bez przepisu lekarza, przekazania informacji dotyczących właściwego stosowania, w tym dawkowania i możliwych interakcji z innymi produktami leczniczymi lub pożywieniem, wydawanego produktu, wyrobu lub środka oraz prawidłowego używania wyrobów medycznych;</li>
        </ul>

        <p><strong>Zamówienie</strong> - oświadczenie woli Klienta składane poprzez wypełnienie formularza w sposób określony w Regulaminie, bezpośrednio zmierzające do zawarcia Umowy Sprzedaży Produktu ze Sprzedawcą, w tym w szczególności umożliwiające określenie ilości i rodzaju zakupionych Produktów, sposobu płatności oraz dostawy;</p>

        <p><strong>Zarejestrowany Klient/ Użytkownik</strong> – osoba, która dokonała rejestracji w Aptece Internetowej oraz założyła konto, przy użyciu adresu e-mail oraz hasła, na zasadach i warunkach określonych w Regulaminie.</p>

        <h2>III. Ogólne warunki korzystania z Apteki Internetowej.</h2>

        <p>1. Za pośrednictwem Apteki Internetowej, Klienci mają możliwość dokonać zakupu Produktów, w tym Produktów Leczniczych, a także uzyskać na warunkach i zasadach określonych w niniejszym Regulaminie, usługi farmaceutyczne.</p>

        <p>2. Informacje umieszczone na stronie internetowej Apteki Internetowej nie stanowią oferty zawarcia umowy w myśl przepisów Kodeksu Cywilnego. Zawarcie umowy następuje wyłącznie poprzez złożenie zamówienia przez Klienta oraz przez dostarczenie towaru.</p>

        <p>3. Warunkiem skorzystania z Apteki Internetowej jest posiadanie aktywnego konta poczty elektronicznej, dostęp do Internetu oraz skorzystanie z urządzenia z możliwością użycia przeglądarki:</p>
        <ul style="margin-left: 40px;">
                <li>Chrome ver. 80;</li>
                <li>Firefoxver. 74;</li>
                <li>Firefox IOS ver. 24;</li>
                <li>Firefox Mobile ver. 68;</li>
                <li>Edge on Windows ver. 80;</li>
                <li>Safari ver. 13.</li>
        </ul>

        <p>4. Klientem Apteki Internetowej może być:</p>
        <ul style="margin-left: 40px; list-style-type:none;">
                <li>1) osoba fizyczna, posiadająca pełną zdolność do czynności prawnych, a w przypadkach przewidzianych przez przepisy prawa także osoba fizyczna posiadająca ograniczoną zdolność do czynności prawnych,</li>
                <li>2) osoba prawna,</li>
                <li>3) jednostka organizacyjna nieposiadająca osobowości prawnej, której ustawa przyznała zdolność prawną z wyjątkiem podmiotów, określonych w ust. 7.</li>
        </ul>

        <p>5. Apteka Internetowa dokonuje sprzedaży Produktów, w tym produktów leczniczych, w celach i na zasadach określonych przepisami prawa.</p>

        <p>6. Apteka Internetowa nie prowadzi wysyłkowej sprzedaży leków Rx.</p>

        <p>7. Zgodnie z art. 72 ust. 3 w zw. z art. 86a Prawa Farmaceutycznego, Apteka Internetowa nie prowadzi obrotu hurtowego produktami leczniczymi, zaś podmioty uprawnione do obrotu detalicznego lub hurtowego produktami leczniczymi nie są uprawnione do składania zamówień i zakupu produktów leczniczych w Aptece   Internetowej. Apteka Internetowa nie realizuje Zamówień, dla których wymagane jest uzyskanie zapotrzebowania w rozumieniu art. 86a ust. 1 pkt 2) w zw. z art. 96 ust. 1. Prawa Farmaceutycznego.  Apteka zbywa produkty w celach  określonych w przepisach Prawa farmaceutycznego i wyłącznie na rzecz pormiotów uprawnionych.</p>

        <p>8. W Aptece Internetowej Klient ma możliwość skorzystania z następujących usług, świadczonych drogą elektroniczną przez Sprzedawcę:</p>
        <ul style="margin-left: 40px;"</ul>
                <li>usługi farmaceutyczne,</li>
                <li>usługa prowadzenia konta,</li>
                <li>usługa Newslettera zgodnie z odrębnym Regulaminem Newslettera.</li>
        </ul>

        <h2>IV. Rejestracja Konta.</h2>

        <p>1. Klient ma możliwość dokonania rejestracji na portalu Apteki Internetowej oraz utworzenia Konta.</p>
        <p>2. Rejestracja nie jest konieczna do złożenia zamówienia.</p>
        <p>3. Rejestracja na portalu Apteki Internetowej jest bezpłatna. Rejestracja odbywa się poprzez wypełnienie dostępnego na stronie internetowej formularza rejestracyjnego następującymi danymi:</p>

                        <ul style="margin-left: 40px; list-style-type:none;"</ul>
                                <li>1) imię nazwisko,</li>
                                <li>2) w przypadku działania w imieniu osoby prawnej lub jednostki organizacyjnej nieposiadającej osobowości prawnej, mogące we własnym imieniu nabywać prawa oraz zaciągać zobowiązania - nazwa podmiotu,</li>
                                <li>3) NIP,</li>
                                <li>4) aktywny adres e-mail,</li>
                                <li>5) hasło,</li>
                                <li>6) akceptację treści Regulaminu i Polityki Prywatności (Regulamin i Polityka Prywatności są dostępne na podstronie formularza rejestracyjnego oraz w dolnej części każdej z podstron portalu Apteki Internetowej; Klient ma możliwość zapoznania się z powyższymi dokumentami przed oraz w trakcie rejestracji Konta) a następnie przesłanie wypełnionego formularza rejestracyjnego drogą elektroniczną do Administratora poprzez wybór ikony „Zarejestruj się”.</li>
                        </ul>
        <p>4. Hasło jest ustalane indywidualnie przez Użytkownika i musi posiadać co najmniej 8 znaków.</p>

        <p>5. Użytkownik jest obowiązany do aktualizacji danych, podanych w zakresie swojego Konta. Użytkownik, który dokonał rejestracji może uzupełnić swój profil o adres do korespondencji lub zmienić swoje dane poprzez dokonanie edycji w zakładce Moje dane/ Dane do wysyłki.</p>

        <p>6. Użytkownik jest obowiązany do podania prawdziwych danych. Zabronione jest używanie danych osób trzecich lub danych fikcyjnych.</p>

        <p>7. Klient jest uprawniony do posiadania tylko jednego konta. Zabronione jest tworzenie odrębnych kont przy pomocy innych adresów e-mail Klienta lub adresów e-mail tymczasowych.</p>

        <p>8. Klient jest uprawniony do korzystania z portalu Apteki Internetowej jedynie za pośrednictwem własnego konta. Zabronione jest udostępnianie konta osobom trzecim.</p>

        <p>9. Rejestracja i utworzenie Konta przez osoby i jednostki, o których mowa w par. III ust. 4 pkt 2 i 3, może zostać dokonana jedynie przez ich przedstawicieli, uprawnionych do dokonania czynności w tym zakresie lub przez umocowanych pełnomocników.</p>

        <p>10. Sprzedawca nie weryfikuje danych, podawanych przez Klientów i nie ponosi odpowiedzialności za ich zgodność z prawdą oraz wiarygodność.</p>

        <p>11. Z chwilą dokonania rejestracji i utworzenia Konta, zostaje zawarta umowa pomiędzy Klientem a Administratorem o świadczenie usług, na warunkach i zasadach określonych w Regulaminie.</p>

        <p>12. Klient może usunąć swoje konto w każdym momencie poprzez wysłanie wiadomości e-mail zawierającej oświadczenie o chęci jego usunięcia na adres: apteka@wdoz.pl</p>


        <h2>V. Logowanie.</h2>

        <p>1. Użytkownik uzyskuje dostęp do Konta poprzez wpisanie adresu e-mail oraz hasła, podanych przy rejestracji.</p>

        <p>2. Użytkownik może dokonać zmiany hasła poprzez</p>

                <ul style="margin-left: 40px; list-style-type:none;"</ul>
                <li>1) formularz zmiany hasła po poprawnym zalogowaniu się</li>
                <li>2) procedury odzyskiwania hasła</li>
                </ul>

        <p>3. Użytkownik jest odpowiedzialny za zachowanie w poufności oraz ochronę hasła do Konta.</p>

        <p>4. Użytkownik może w każdym czasie usunąć Konto, co będzie równoważne rozwiązaniu umowy o świadczenie usług z Administratorem. Klient może dokonać usunięcia Konta poprzez przesłanie drogą elektroniczną lub w formie pisemnej oświadczenia woli. Konto zostanie usunięte w terminie 14 dni od dnia zgłoszenia żądania w tym zakresie przez Użytkownika.</p>


        <h2>VI. Zamówienia.</h2>

        <p>1. Zamówienia przyjmowane są poprzez stronę internetową <a href="www.wracamdozdrowia.pl">www.wracamdozdrowia.pl</a></p>

        <p>2. Zamawiając Produkt Klient dokonuje wyboru ilości zamawianych sztuk produktu.</p>

        <p>3. Złożenie zamówienia przez osoby i jednostki, o których mowa w par. III ust. 4 pkt 2 i 3, może zostać dokonane jedynie przez ich przedstawicieli, uprawnionych do dokonania czynności w tym zakresie lub przez umocowanych pełnomocników.</p>

        <p>4. Klient zobowiązuje się do składania wyłącznie prawnie wiążących zamówień́. W przypadku podejrzenia złożenia przez Klienta zamówienia fałszywego lub podania nieprawdziwych danych, Sprzedawca ma prawo do anulowania zamówienia.</p>

        <p>5. Klient może składać zamówienia w Aptece Internetowej dwadzieścia cztery (24) godziny na dobę przez cały rok kalendarzowy. Zamówienia można składać wedle wyboru Klienta jako:</p>

                <ul style="margin-left: 40px;"</ul>
                <li>Zarejestrowany Klient albo</li>
                <li>jako Gość– bez konieczności rejestracji oraz założenia Konta na stronie Apteki Internetowej.</li>
                </ul>

        <p>6. Zarejestrowany Klient po dokonaniu zamówienia ma możliwość wglądu w historię swoich zamówień oraz śledzenie zamówienia.</p>

        <p>7. Do złożenia i realizacji zamówienia przez Sprzedawcę niezbędne jest podanie wszystkich danych oznaczonych jako obowiązkowe w formularzu zamówienia. Dane obowiązkowe są oznaczone „gwiazdką”.</p>

        <p>8. W celu złożenia zamówienia niezbędne jest posiadanie przez Klienta aktywnego konta poczty elektronicznej.</p>

        <p>9. Zamówienia należy składać w następujący sposób:
                <ul style="margin-left: 40px;"</ul>
                <li>po wybraniu Produktu należy wybrać ilość zamawianych opakowań, a następnie kliknąć ikonę „Dodaj do koszyka”. Koszyk jest widoczny w prawym górnym rogu strony;</li>
                <li>po kliknięciu na ikonę „Koszyk” lub „Przejdź do koszyka” należy zaakceptować wybrane Produkty poprzez kliknięcie w na ikonę „Złóż zamówienie”;</li>
                <li>należy wybrać sposób dostawy oraz zapłaty, uzupełnić formularz zamówienia o wszystkie dane obligatoryjne (formularz w części zostanie wypełniony automatycznie w przypadku zalogowanych Klientów) oraz zaakceptować Regulamin i Politykę Prywatności, a następnie wybrać ikonę „Zamawiam i płacę”.</li>
                </ul>

        <p>10. Kliknięcie ikony „Zamawiam” oznacza złożenie zamówienia. Po potwierdzeniu zamówienia zmiana  produktów nie będzie możliwa.</p>

        <p>11. Po złożeniu zamówienia, na podany przez Klienta adres e-mail Sprzedawca prześle potwierdzenie jego złożenia. Potwierdzenie złożenia zamówienia nie jest jednoznaczne z przyjęciem zamówienia do realizacji.</p>

        <p>12. Informacja o przyjęciu zamówienia do realizacji (stanowiąca oświadczenie Sprzedawcy o przyjęciu oferty), zostanie przesłana przez Sprzedawcę na podany przez Klienta adres e-mail. Z chwilą otrzymania przez Klienta informacji o przyjęciu zamówienia do realizacji, zostaje zawarta Umowa sprzedaży.</p>

        <p>13. W przypadku przesłania błędnego zamówienia, dotyczącego wybranych Produktów, Klient powinien niezwłocznie poinformować o tym Sprzedawcę, dzwoniąc na numer 798002314 lub adres e-mail: <a href="mailto: eapteka@wdoz.pl">eapteka@wdoz.pl</a>. Sprzedawca nie ma obowiązku zmiany zamówienia po przyjęciu go do realizacji.</p>


        <h2>VII. Płatności i dostawa.</h2>

        <p>1. Ceny Produktów widoczne podawane są w złotych polskich oraz stanowią ceny brutto, zawierające podatek VAT.</p>

        <p>2. Do ceny zamawianych Produktów doliczany jest koszt dostawy.</p>

        <p>3. Sprzedawca zastrzega możliwość zmiany ceny Produktów oraz sposobów dostawy i płatności, z zastrzeżeniem zdania następnego. Po wypełnieniu i przesłaniu przez Klienta formularza zamówienia (po kliknięciu ikony „Zamawiam i płacę”) cena zamówionych Produktów oraz koszt dostawy jest ceną ostateczną, która wiąże Sprzedawcę oraz Klienta.</p>

        <p>4. W przypadku ogłoszenia promocji lub wyprzedaży Sprzedawca podaje, oprócz ceny aktualnej danego Produktu, również najniższą cenę z 30 dni poprzedzających obniżkę ceny. W przypadku Produktu z krótką datą przydatności do spożycia Sprzedawca podaje aktualną cenę i tę sprzed pierwszego zastosowania obniżki. Natomiast w kontekście Produktu będącego w ofercie Sprzedawcy krócej niż 30 dni- najniższą cenę od rozpoczęcia sprzedaży do wprowadzenia obniżki. Regulacji tych nie stosuje się, gdy Sprzedawca zwyczajnie obniża cenę regularną, bez ogłoszenia promocji lub wyprzedaży.</p>

        <p>5. Sprzedawca zastrzega sobie prawo anulowania zamówienia w całości lub w odniesieniu do części produktów w następujących przypadkach:</p>

                <ul style="margin-left: 40px; "</ul>
                        <li>braku dostępności Produktów lub wycofanie produktu z obrotu lub wstrzymanie w obrocie na terenie Rzeczypospolitej Polskiej;</li>
                        <li>podjęcie podejrzenia, że osoba występująca w imieniu danego podmiotu jest niewłaściwie umocowana lub nie ma pełnomocnictwa do działania w imieniu podmiotu;</li>
                        <li>podjęcia podejrzenia, że sprzedaż Produktu stanowiłaby naruszenie obowiązujących przepisów prawa lub Produkt może być wykorzystany w niezgodny z prawem sposób,  w tym w szczególności w przypadku gdy realizacja zamówienia  i zbycie produktów stanowiłoby naruszenia przepisów w zakresie prowadzenia obrotu detalicznego produktami leczniczymi ibezpośredniego zaopatrywania ludności w produkty lecznicze</li>
                        <li>działania siły wyższej lub innych nieprzewidzianych lub nadzwyczajnych okoliczności - np. awarii, decyzji organów, działań urzędowych, trudności lub opóźnień w dostawie istotnych potrzebnych materiałów, itp. - nawet jeśli wystąpią one u poprzedniego dostawcy.</li>
                </ul>

        <p>6. W przypadku anulowania zamówienia, Klientowi nie przysługują żadne roszczenia odszkodowawcze.</p>

        <p>7. W przypadku anulowania zamówienia, Klient zostanie poinformowany o braku możliwości jego realizacji drogą elektroniczną na podany adres e-mail lub telefonicznie.</p>

        <p>8. Klient może dokonać płatności za zamówione Produkty poprzez zewnętrzny system płatności Paynow. Podmiotem świadczącym obsługę płatności online w zakresie płatności kartami jest Autopay S.A. Dostępne formy płatności:</p>

                <p>Karty płatnicze:</p>
                <ul style="margin-left: 40px;"</ul>
                        <li>Visa</li>
                        <li>Visa Electron</li>
                        <li>Mastercard</li>
                        <li>MasterCard Electronic</li>
                        <li>Maestro"</li>
                </ul>

        <p>9. Po dokonaniu płatności oraz zawarciu Umowy sprzedaży w rozumieniu niniejszego Regulaminu, Klientowi zostanie wystawiona faktura VAT lub też paragon. Użytkownik wyraźnie upoważnia Sprzedawcę do wystawiania faktur w formie elektronicznej.</p>

        <p>10. Paragon zostanie wydrukowany oraz dołączony do paczki zawierającej zamówienie, a następnie wysłany na adres Klienta. Natomiast faktura VAT zostanie przesłana po wysyłce Produktów w formie elektronicznej na podany adres e-mail Klienta (faktura elektroniczna).</p>

        <p>11. Sprzedawca dostarcza Produkty jedynie na terenie Polski.</p>

        <p>12. Produkty dostarczane są do Klienta w następujący sposób:</p>

                <ul style="margin-left: 40px;"</ul>
                        <li>przesyłka kurierska - doręczenie nastąpi w ciągu 1-2 dni roboczych od dnia nadania;</li>
                        <li>doręczenie do paczkomatu  - doręczenie nastąpi w ciągu 3 dni roboczych od dnia nadania.</li>
                </ul>

        <p>13. Termin realizacji zamówienia jest liczony od momentu uzyskania pozytywnej autoryzacji płatności i dostawy wynosi do 7 (siedmiu) dni roboczych.</p>

        <p>14. Z chwilą dostawy Produktów Klient obejmie je w posiadanie i odpowiada za ryzyko związane z Produktem.</p>

        <p>15. Sprzedający dokonuje zwrotu płatności przy użyciu takiego samego sposobu płatności, jakiego użył Klient, chyba że konsument wyraźnie zgodził się na inny sposób zwrotu, który nie wiąże się dla niego z żadnymi kosztami.</p>

        <p>16. W celu ułatwienia zakupów oraz przejrzystości koszyka, produkty zostały podzielone na produkty apteczne (produkty lecznicze, w tym leki OTC) oraz pozostałe produkty drogeryjne. 

        <h2>VIII. Pozostałe prawa i obowiązki Klientów.</h2>

        <p>1. Klient jest obowiązany do korzystania z Apteki Internetowej zgodnie z obowiązującymi przepisami prawa oraz postanowieniami Regulaminu. Klient ponosi pełną odpowiedzialność prawną za wszelkie działania sprzeczne z obowiązującymi przepisami prawa lub niezgodne z Regulaminem, a w szczególności za podanie fałszywych danych. W szczególności zabronione jest:</p>

                <ul style="margin-left: 40px;"</ul>
                        <li>podejmowanie działań uniemożliwiających, ograniczających lub zakłócających działanie portalu Apteki Internetowej, w tym rozsyłanie wirusów, przeprowadzania ataków lub ich prób typu odmowa usługi (DOS) lub rozproszona odmowa usługi (DDOS), rozsyłanie innych szkodliwych technologii, próby nieautoryzowanego dostępu do portalu Apteki Internetowej, baz danych, serwerów lub jakichkolwiek urządzeń,</li>

                        <li>rozsyłanie spamu,</li>

                        <li>podawania fałszywych danych lub wprowadzanie w błąd,</li>

                        <li>podejmowanie jakichkolwiek innych działań, które mogą naruszać bezpieczeństwo korzystania lub prawa innych Klientów,</li>

                        <li>podejmowanie bezprawnych działań, które naruszają lub negatywnie wpływają na dobre imię, renomę lub wizerunek Sprzedawcy.</li>
                </ul>

        <p>2. Klient powinien niezwłocznie powiadomić Administratora o każdym naruszeniu jego praw w związku z korzystaniem z portalu Apteki Internetowej, a także o wszelkich błędach w zakresie funkcjonowaniu Apteki Internetowej (Klient może skontaktować się z Administratorem telefonicznie pod numerem tel. 798002314 lub przesłać wiadomość drogą elektroniczną na adres e-mail: <a href="mailto: eapteka@wdoz.pl)">eapteka@wdoz.pl</a>.</p>

        <h2>IX. Odpowiedzialność.</h2>

        <p>1. Opis Produktów, w tym w szczególności produktów leczniczych, znajdujący się na stronie internetowej Apteki Internetowej służy wyłącznie celom informacyjnym. Przed użyciem Produktu należy szczegółowo zapoznać się z ulotką, załączoną do opakowania. W szczególności przed użyciem leków OTC należy zapoznać się z treścią ulotki dołączonej do opakowania bądź skonsultować się z lekarzem lub farmaceutą, gdyż każdy lek niewłaściwie stosowany zagraża Twojemu życiu lub zdrowiu.</p>

        <p>2. Sprzedawca nie ponosi odpowiedzialności za skutki niewłaściwego użycia Produktów i w sposób odbiegający od informacji podanej przez producenta.</p>

        <p>3. Administrator podejmuje wszelkie możliwe środki do zapewnienia stałego i niezakłóconego korzystania z Apteki Internetowej, jednakże zastrzega możliwość czasowych przerw w jego funkcjonowaniu (ze względów technicznych lub innych niezależnych od Administratora) i nie odpowiada za ewentualne szkody z tym związane.</p>

        <p>4. Sprzedawca jest uprawniony do zablokowania Konta Klienta w przypadku działania przez Klienta na szkodę Sprzedawcy, naruszenia przez Klienta przepisów prawa lub postanowień Regulaminu. Sprzedawca jest uprawniony do zawieszenia Konta w przypadku powzięcia wątpliwości w zakresie prawdziwej tożsamości Klienta lub posiadania przez niego większej liczby Kont na Portalu.</p>

        <h2>X. Ochrona danych osobowych.</h2>

        <p>Zasady ochrony danych osobowych zostały uregulowane w <a href="#">Polityce Prywatności</a></p>

        <h2>XI. Prawo do odstąpienia.</h2>

        <p>1. Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta, ma prawo odstąpić od umowy sprzedaży Produktu w terminie 14 dni bez podania jakiejkolwiek przyczyny, za wyjątkiem zakupu Produktów lub usług, opisanych w ust. 2. Termin do odstąpienia od umowy wygasa po upływie 14 dni od dnia w którym weszli Państwo w posiadanie rzeczy lub w którym osoba trzecia inna niż przewoźnik i wskazana przez Państwa weszła w posiadanie rzeczy. W celu zachowania terminu do odstąpienia od umowy, wystarczy wysłanie oświadczenia o odstąpieniu od umowy przed upływem powyższego terminu.</p>

        <p>2. Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta, nie ma uprawnienia do odstąpienia w zakresie zakupu:</p>

                <ul style="margin-left: 40px; list-style-type:none;"</ul>
                        <li>a) produktów leczniczych, środków spożywczych specjalnego przeznaczenia żywieniowego i wyrobów medycznych, za wyjątkiem produktu leczniczego lub wyrobu medycznego zwracanego z powodu wady jakościowej, niewłaściwego ich wydania lub sfałszowania produktu leczniczego,</li>

                        <li>b) Produktów, dostarczanych w zapieczętowanym opakowaniu, których po otwarciu opakowania nie można zwrócić ze względu na ochronę zdrowia lub ze względów higienicznych, jeżeli opakowanie zostało otwarte po dostarczeniu,</li>

                        <li>c) usług farmaceutycznych, świadczonych przez Aptekę Internetową w formie elektroniczne</li>
                </ul>

        <p>3. W celu skorzystania z prawa odstąpienia od umowy, Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta, musi poinformować Sprzedawcę o swojej decyzji o odstąpieniu od umowy sprzedaży w drodze jednoznacznego oświadczenia.</p>

        <p>4. Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta, może skorzystać z wzoru formularza odstąpienia od umowy, stanowiącego Załącznik nr 1 do Regulaminu, jednak nie jest to obowiązkowe. Oświadczenie o odstąpieniu od Umowy Sprzedaży może zostać złożone np.:</p>

        <ul style="margin-left: 40px; list-style-type:none;"</ul>
                <li>a) w formie pisemnej na adres: Plac Górnośląski 16, 81-509 Gdynia;</li>
                <li>b) w formie elektronicznej za pośrednictwem poczty elektronicznej na adres e-mail: <a href="mailto: reklamacje@wdoz.pl">reklamacje@wdoz.pl</a></li>
                <li>c) przy wykorzystaniu wzoru formularza odstąpienia od umowy;</li>
                <li>d) poprzez złożenie oświadczenia na stronie Apteki Internetowej (w przypadku skorzystania z tej możliwości, Sprzedawca prześle niezwłocznie potwierdzenie otrzymania informacji o odstąpieniu od umowy na trwałym.</li>
                <li><a href="#">Formularz odstąpienia od umowy</a></li>
        </ul>

        <p>5. W przypadku odstąpienia od umowy sprzedaży, Sprzedawca zwróci Konsumentowi lub Przedsiębiorcy, posiadającemu uprawnienia konsumenta, dokonane przez niego płatności, w tym koszty dostawy Produktu (z wyjątkiem dodatkowych kosztów wynikających z wybranego przez Państwa sposobu dostarczenia innego niż najtańszy zwykły sposób dostarczenia oferowany przez nas), nie później niż w terminie 14 dni od dnia otrzymania oświadczenia o odstąpieniu od umowy.</p>

        <p>6. Sprzedawca dokona zwrotu uiszczonych przez Konsumenta (lub Przedsiębiorcę, posiadającego uprawnienia konsumenta) płatności przy użyciu takiego samego sposobu płatności, jakiego użył Klient, chyba że Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta wyraźnie zgodził się na inny sposób zwrotu, który nie wiąże się dla niego z żadnymi kosztami.</p>

        <p>7. Sprzedający może wstrzymać się ze zwrotem płatności otrzymanych od Konsumenta lub Przedsiębiorcy, posiadającego uprawnienia konsumenta, do chwili otrzymania Produktu z powrotem lub dostarczenia dowodu jego odesłania, w zależności od tego, które zdarzenie nastąpi wcześniej.</p>

        <p>8. Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta ma obowiązek niezwłocznie, nie później niż w terminie 14 dni od dnia, w którym odstąpił od Umowy Sprzedaży, zwrócić Produkt Sprzedawcy lub przekazać go osobie upoważnionej przez Sprzedawcę do odbioru. Do zachowania terminu wystarczy odesłanie Produktu przed jego upływem. Konsument może zwrócić Produkt na adres: Apteka Wracam do Zdrowia Plac Górnośląski 16, 81-509 Gdynia.</p>

        <p>9. Konsument lub Przedsiębiorca, posiadający uprawnienia konsumenta ponosi bezpośrednie koszty zwrotu rzeczy oraz odpowiada za zmniejszenie wartości Produktu wynikające z korzystania z niego w sposób inny niż było to konieczne do stwierdzenia charakteru, cech i funkcjonowania rzeczy.</p>


        <h2>XII. Reklamacje. Odpowiedzialność za niezgodność towaru z umową  i Gwarancja.</h2>

        <p>1. Sprzedawca dokonuje sprzedaży Produktów nowych i bez wad.</p>

        <p>2. Sprzedający ponosi odpowiedzialność za brak zgodności Produktu z umową istniejący w chwili jego dostarczenia i ujawniony w ciągu dwóch lat od tej chwili, chyba że termin przydatności Produktu do użycia, określony przez przedsiębiorcę, jego poprzedników prawnych lub osoby działające w ich imieniu, jest dłuższy, na zasadach określonych w przepisach ustawy o prawach konsumenta (art. 43c i nast. ustawy o prawach konsumenta). Domniemywa się, że brak zgodności Produktu z umową, który ujawnił się przed upływem dwóch lat od chwili dostarczenia Produktu, istniał w chwili jego dostarczenia, o ile nie zostanie udowodnione inaczej lub domniemania tego nie można pogodzić ze specyfiką Produktu lub charakterem braku zgodności towaru z umową.</p>

        <p>3. W odniesieniu do Produktów z elementami cyfrowymi, przedsiębiorca ponosi odpowiedzialność za brak zgodności z umową treści cyfrowej lub usługi cyfrowej dostarczanych w sposób ciągły, który wystąpił lub ujawnił się w czasie, w którym zgodnie z umową miały być dostarczane. Czas ten nie może być krótszy niż dwa lata od chwili dostarczenia Produktu z elementami cyfrowymi. Domniemywa się, że brak zgodności treści cyfrowej lub usługi cyfrowej z umową wystąpił w tym czasie, jeżeli w tym czasie się ujawnił.</p>

        <p>4. Sprzedający na podstawie art. 558 § 1 Kodeksu cywilnego niniejszym wyłącza odpowiedzialność z tytułu wad fizycznych i prawnych (rękojmia) wobec Klientów, niebędących Konsumentami.</p>

        <p>5. Reklamację, o ile możliwość ich złożenia przysługuje Klientowi, można złożyć:</p>

                <ul style="margin-left: 40px;"</ul>
                        <li>drogą pocztową na adres: Apteka Wracam do Zdrowia Plac Górnośląski 16, 81-509 Gdynia</li>
                        <li>lub drogą elektroniczną na adres e-mail: <a href="mailto: reklamacje@wdoz.pl">reklamacje@wdoz.pl</a>.</li>
                </ul>

        <p>6. W przypadku reklamacji drogą pocztową, Klient powinien wskazać niezbędne informację do zidentyfikowania zamówienia (np. numer zamówienia), imię i nazwisko, adres poczty elektronicznej, adres do doręczeń oraz wskazać przyczyny reklamacji, w tym szczegółowy opis wady Produktu. Klient powinien wskazać, o jakie działania ze strony Sprzedawcy wnosi. Klient może złożyć reklamację przy wykorzystaniu formularza reklamacji, zamieszczonego na stronie <a href="#">reklamacje i zwroty</a>. Klient powinien przesłać Produkt, będący przedmiotem reklamacji, na adres:</p>

                <ul style="margin-left: 40px; list-style-type:none;"</ul>
                        <li>Apteka Wracam do Zdrowia Plac Górnośląski 16, 81-509 Gdynia</l1>
                </ul>

        <p>7. Sprzedawca jest zobowiązany rozpatrzyć reklamację w terminie 14 dni przesłanie wiadomości elektronicznej na adres e-mail Klienta.</p>

        <p>8. Jeżeli sprzedany Produkt jest niezgodny z umową, Klient będący Konsumentem może żądać jego naprawy lub wymiany.</p>

        <p>9. Sprzedawca może dokonać wymiany, gdy Klient będący Konsumentem żąda naprawy, lub dokonać naprawy, gdy Konsument żąda wymiany, jeżeli doprowadzenie do zgodności Produktu z umową w sposób wybrany przez Konsumenta jest niemożliwe lub wymagałoby nadmiernych kosztów do Sprzedawcy. Jeżeli naprawa i wymiana są niemożliwe lub wymagałyby nadmiernych kosztów dla Sprzedawcy, może on odmówić doprowadzenia Produktu do zgodności z umową.</p>

        <p>10. Klient będący Konsumentem udostępni Sprzedawcy Produkt podlegający naprawie lub wymianie. Sprzedawca odbiera od Klienta będącego Konsumentem towar na swój koszt.</p>

        <p>11. Jeżeli Produkt jest niezgodny z umową, Konsument może złożyć oświadczenie o obniżeniu ceny albo odstąpieniu od umowy, gdy:</p>

                <ul style="margin-left: 40px;"</ul>
                        <li>Sprzedawca odmówił doprowadzenia Produktu do zgodności z umową zgodnie z ust. 9,</li>

                        <li>Sprzedawca nie doprowadził Produktu do zgodności z umową zgodnie z art. 43d ust. 4-6 ustawy o prawach konsumenta,</li>

                        <li>brak zgodności Produktu z umową występuje nadal, mimo że Sprzedawca próbował doprowadzić towar do zgodności z umową,</li>

                        <li>brak zgodności Produktu z umową jest na tyle istotny, że uzasadnia obniżenie ceny albo odstąpienie od umowy bez uprzedniego skorzystania ze środków ochrony określonych w art. 43d ustawy o prawach konsumenta,</li>

                        <li>z oświadczenia Sprzedawcy lub okoliczności wyraźnie wynika, że nie doprowadzi on Produktu do zgodności z umową w rozsądnym czasie lub bez nadmiernych niedogodności dla Klienta będącego Konsumentem.</li>
                </ul>

        <p>12. Obniżona cena pozostaje w takiej proporcji do ceny wynikającej z umowy, w jakiej wartość Produktu niezgodnego z umową pozostaje do wartości Produktu zgodnego z umową.</p>

        <p>13. Sprzedawca zwraca Konsumentowi kwoty należne wskutek skorzystania z prawa obniżenia ceny niezwłocznie, nie później niż w terminie 14 dni od dnia otrzymania oświadczenia Konsumenta o obniżeniu ceny.</p>

        <p>14. Klient nie może odstąpić od umowy, jeżeli brak zgodności Produktu z umową jest nieistotny. Domniemywa się jednak, że brak zgodności Produktu z umową jest istotny.</p>

        <p>15. Jeżeli brak zgodności z umową dotyczy jedynie niektórych Produktów dostarczonych na podstawie umowy Klient będący Konsumentem może odstąpić od umowy jedynie w odniesieniu do tych Produktów, a także w odniesieniu do innych Produktów nabytych przez konsumenta wraz z Produktami niezgodnymi z umową, jeżeli nie można rozsądnie oczekiwać, aby Konsument zgodził się zatrzymać wyłącznie Produkty zgodne z umową.</p>

        <p>16. W razie odstąpienia od umowy Konsument niezwłocznie zwraca Produkt Sprzedawcy na jego koszt. Sprzedawca zwraca Konsumentowi cenę niezwłocznie, nie później niż w terminie 14 dni od dnia otrzymania Produktu lub dowodu jego odesłania.</p>

        <p>17. Sprzedawca dokonuje zwrotu ceny przy użyciu takiego samego sposobu zapłaty, jakiego użył Konsument, chyba że Konsument wyraźnie zgodził się na inny sposób zwrotu, który nie wiąże się dla niego z żadnymi kosztami.</p>

        <p>18. Konsument może powstrzymać się z zapłatą ceny do chwili wykonania przez Sprzedawcę obowiązków, o których mowa w ustępach powyższych.</p>

        <p>19. W przypadku pozytywnego rozpatrzenia reklamacji Sprzedawca podejmie działania, zgodnie z treścią reklamacji Klienta lub inne działania w ramach  obowiązujących przepisów prawa.</p>

        <p>20. W przypadku negatywnego rozpatrzenia reklamacji,  Klient otrzyma odpowiedź, zawierającą informację o powodach braku uznania reklamacji za zasadną, drogą elektroniczną na adres e-mail, podany przez Klienta przy składaniu zamówienia. Sprzedawca następnie prześle  Produkt, na adres Klienta,  z którego została wysłana reklamacja (chyba że Klient poda inny adres do zwrotu).</p>

        <p>21. Klient jest uprawniony do złożenia reklamacji z tytułu gwarancji w odniesieniu do Produktów, na które został udzielona gwarancja przez producenta  lub dystrybutora (informacja o objęciu Produktu gwarancją znajduje się każdorazowo na podstronie Produktu).</p>

        <p>22. Sprzedawca ponadto dostarcza także treści lub usługi cyfrowe do których zastosowanie mają szczegółowe przepisy wynikające z art. 43 h i następnych ustawy o prawach konsumenta.</p>

        <p>23. Sprzedawca odpowiada za brak zgodności z umową treści lub usługi cyfrowej dostarczanej jednorazowo lub w częściach, jeżeli brak ten istniał w chwili jej dostarczenia i ujawnił się w ciągu dwóch lat od dostarczenia. Domniemywa się, że brak zgodności treści cyfrowej lub usługi cyfrowej z umową, który ujawnił się przed upływem roku od chwili dostarczenia treści cyfrowej lub usługi cyfrowej, istniał w chwili jej dostarczenia.</p>

        <p>24. Jeżeli treść cyfrowa lub usługa cyfrowa są niezgodne z umową, Konsument może żądać doprowadzenia do ich zgodności z umową.</p>

        <p>25. Sprzedawca może odmówić doprowadzenia treści cyfrowej lub usługi cyfrowej do zgodności z umową, jeżeli doprowadzenie do  zgodności treści cyfrowej lub usługi cyfrowej z umową jest niemożliwe albo wymagałoby nadmiernych kosztów dla Sprzedawcy.</p>

        <p>26. Sprzedawca doprowadza treść cyfrową lub usługę cyfrową do zgodności z umową w rozsądnym czasie od chwili, w której Sprzedawca został poinformowany przez Konsumenta o braku zgodności z umową, i bez nadmiernych niedogodności dla Konsumenta, uwzględniając ich charakter oraz cel, w jakim są wykorzystywane. Koszty doprowadzenia treści cyfrowej lub usługi cyfrowej do zgodności z umową ponosi Sprzedawca.</p>

        <p>27. Jeżeli treść cyfrowa lub usługa cyfrowa są niezgodne z umową, Konsument może złożyć oświadczenie o obniżeniu ceny albo odstąpieniu od umowy, gdy:</p>

                <ul style="margin-left: 40px;"</ul>
                        <li>doprowadzenie do zgodności treści cyfrowej lub usługi cyfrowej z umową jest niemożliwe albo wymaga nadmiernych kosztów stosownie do art. 43m ust. 2 i 3 ustawy o prawach konsumenta,</li>

                        <li>Sprzedawca nie doprowadził treści cyfrowej lub usługi cyfrowej do zgodności z umową zgodnie ust. 26,</li>

                        <li>brak zgodności treści cyfrowej lub usługi cyfrowej z umową występuje nadal, mimo że Sprzedawca próbował doprowadzić treść cyfrową lub usługę cyfrową do zgodności z umową;</li>

                        <li>brak zgodności treści cyfrowej lub usługi cyfrowej z umową jest na tyle istotny, że uzasadnia obniżenie ceny albo odstąpienie od umowy bez uprzedniego skorzystania ze środka ochrony określonego w art. 43m ustawy o prawach konsumenta,</li>

                        <li>z oświadczenia Sprzedawcy lub okoliczności wyraźnie wynika, że nie doprowadzi on treści cyfrowej lub usługi cyfrowej do zgodności z umową w rozsądnym czasie lub bez nadmiernych niedogodności dla Konsumenta.</li>
                </ul>

        <h2>XIII. Prawa zastrzeżone.</h2>

        <p>1. Wszelkie prawa własności, w tym prawo własności intelektualnej do nazwy i znaku towarowego, prawa autorskie do treści, zdjęć, nazw produktów, grafik i innych materiałów zamieszczonych na stronie Apteki Internetowej, a także do elementów technicznych i wszelkich innych części serwisu, za wyjątkiem treści w zakresie prezentacji danego Produktu (w tym zdjęć i logotypów Produktów), należą do Sprzedającego. Prawa do treści, w tym prawa autorskie do zdjęć, grafik oraz logotypów w zakresie prezentacji danego Produktu należą do ich producentów lub innych uprawnionych podmiotów. Każdorazowe użycie powyższych elementów w jakiejkolwiek formie wymaga pisemnej zgody właściciela.</p>

        <p>2. Zabronione jest jakiekolwiek wykorzystywanie danych dostępnych na stronie Apteki Internetowej  w zakresie wykraczającym poza uprawnienia przewidziane niniejszym Regulaminem. Jakiekolwiek wykorzystywanie lub przetwarzanie danych lub informacji dostępnych na Portalu musi być zgodne z postanowieniami Regulaminu oraz przepisami obowiązującego prawa.</p>

        <h2>XIV. Postanowienia końcowe.</h2>

        <p>1. Klient jest obowiązany do akceptacji niniejszego Regulaminu oraz załączników przy rejestracji na stronie Apteki Internetowej lub złożenia zamówienia bez rejestracji.</p>

        <p>2. Administrator jest uprawniony do zmian Regulaminu, o czym powiadamia Klienta poprzez przesłanie zmienionej wersji Regulaminu na adres e-mail, wskazany przez Klienta oraz przy pierwszym logowaniu Klienta, dokonanym od wejścia w życie Regulaminu.</p>

        <p>3. Zmiany Regulaminu wchodzą w życie w terminie 14 dni od dnia ich przesłania na adres e-mail Klientów. Produkty lub usługi opłacone przed wejściem w życie Regulaminu, będą realizowane na podstawie postanowień, obowiązujących w dniu ich zakupu.</p>

        <p>4. Jeżeli którekolwiek z postanowień Regulaminu uznane zostanie za nieważne, niezgodne z prawem lub niewykonalne, nie będzie to mieć wpływu na ważność, zgodność z prawem i wykonalność pozostałych postanowień.</p>

        <p>5. Administrator jest uprawniony do kontaktu z Klientem drogą elektroniczną, przesyłając wiadomość na adres e-mail podany przy Rejestracji.</p>

        <p>6. Sprzedawca niniejszym informuje Konsumentów o możliwości skorzystania z pozasądowych sposobów rozpatrywania reklamacji i dochodzenia roszczeń. Zasady dostępu do tych procedur dostępne są w siedzibach lub na stronach internetowych podmiotów uprawnionych do pozasądowego rozpatrywania sporów. W szczególności podmiotami uprawnionymi do pozasądowego rozpatrywania sporów są:</p>

                <ul style="margin-left: 40px;"</ul>
                        <li>rzecznicy praw konsumenta</li>
                        <li>Wojewódzkie Inspektoraty Inspekcji Handlowej</li>
                </ul>

        <p>Lista wymienionych powyżej podmiotów jest dostępna na stronie internetowej <a href="#">Urzędu Ochrony Konkurencji i Konsumentów</a>. Sprzedawca informuje, że pod adresem <a href="http://ec.europa.eu/consumers/odr/">http://ec.europa.eu/consumers/odr/</a> dostępna jest platforma internetowego systemu rozstrzygania sporów pomiędzy konsumentami i przedsiębiorcami na szczeblu unijnym (platforma ODR).</p>

        <p>7. W sprawach nieuregulowanych w niniejszym Regulaminie zastosowanie mają powszechnie obowiązujące przepisy prawa polskiego oraz inne właściwe przepisy powszechnie obowiązującego prawa.</p>

        <p>8. Załączniki stanowią integralną treść Regulaminu.</p>

        <p>9. W przypadku sporów, powstałych na gruncie niniejszego Regulaminu lub zawartych umów sprzedaży, strony będą dążyły do rozwiązania sprawy polubownie.</p>

        <p>10. Regulamin wchodzi w życie z dniem 1.12.2025.</p>
    </div>
</div>
@endsection