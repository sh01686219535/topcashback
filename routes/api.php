<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/category', [ApiController::class, 'category']);
Route::get('/subCategory', [ApiController::class, 'subCategory']);
Route::get('/offer', [ApiController::class, 'offer']);
//user auth
Route::post('/userRegistration', [ApiController::class, 'userRegister']);
Route::post('/userLogin', [ApiController::class, 'userLogin']);
//merchant auth
Route::post('/merchantRegistration', [ApiController::class, 'merchantRegistration']);
Route::post('/merchantLogin', [ApiController::class, 'merchantLogin']);
//area
Route::get('/allArea', [ApiController::class, 'allArea']);
Route::get('/merchant', [ApiController::class, 'merchant']);
Route::get('/currency', [ApiController::class, 'currency']);
// Route::get('/latestOffer',[ApiController::class,'latestOffer']);
Route::get('/whatsNew', [ApiController::class, 'whatsNew']);
Route::get('/topToday', [ApiController::class, 'topToday']);
Route::get('/trendingOffer', [ApiController::class, 'trendingOffer']);
Route::get('/slider', [ApiController::class, 'slider']);
Route::get('/offerDetailsPage/{id}', [ApiController::class, 'offerDetailsPage']);
Route::get('/offers/{offer_id}/related', [ApiController::class, 'getRelatedOffers']);
Route::get('/subCategory/{id}', [ApiController::class, 'Category_subCategory']);
Route::get('/category/{id}', [ApiController::class, 'Category_subCategory_offer']);
Route::get('/banner', [ApiController::class, 'banner']);
Route::get('/sitInfo', [ApiController::class, 'sitInfo']);
Route::get('/placeWiseAd', [ApiController::class, 'placeWiseAd']);
Route::get('/recentlyAddedStore', [ApiController::class, 'recentlyAddedStore']);
//profile progress bar
Route::get('/privacyPolicy', [ApiController::class, 'privacyPolicy']);
Route::get('/terms', [ApiController::class, 'terms']);
Route::get('/rateOfPrice', [ApiController::class, 'rateOfPrice']);
Route::get('/about', [ApiController::class, 'about']);
Route::get('/socialLinks', [ApiController::class, 'socialLinks']);
Route::get('/menuFooter', [ApiController::class, 'menuFooter']);
Route::get('/footerDetails', [ApiController::class, 'footerDetails']);
//most clicks
Route::post('/clicks', [ApiController::class, 'clicks']);

// Route::post('/merchantAuth',[ApiController::class,'merchantAuth']);
// Route::post('/qrCodeSend',[ApiController::class,'qrCodeSend']);
// user Dashboard
// Route::get('/payoutDashboard',[ApiController::class,'payoutDashboard']);


// Route::get('/count_offers_by_merchant', [ApiController::class, 'countOffersByMerchant']);


//userPendingTotalAmount
Route::group(['middleware' => ['jwtAuth']], function () {
    Route::post('/qrCodeSend', [ApiController::class, 'qrCodeSend']);
    // user Dashboard
    Route::get('/payoutDashboard', [ApiController::class, 'payoutDashboard']);
    //
    Route::get('/userPendingTotalAmount', [ApiController::class, 'userPendingTotalAmount']);
    // user Earning
    Route::get('/userEarning', [ApiController::class, 'userEarning']);
    // Route::get('/userEarningPending', [ApiController::class, 'userEarningPending']);
    Route::get('/userEarningDeclined', [ApiController::class, 'userEarningDeclined']);
    Route::get('/userEarningConfirm', [ApiController::class, 'userEarningConfirm']);
    Route::post('/payOut', [ApiController::class, 'payOut']);
    Route::get('/userProfile', [ApiController::class, 'userProfile']);
    Route::post('/profile', [ApiController::class, 'profile']);
    Route::post('/customer_service', [ApiController::class, 'customer_service']);
    Route::get('profileProgress',[ApiController::class,'profileProgress']);

});
