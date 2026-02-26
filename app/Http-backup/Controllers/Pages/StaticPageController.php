<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Email;
use App\Models\Products;
use App\Http\Controllers\globalHelper\globalHelper;
use Config;

class StaticPageController extends Controller
{
    public function __construct()
    {

    }
    

    
    public function mbankTest(Request $request){
        $viewData = [];
        $viewData['title'] = 'tu będzie płatność...';
        $viewData['content'] = 'tu będzie płatność za pomocą mbank<br><a href="/">wróć do strony głównej</a>';
        
        return view('pages.static-page',$viewData);
    }
    
    public function aptekaInternetowaPage(){
        $viewData = [];
        $viewData['title'] = 'Apteka internetowa';
        $viewData['content'] = 'Apteka Wracam do zdrowia funkcjonuje na rynku już od ponad 30 lat. W sprzedaży posiadamy między innymi artykuły higieniczne, dermokosmetyki przeznaczone do różnych potrzeb skóry, leki bez recepty, suplementy diety, sprzęt medyczny, jak również zioła i preparaty ziołowe. Można tutaj zamówić z wygodną dostawą do domu ciśnieniomierz, inhalator, wybrany test diagnostyczny, tabletki łagodzące objawy alergii, środki przeciwbólowe, żel na ukąszenia owadów, witaminy, minerały, elektrolity oraz wiele innych artykułów. Zapraszamy do zapoznania się z ofertą.';
        
        return view('pages.static-page',$viewData);
    }
    
    public function politykaPrywatnosciPage(){
        $viewData = [];
        $viewData['title'] = 'Polityka prywatności oraz mechanizm cookies Apteki Internetowej Wracam do zdrowia';
        $viewData['content'] = '<p><a href="/pdf/Polityka_prywatnosci.pdf" style="font-size: 20px;" target="_blank">Polityka prywatnosci (.pdf)</a></p>';
        
        return view('pages.static-page',$viewData);
    }
    
    public function daneWojewódzkiegoInspektoratuPage(){
        $viewData = [];
        $viewData['title'] = 'Dane Wojewódzkiego Inspektoratu Farmaceutycznego';
        $viewData['content'] = '<div class="content">
                    <p>Apteka Internetowa wdoz.pl objęta jest nadzorem Wojewódzkiego Inspektoratu Farmaceutycznego w Gdańsku:</p>

<p>Wojewódzki Inspektorat Farmaceutyczny w Gdańsku<br>
ul. Na Stoku 50<br>
80-874 Gdańsk<br>
tel: 58-300-00-92, 58-300-00-93<br>
fax: 58-320-28-58<br>
email: sekretariat@wiif.gdansk.pl</p>
                </div>';
        
        return view('pages.static-page',$viewData);
    }
    
    public function informacjePage(){
        $viewData = [];
        $viewData['title'] = 'Informacje';
        $viewData['content'] = '
                    <h2>Logowanie:</h2>

<p>Do apteki internetowej wdoz.pl możesz zalogować się na swoje konto klikając ikonę: <svg class="logged-svg" height="15" viewBox="0 0 3.969 3.969" width="15" xmlns="http://www.w3.org/2000/svg"> <g fill="none" stroke="#008641" stroke-width=".27" transform="translate(0 -293.031)"> <ellipse cx="-3.747" cy="294.481" rx=".926" ry="1.091" stroke-linejoin="bevel" transform="skewX(1.113) scale(1 .99981)"></ellipse> <path d="M2.622 295.724h.709l.33.342v.65l-.082.071h-.603.59l.107-.07-.023-.65-.343-.355zM1.353 295.718H.645l-.331.343v.65l.082.07H1h-.59l-.107-.07.024-.65.342-.354z" stroke-linejoin="round"></path> <path d="M1 296.781l2.077.006z"></path> </g> </svg> „konto użytkownika-logowanie”, znajdującą się w górnym prawym rogu strony internetowej apteki wdoz.pl. Po kliknięciu zostaniesz przeniesiony na stronę logowania:</p>

<p><img alt="przykład logowania - esklep wdoz" class="informcje-page-img1" src="/img/logowanie-examle.png"></p>

<p>W polu „E-mail” należy wpisać swój adres e-mail podany podczas rejestracji, a w polu „hasło” należy podać hasło podane podczas rejestracji. Następnie należy kliknąć na przycisk „Zaloguj się” i zostaniesz przeniesiony do apteki wdoz.pl.</p>

<p>Jeżeli nie pamiętasz hasła podanego podczas rejestracji, kliknij „nie pamiętam hasła”. Wpisz adres e-mail podany podczas rejestracji w pole „wpisz adres e-mail” i kliknij przycisk „Przypomnij hasło”. Na podany adres e-mail zostanie wysłana wiadomość zawierająca link, w który należy kliknąć aby zresetować hasło. Zostaniesz przeniesiony na stronę apteki wdoz.pl, na której podasz nowe hasło.</p>

<p><img alt="przykład zmiany hasła - esklep wdoz" class="informcje-page-img2" src="/img/zmia-hasla-example.png"></p>

<h2>Rejestracja:</h2>

<p>Aby zarejestrować się do apteki internetowej wdoz.pl należy klikną ikonę <svg class="logged-svg" height="15" viewBox="0 0 3.969 3.969" width="15" xmlns="http://www.w3.org/2000/svg"> <g fill="none" stroke="#008641" stroke-width=".27" transform="translate(0 -293.031)"> <ellipse cx="-3.747" cy="294.481" rx=".926" ry="1.091" stroke-linejoin="bevel" transform="skewX(1.113) scale(1 .99981)"></ellipse> <path d="M2.622 295.724h.709l.33.342v.65l-.082.071h-.603.59l.107-.07-.023-.65-.343-.355zM1.353 295.718H.645l-.331.343v.65l.082.07H1h-.59l-.107-.07.024-.65.342-.354z" stroke-linejoin="round"></path> <path d="M1 296.781l2.077.006z"></path> </g> </svg> „konto użytkownika-logowanie”, znajdującą się w górnym prawym rogu strony internetowej apteki wdoz.pl.</p>

<p><img alt="ikona logowania - esklep wdoz" class="informcje-page-img3" src="/img/rejestracja-example.png"></p>

<p>Następnie należy wypełnić formularz rejestracyjny, przeczytać i zaakceptować regulamin serwisu wdoz.pl, a następnie kliknąć przycisk „Zarejestruj się”. Pojawi się komunikat:</p>

<p><strong>Konto zostało utworzone prawidłowo. Na Twój adres e-mail: xxx przesłaliśmy link do aktywacji konta. Aktywuj konto klikając w link, a następnie zaloguj się.</strong></p>

<p>Po kliknięciu w otrzymany link zaloguj się do apteki wdoz.pl wpisując adres e-mail oraz hasło podane przy rejestracji.</p>

<p>Po złożeniu zamówienia i zakończeniu przeglądania oferty apteki wyloguj się klikając ikonę <strong>„wyloguj”</strong>.</p>

<p>Zalety posiadania konta w aptece internetowej wdoz.pl:</p>

<ul>
	<li>Pełna historia zamówień</li>
	<li>Możliwość samodzielnej zmiany adresu dostawy oraz danych teleadresowych</li>
	<li>Szybsze i wygodniejsze zakupy.</li>
</ul>

<p>Zachęcamy do prenumeraty Newslettera apteki internetowej wdoz.pl. Dzięki temu będziemy Cię informować na bieżąco o wszelkich promocjach i nowościach w ofercie apteki.</p>

<h2>Koszyk</h2>

<p>Koszyk to miejsce, w którym znajdują się wybrane produkty od momentu ich dodania do czasu złożenia zamówienia.</p>

<p>Produkty znajdujące się w koszyku można:</p>

<ul>
	<li>usunąć z koszyka</li>
	<li>zmienić ich ilość za pomocą znaków „^ lub v” w kolumnie „liczba”</li>
	<li>sprawdzić ich cenę oraz wartość dodanych produktów.</li>
</ul>

<p>Jeżeli sprawdziliśmy produkty w koszyku i chcemy kontynuować zamówienie, wówczas klikamy przycisk „Złóż zamówienie” i przechodzimy do kolejnego etapu realizacji zamówienia.</p>

<p><strong>Dodanie wybranych produktów do koszyka nie jest równoznaczne ze złożeniem zamówienia.</strong></p>

<h2>Newsletter</h2>

<p>Jeżeli chcesz otrzymywać informacje o promocjach, nowościach, bieżących doniesieniach medycznych w aptece wdoz.pl, wpisz swój adres e-mail w okienko Newslettera, zaakceptuj regulamin serwisu wdoz.pl i kliknij strzałkę.</p>

<p><img alt="zapis do newslettera - esklep wdoz" class="informcje-page-img4" src="/img/newsletter-example.png"></p>

<p>Na podany adres e-mail otrzymasz potwierdzenie zapisania się do Newslettera. Jeżeli chcesz zrezygnować z subskrypcji, można tego dokonać klikając na podany w e-mailu link lub wysyłając wiadomość o rezygnacji na adres info@datum.pl.</p>

<p>Dane z Newslettera będą przetwarzane zgodnie z polityką prywatności apteki Wracam do zdrowia.</p>
                ';
        
        return view('pages.static-page',$viewData);
    }
    
    public function regulaminPage(){
        $viewData = [];
        $viewData['title'] = 'REGULAMIN APTEKI INTERNETOWEJ WRACAM DO ZDROWIA';
        $viewData['content'] = '';
        return view('pages/regulamin-page',$viewData);
    }
    
    public function kontaktPage(){
        $viewData = [];
        $viewData['title'] = 'Kontakt';
        $viewData['content'] = '<div class="content">
                    <p class="text-center text-big-bold">Apteka Internetowa wdoz.pl<br>
Plac Górnośląski 16<br>
81-509 Gdynia</p>

<p><strong>Biuro obsługi klienta.</strong><br>
Telefon: <strong>585 731 741</strong><br>
Czynne od poniedziałku do piątku w godzinach 8:00 – 19:00.<br>
e-mail: <a href="mailto:apteka@wdoz.pl">apteka@wdoz.pl</a></p>

<p><strong>Dział handlowy.</strong><br>
Wszystkie firmy farmaceutyczne zainteresowane współpracą oraz dystrybutorzy<br>
kosmetyków i artykułów zapraszamy do kontaktu: <a href="mailto:biuro@wdoz.pl">biuro@wdoz.pl</a>.</p>

<p><strong>Dział informatyczny.</strong><br>
Uwagi lub pytania dotyczące działania strony internetowej prosimy kierować na adres: <a href="mailto:biuro@wdoz.pl">biuro@wdoz.pl</a>.</p>

<p>&nbsp;</p>
                </div>';
        
        return view('pages.static-page',$viewData);
    }
    
    public function regulaminNewsletteraPage(){
        $viewData = [];
        $viewData['title'] = 'Regulamin Newslettera Apteki Internetowej esklep.wdoz.pl';
        $viewData['content'] = '
                    <p align="center">&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 1</strong></span></span></p>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Niniejszy regulamin usługi Newsletter, zwanym dalej „Regulaminem”, określa zasady świadczenia tej usługi przez Aptekę Internetową Wracam do zdrowia, którego właścicielem jest „Wracam do zdrowia 8” spółka z ograniczoną odpowiedzialnością, adres: ul. Remusa 6, 81-574 Gdynia, zwany dalej „Usługodawcą”.</span></span></p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 2</strong></span></span></p>

<ol>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Usługa Newsletter polega na przesyłaniu przez Usługodawcę na podany przez użytkownika tej usługi adres e-mail wiadomości mailowych zawierających informacje dotyczące nowych ofert sklepu internetowego prowadzonego przez Usługodawcę, promocji wprowadzanych w tym sklepie czy innych informacji, które mogłyby zainteresować konsumenta.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Użytkownik poprzez zawarcie umowy o świadczenie usługi Newsletter z Usługodawcą, dobrowolnie udostępnia swój adres e-mail, podany w formularzu rejestracyjnym, jedynie w celu otrzymywania wiadomości mailowych,&nbsp;o których mowa w ustępie powyżej.</span></span></li>
</ol>

<p>&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 3</strong></span></span></p>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Usługa Newsletter jest bezpłatna.</span></span></p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 4</strong></span></span></p>

<ol>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Użytkownikiem usługi Newsletter może zostać każda pełnoletnia osoba, która na stronie esklep.wdoz.pl w części dotyczącej Newslettera poda swój adres e-mail, a następnie kliknie przycisk „Zapisz”. Kliknięcie wskazanego przycisku powoduje przesłanie podanego adresu e-mail do Usługodawcy i nie powoduje jeszcze zawarcia umowy o korzystanie z usługi Newsletter.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">W następnym kroku Usługodawca na podany adres e-mail wyśle mail aktywacyjny. W jego treści będzie wskazana treść niniejszego Regulaminu. Przyjmuje się, że przesłany e-mail stanowi ofertę zawarcia umowy o korzystanie z usługi Newsletter. Kliknięcie w link znajdujący się w tym mailu oznacza akceptację Regulaminu i powoduje przyjęcie oferty złożonej przez Usługodawcę, co jest równoznaczne z zawarciem umowy o korzystanie z usługi Newsletter.</span></span></li>
</ol>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">&nbsp;&nbsp;</span></span></p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 5</strong></span></span></p>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Umowa o korzystanie z usługi Newsletter zostaje zawarta na czas nieokreślony.&nbsp;</span></span></p>

<p>&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 6</strong></span></span></p>

<ol>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Użytkownikowi przyznaje się prawo do wypowiedzenia w każdym czasie umowy o korzystanie z usługi Newsletter. Wypowiedzenie takowe ma skutek natychmiastowy.</span></span></li>
	<li value="2"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Użytkownik może wypowiedzieć umowę o korzystanie z&nbsp; Usługi&nbsp; Newslettera (zrezygnować z otrzymywania Newslettera) w każdym czasie, poprzez skierowanie oświadczenia w tym przedmiocie na adres mailowy: apteka@wdoz.pl lub pocztą tradycyjną na adres Usługodawcy podany w § 1 niniejszego Regulaminu.</span></span></li>
</ol>

<p align="center">&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 7</strong></span></span></p>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Do korzystania z usługi Newsletter konieczny jest dostęp do sieci Internet oraz posiadanie adresu&nbsp;e-mail, natomiast nie jest konieczne spełnienie szczególnych wymagań technicznych poza posiadaniem standardowego systemu operacyjnego oraz standardowej przeglądarki internetowej.</span></span></p>

<p>&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 8</strong></span></span></p>

<ol>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Ewentualne reklamacje należy składać na adres mailowy:&nbsp;apteka@wdoz.pl lub pocztą tradycyjną bezpośrednio na adres Usługodawcy podany w § 1 Regulaminu.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">W reklamacji należy podać dane osoby zgłaszającej reklamację, niezbędne do przesłania informacji o wyniku rozpatrzenia reklamacji oraz opis na czym polegały nieprawidłowości w usłudze Newsletter, świadczonej przez Usługodawcę.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Reklamacja rozpatrzona zostanie w terminie 14 dni od dnia jej otrzymania.</span></span></li>
</ol>

<p>&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 9</strong></span></span></p>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Rozpoczęcie świadczenia usługi Newsletter nastąpi niezwłocznie po zawarciu umowy o korzystanie&nbsp;z usługi Newsletter, na co jej użytkownik wyraża niniejszym zgodę.</span></span></p>

<p>&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 10</strong></span></span></p>

<ol>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Administratorem danych osobowych udostępnionych przez użytkownika jest: „Wracam do zdrowia 8” sp. z o.o., adres:&nbsp;ul. Remusa 6, 81-574 Czersk.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Kontakt z Administratorem możliwy jest w szczególności pod adresem wskazanym powyżej lub pod adresem email:&nbsp;ido@wracamdozdrowia.pl.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Podanie danych osobowych jest dobrowolne.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Dane będą przetwarzane na podstawie udzielonej zgody w celu świadczenia usługi Newsletter.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Dane osobowe użytkownika będą przechowywane do momentu odwołania udzielonej zgody lub do ustania prawnie usprawiedliwionego celu administratora.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Użytkownikowi przysługuje&nbsp; prawo dostępu do swoich danych, prawo do ich sprostowania oraz do ich usunięcia po ustaniu okresu archiwizacji danych.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Ponadto użytkownikowi przysługuje także prawo do wniesienia skargi do Prezesa Urzędu Ochrony Danych Osobowych.</span></span></li>
</ol>

<p>&nbsp;</p>

<p style="margin-left:18.0pt;">&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 11</strong></span></span></p>

<ol>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Usługodawca zastrzega sobie prawo do zmiany Regulaminu.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Informacje o zmianie Regulaminu, będą komunikowane Użytkownikom poprzez indywidualną wiadomość e-mail skierowaną bezpośrednio na adres e-mail danej osoby.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Zmiany regulaminu wchodzą w życie z dniem ich ogłoszenia na portalu: esklep.wdoz.pl.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Prawem właściwym dla wszystkich stosunków prawnych wynikających z niniejszego Regulaminu jest prawo polskie. Wszelkie spory będą rozstrzygane przez właściwe miejscowo polskie sądy powszechne.</span></span></li>
	<li><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Niniejszy Regulamin wchodzi w życie z dniem 30.04.2023.</span></span></li>
</ol>
                ';
        
        return view('pages.static-page',$viewData);
    }
    
    
    public function reklamacjezwrotyPage(){
        $viewData = [];
        $viewData['title'] = 'Reklamacje i zwroty';
        $viewData['content'] = '<div class="content">
                    <h2>Reklamacje</h2>

<p>Kupujący ma prawo do zgłoszenia reklamacji zgodnie z Regulaminem apteki internetowej wdoz.pl.</p>

<p>Reklamacje prosimy składać drogą mailową na adres: <a href="mailto:reklamacje@wdoz.pl">reklamacje@wdoz.pl</a>. Reklamacja powinna zawierać dokładny opis reklamacji, numer zamówienia oraz dane klienta.</p>

<p>Reklamacje rozpatrywane są w ciągu 14 dni od dnia otrzymania reklamowanego towaru. Po rozpatrzeniu reklamacji skontaktuje się z Państwem pracownik Działu Obsług Klienta i przekaże decyzję reklamacyjną oraz wszelkie niezbędne informacje.</p>

<p>Pliki do pobrania:</p>

<p><a href="/downloads/formularz_reklamacyjny.docx">Formularz reklamacyjny (.docx)</a></p>

<h2>&nbsp;</h2>

<h2>Zwroty</h2>

<p>Klient ma prawo odstąpienia od niniejszej umowy w terminie 14 dni bez podania jakiejkolwiek przyczyny.</p>

<p>Termin do odstąpienia od umowy wygasa po upływie 14 dni od dnia, w którym weszli państwo w posiadanie rzeczy lub w którym osoba trzecia inna niż przewoźnik i wskazana przez Państwa weszła w ich posiadanie.</p>

<p>Zwracany towar musi być w stanie nienaruszonym. Klient ponosi bezpośrednie koszty zwracanego towaru.</p>

<p><span style="color:#FF0000;"><strong>Produkty lecznicze, środki spożywcze specjalnego przeznaczenia żywieniowego i wyroby medyczne wydane z Apteki Internetowej nie podlegają zwrotowi, &nbsp;za wyjątkiem&nbsp; produktu leczniczego lub wyrobu medycznego zwracanego z powodu wady jakościowej, niewłaściwego ich wydania lub sfałszowania produktu leczniczego.</strong></span></p>

<p>Pliki do pobrania:</p>

<p><a href="/downloads/pouczenie_o_prawie_odstapienia_od_umowy.docx">Pouczenie o odstąpieniu od umowy (.docx)</a></p>

<p><a href="/downloads/Formularz-odstapienia-od-umowy-sprzedazy-wdoz.docx">Formularz odstąpienia od umowy sprzedaży (.docx)</a></p>
                </div>';
        
        return view('pages.static-page',$viewData);
    }
    
    public function platnosciPage(){
        $viewData = [];
        $viewData['title'] = 'Płatności';
        $viewData['content'] = '<div class="content">
                    <p>Za zakupy dokonane w aptece internetowej wdoz.pl można zapłacić poprzez:</p>

<table class="payment-page-table">
	<tbody>
		<tr>
			<td style="border: none;"><img alt="paynow - logo" src="/images/paynow-payments.png" style="width: 1000px;"></td></tr><tr>
			<td style="border: none; padding: 0px;">Płatność online PayNow oferująca wszystkie najpopularniejsze płatności internetowe, jak: przelew elektroniczny z większości banków, karty płatnicze, portfele elektroniczne. Jest to bezpieczny i najszybszy sposób zapłaty za zamówienie.</td>
		</tr>
	</tbody>
</table>

<p>PayNow gwarantuje&nbsp;pełne bezpieczeństwo.</p>
                </div>';
        
        return view('pages.static-page',$viewData);
    }
    
    public function kosztyDostawyPage(){
        $viewData = [];
        $viewData['title'] = 'Koszty dostawy';
        $viewData['content'] = '<div class="content">
                    <p>Wszystkie produkty zakupione w aptece internetowej wdoz.pl dostarczane są do Klienta za pośrednictwem firmy kurierskiej DPD&nbsp;(osobiście w punktach odbioru DPD Pickup),&nbsp;InPost oraz Orlen Paczka.</p>

<p>Zamówienia są realizowane od poniedziałku do piątku w godzinach od 7 do 15.</p>

<p>CZAS REALIZACJI ZAMÓWIENIA PRZEZ APTEKĘ DO CZASU WYSYŁKI&nbsp;- <strong>1-3 dni robocze</strong>&nbsp;+ CZAS DOSTARCZENIA PRZEZ WYBRANEGO DOSTAWCĘ -<strong>1-2 dni robocze</strong>.</p>

<table>
	<tbody>
		<tr>
			<td>Sposób dostawy</td>
			<td>Zamówienie do 249,00 zł</td>
			<td>Zamówienie powyżej 249,00 zł</td>
		</tr>
		<tr>
			<td>Kurier DPD</td>
			<td style="text-align: center;">13,99</td>
			<td>
			<p>bezpłatnie</p>
			</td>
		</tr>
		<tr>
			<td>InPost kurier</td>
			<td style="text-align: center;">14,99</td>
			<td>
			<p>bezpłatnie</p>
			</td>
		</tr>
		<tr>
			<td>Inpost paczkomat</td>
			<td style="text-align: center;">12,99</td>
			<td>
			<p>bezpłatnie</p>
			</td>
		</tr>
		<tr>
			<td>Orlen paczka</td>
			<td style="text-align: center;">9,99</td>
			<td>
			<p>bezpłatnie</p>
			</td>
		</tr>
	</tbody>
</table>

<p><strong>Apteka prowadzi sprzedaż wyłącznie na terenie Rzeczypospolitej Polskiej. Apteka nie prowadzi sprzedaży hurtowej, do hurtowni farmaceutycznych, do innych aptek i punktów aptecznych. Takie transakcje nie będą realizowane! Maksymalna ilość danego produktu zakupionego przez jednego pacjenta nie może przekroczyć 10&nbsp;sztuk.</strong></p>

<p>&nbsp;</p>
                </div>';
        
        return view('pages.static-page',$viewData);
    }
    
    
}
