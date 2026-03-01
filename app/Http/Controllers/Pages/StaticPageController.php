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
        $viewData['content'] = '';

        return view('pages.apteka-internetowa',$viewData);
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
        $viewData['content'] = '';

        return view('pages.dane-wojewodzkiego-inspektoratu',$viewData);
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
        $viewData['title'] = 'Regulamin Newslettera Apteki Internetowej wracamdozdrowia.pl';
        $viewData['content'] = '';

        return view('pages.regulamin-newsletera',$viewData);
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
        $viewData['content'] = '';

        return view('pages.platnosci',$viewData);
    }

    public function kosztyDostawyPage(){
        $viewData = [];
        $sectionData = [];
        $viewData['content'] = view('pages/koszty-dostawy',$sectionData);
        $viewData['title'] = 'Koszty dostawy';

        return view('pages.static-page',$viewData);
    }


}
