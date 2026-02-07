<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\returnDataDB\SearchEngineSuggestions;
use App\Http\Controllers\Basket\BasketApiController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(SearchEngineSuggestions::class)->group(function () {
    Route::get('/get-search-engine-suggestions/{search}', "returnSuggestions")->name('returnSuggestions');
});



/*Route::controller(AuthController::class)->group(function () {
    Route::post('/checkout-login/', "login")->name('login'); 
    Route::get('/logout/', "logout")->name('logout'); 
});

Route::middleware(["auth:usercustom"])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/get-user-data/', "getUserData")->name('get-user-data'); 
    });
});*/