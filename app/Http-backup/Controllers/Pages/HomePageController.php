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

class HomePageController extends Controller
{
    public function __construct()
    {

    }
    

    
    public function showHomePage(Request $request){
        $viewData = [];
        $user = Auth::user();
        
        $userId = Auth::id();
        
        $viewData['userdata'] = AuthController::getUserData($request, Auth::id(), true);
        
        $topSlider = DB::connection('mysql-esklep')->select('SELECT slider.*, media.provider_reference as image, mediaMobile.provider_reference as imageMobile FROM slider '
                . ' LEFT JOIN media__media as media ON slider.media_id = media.id '
                . ' LEFT JOIN media__media as mediaMobile ON slider.media_mobile_id = mediaMobile.id ORDER BY id DESC', []);
        $viewData['topSlider'] = $topSlider;
        
        $specialProducts = new Products();
        $specialProducts->getProducts('is_special_offer = ? AND is_active = ? ORDER BY special_offer_order ASC', [1,1], 99);
        $viewData['specialProducts'] = $specialProducts->products;
        $viewData['productsObject'] = $specialProducts;
        
        $bestSellersProducts = new Products();
        $bestSellersProducts->getProducts('is_bestseller = ? AND is_active = ? ORDER BY special_offer_order ASC', [1,1], 99);
        $viewData['bestSellersProducts'] = $bestSellersProducts->products;
        
        
        $shortExpirationDatesProducts = new Products();
        $shortExpirationDatesProducts->getProducts('is_bestseller2 = ? AND is_active = ? ORDER BY special_offer_order ASC', [1,1]);
        $viewData['shortExpirationDatesProducts'] = $shortExpirationDatesProducts->products;
        
        $topCategories = DB::connection('mysql-esklep')->select('SELECT name, slug, image_desktop, image_mobile, color FROM ecommerce_categories '
                . ' WHERE show_on_home_page = 1 ORDER BY show_on_home_page_order DESC LIMIT 6', []);
        $viewData['topCategories'] = $topCategories;
        
        return view('pages.home-page',$viewData);
    }
    
    
    
    
    
}
