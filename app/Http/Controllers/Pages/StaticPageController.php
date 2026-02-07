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
        $viewData['content'] = 'Apteka Wracam do Zdrowia funkcjonuje na rynku już od ponad 30 lat. W sprzedaży posiadamy między innymi artykuły higieniczne, dermokosmetyki przeznaczone do różnych potrzeb skóry, leki bez recepty, suplementy diety, sprzęt medyczny, jak również zioła i preparaty ziołowe. Można tutaj zamówić z wygodną dostawą do domu ciśnieniomierz, inhalator, wybrany test diagnostyczny, tabletki łagodzące objawy alergii, środki przeciwbólowe, żel na ukąszenia owadów, witaminy, minerały, elektrolity oraz wiele innych artykułów. Zapraszamy do zapoznania się z ofertą.';
        
        return view('pages.static-page',$viewData);
    }
    
    public function politykaPrywatnosciPage(){
        $viewData = [];
        $viewData['title'] = 'Polityka prywatności oraz mechanizm cookies Apteki Internetowej Wracam do zdrowia';
        $viewData['content'] = '';
        return view('pages/polityka-prywatnosci',$viewData);
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
        $sectionData = [];
        $viewData['content'] = view('pages/informacje',$sectionData);
        $viewData['title'] = 'Informacje';
        
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
        $sectionData = [];
        $viewData['content'] = view('pages/kontakt',$sectionData);
        $viewData['title'] = 'Kontakt';
        
        return view('pages.static-page',$viewData);
    }
    
    public function regulaminNewsletteraPage(){
        $viewData = [];
        $viewData['title'] = 'Regulamin Newslettera Apteki Internetowej esklep.wdoz.pl';
        $viewData['content'] = '
                    <p align="center">&nbsp;</p>

<p align="center"><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;"><strong>§ 1</strong></span></span></p>

<p><span style="font-size:18px;"><span style="font-family:times new roman,times,serif;">Niniejszy regulamin usługi Newsletter, zwanym dalej „Regulaminem”, określa zasady świadczenia tej usługi przez Aptekę Internetową Wracam Do Zdrowia, którego właścicielem jest „Wracam do zdrowia 8” spółka z ograniczoną odpowiedzialnością, adres: ul. Remusa 6, 81-574 Gdynia, zwany dalej „Usługodawcą”.</span></span></p>

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
        $sectionData = [];
        $viewData['content'] = view('pages/reklamacje-zwroty',$sectionData);
        $viewData['title'] = 'Reklamacje i zwroty';
        
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
        $sectionData = [];
        $viewData['content'] = view('pages/koszty-dostawy',$sectionData);
        $viewData['title'] = 'Koszty dostawy';
        
        return view('pages.static-page',$viewData);
    }
    
    
}
