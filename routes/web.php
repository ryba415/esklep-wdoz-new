<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms\SaveData;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Basket\BasketController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\User\UserAcountController;
use App\Http\Controllers\Pages\HomePageController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Basket\BasketApiController;
use App\Http\Controllers\Product\SearchController;
use App\Http\Controllers\Pages\StaticPageController;
use App\Http\Controllers\Product\FavoritesListController;
use App\Http\Controllers\Product\IntegrationsController;
use App\Http\Controllers\Wiedza\WiedzaController;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Cms\ExportData;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::controller(BasketApiController::class)->group(function () {
    Route::post('/add-to-basket/', "addToBasket")->name('addToBasket');
    Route::post('/remove-from-basket/', "removeFromBasket")->name('removeFromBasket');
    //Route::post('/get-basket-data/', "getBasketData")->name('getBasketData');
    Route::match(['get', 'post'], '/get-basket-data/', "getBasketData")->name('getBasketData');
    Route::post('/buy-now/', "buyNow")->name('buyNow');
    Route::post('/validate-delivery-data/', "validateDeliveryData")->name('validate-delivery-data');

});

Route::get('/clear-cache', function () {
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return 'Cache has clear successfully !';
});

Route::controller(BasketController::class)->group(function () {
    Route::get('/koszyk', "showBasket")->name('koszyk');
    Route::get('/koszyk-apteka', "showPharmacyConfirmation")->name('koszyk-apteka');
    Route::get('/dziekujemy-za-zakup', "thankYouPage")->name('dziekujemy-za-zakup');

});

Route::controller(AuthController::class)->group(function () {
    Route::post('/checkout-login/', "login")->name('login');
    Route::get('/logout/', "logout")->name('logout');
    Route::post('/logout/', "logout")->name('logout-post');
    Route::post('/register-new-user/', "registerNewUer")->name('register-new-user');
    Route::get('/repeat-send-activate-user-email/{email}', "resendActivateUserEmail")->name('repeat-send-activate-user-email');
    Route::get('/activate-acount/{hash}', "activateUserAcount")->name('activate-acount');

    Route::get('/reset-client-password', "resetPassword")->name('reset-client-password');
    Route::post('/reset-client-password-confirm', "resetPasswordConfirm")->name('reset-client-password-confirm');
    Route::get('/set-new-password/{hash}', "setNewPassword")->name('set-new-password');
    Route::post('/set-client-password-confirm', "setClientPasswordConfirm")->name('set-client-password-confirm');

    Route::post('/authenticate-admin-wwd2341', 'authenticateAdmin')->name('authenticate');
    Route::get('/login-admin-admin-wwd2341/', "loginAdmin")->name('login-admin');

});

Route::middleware(["auth:usercustom"])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/get-user-data/{ide}', "getUserData")->name('get-user-data');
    });

    Route::controller(UserAcountController::class)->group(function () {
        Route::get('/user-acount/dasboard', "showDashboard")->name('show-dashboard');

        Route::post('/user-acount/save-user-data', "saveUserData")->name('save-user-data');
    });

});
Route::middleware(["auth:usercustom-admin"])->group(function () {

    Route::controller(AdminDashboard::class)->group(function () {
        Route::get('/panel/dashboard', "showDashboard")->name('dashboard');

        /*slider*/
        Route::get('/panel/slides/', "slidersList")->name('sliders-list');
        Route::get('/panel/slides/slide-{id}','editSlide')->name('edit-slide');

        /*artykuły*/
        Route::get('/panel/articles/', "articlesList")->name('articles-list');
        Route::get('/panel/articles/article-{id}','editArticle')->name('edit-article');
        Route::get('/panel/articlesCategory/', "articlesCategoryList")->name('articlesCategory-list');
        Route::get('/panel/articlesCategory/article-{id}','editArticlesCategory')->name('edit-articlesCategory');

        /*newsletter*/
        Route::get('/panel/newsletter/', 'newsletterList')->name('newsletter-list');
        Route::get('/panel/newsletter/subscriber-{id}', 'editNewsletter')->name('edit-newsletter');

        /*settings*/
        Route::get('/panel/settings/', 'settingsList')->name('settings-list');
        Route::get('/panel/settings/setting-{id}', 'editSetting')->name('edit-setting');

        /* użytkownicy */
        Route::get('/panel/users/', 'usersList')->name('users-list');
        Route::get('/panel/users/user-{id}', 'editUser')->name('edit-user');

        /* administratorzy */
        Route::get('/panel/admins/', 'adminsList')->name('admins-list');
        Route::get('/panel/admins/admin-{id}', 'editAdmin')->name('edit-admin');
    });

    Route::controller(SaveData::class)->group(function () {
        Route::post('/cms-universal-save/{objectName}', 'universalSave')->name('cms-universal-save');
        Route::post('/cms-universal-delete-list/{itemId}/{objectName}', 'universalDeleteOnList')->name('cms-universal-delete-list');
    });

    Route::controller(ExportData::class)->group(function () {
        Route::get('/cms-universal-export/{objectName}/{format}', 'universalExport')->name('cms-universal-export');
    });

});

Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/logowanie', "login")->name('logowanie');
});

Route::controller(BasketApiController::class)->group(function () {
    //Route::get('/get-basket-dataa', "getBasketData")->name('get-basket-dataa');
    Route::match(['get', 'post'], '/get-basket-dataa/', "getBasketData")->name('getBasketDataa');
    Route::post('/sign-to-newsletter', "signToNewsletter")->name('sign-to-newsletter');
});

Route::controller(HomePageController::class)->group(function () {
    Route::get('/', "showHomePage")->name('show-home-page');
});




Route::controller(SearchController::class)->group(function () {
    Route::get('/search', "showSearchresults")->name('show-search-page'); //{a}(bloz){b}
});

Route::controller(StaticPageController::class)->group(function () {
    Route::get('/test-przelewy-payment', "mbankTest")->name('test-przelewy-payment'); //{a}(bloz){b}
    Route::get('/o-nas', "aptekaInternetowaPage")->name('o-nas');
    Route::get('/polityka-prywatnosci', "politykaPrywatnosciPage")->name('polityka-prywatnosci');
    Route::get('/informacje', "informacjePage")->name('informacje');
    Route::get('/regulamin', "regulaminPage")->name('regulamin');
    Route::get('/kontakt', "kontaktPage")->name('kontakt');
    Route::get('/regulamin-newslettera-apteki-internetowej', "regulaminNewsletteraPage")->name('regulamin-newslettera-apteki-internetowej');
    Route::get('/dane-wojewódzkiego-inspektoratu-farmaceutycznego', "daneWojewódzkiegoInspektoratuPage")->name('dane-wojewódzkiego-inspektoratu-farmaceutycznego');
    Route::get('/reklamacje-i-zwroty', "reklamacjezwrotyPage")->name('reklamacje-i-zwroty');
    Route::get('/platnosci', "platnosciPage")->name('platnosci');
    Route::get('/koszty-dostawy', "kosztyDostawyPage")->name('koszty-dostawy');

});

Route::controller(IntegrationsController::class)->group(function () {
    Route::get('/kamsoft-integration', "updateShopData")->name('update-shop-data');
    Route::get('/soap/wsdl', [IntegrationsController::class, 'wsdl']);
    Route::match(['GET', 'POST'], '/soap/server', [IntegrationsController::class, 'server']);

    Route::get('/soap-get-orders-test', "getOrdersTest")->name('soap-get-orders-test');
    Route::get('/soap-set-offer-test', "setOfferTest")->name('soap-set-offer-test');

});

Route::controller(WiedzaController::class)->group(function () {
    Route::get('/wiedza-farmaceutyczna/', "showList")->name('show-list');
    Route::get('/wiedza-farmaceutyczna/{slug}', "showArticle")->name('show-article');
});


Route::controller(FavoritesListController::class)->group(function () {
    Route::get('/favorites-list', "showList")->name('favorites-list');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/{slug}{a}bloz{b}{bloz}', "showProductPage")->where('b', '-')->where('a', '-')->name('show-product-page'); //{a}(bloz){b}
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/{url}', "showCategoryPage")->name('show-category-page'); //{a}(bloz){b}
});

Route::controller(CategoryController::class)->group(function () {
    Route::get('/{url}', "showCategoryPage")->name('show-category-page'); //{a}(bloz){b}
});
















