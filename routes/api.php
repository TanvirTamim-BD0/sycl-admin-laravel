<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/* -------- CATEGORY ROUTE ....... */
//get all category........
Route::get('/get-all-prime-category', [App\Http\Controllers\Api\CategoryController::class, 'GetAllCategory'])->name('get-all-prime-category');
//get all and sub category route...........
Route::get('/get-prime-cate-wise-middle-cate-and-sub-cate/{id}', [App\Http\Controllers\Api\CategoryController::class, 'getCateWiseMiddlecateAndSubCate'])->name('get-prime-cate-wise-middle-cate-and-sub-cate');


/* -------- PRODUCT ROUTE ....... */
//get product sub category wise ...........
Route::post('/get-product-sub-category-wise/{id}', [App\Http\Controllers\Api\ProductController::class, 'getProductSubCategoryWise'])->name('get-product-sub-category-wise');

//get product banner category wise ...........
Route::post('/get-product-banner-category-wise/{id}', [App\Http\Controllers\Api\ProductController::class, 'getProductBannerCategoryWise'])->name('get-product-banner-category-wise');

//get single product data .......
Route::get('/get-single-product/{id}', [App\Http\Controllers\Api\ProductController::class, 'getSingleProduct'])->name('get-single-product');

//search product .........
Route::get('/get-keyword/{data}', [App\Http\Controllers\Api\ProductController::class, 'getKeyword'])->name('get-keyword');
Route::post('/get-product-keyword-wise/{id}', [App\Http\Controllers\Api\ProductController::class, 'getProductKeywordWise'])->name('get-product-keyword-wise');

Route::post('/get-quantity-color-size-wise', [App\Http\Controllers\Api\ProductController::class, 'getQuantityColorSizeWise'])->name('get-quantity-color-size-wise');


/* -------- BANNER ROUTE ....... */
//all get banner route............
Route::get('/get-all-banner-category', [App\Http\Controllers\Api\BannerController::class, 'GetAllBannerCategory'])->name('get-all-banner-category');
Route::get('/get-all-top-banner', [App\Http\Controllers\Api\BannerController::class, 'GetAllTopBanner'])->name('get-all-top-banner');
Route::get('/get-all-square-banner', [App\Http\Controllers\Api\BannerController::class, 'GetAllSquareBanner'])->name('get-all-square-banner');
Route::get('/get-all-bottom-banner', [App\Http\Controllers\Api\BannerController::class, 'GetAllBottomBannner'])->name('get-all-bottom-banner');


Route::get('/get-all-size', [App\Http\Controllers\Api\ProductController::class, 'GetAllSize'])->name('get-all-size');
Route::get('/get-all-color', [App\Http\Controllers\Api\ProductController::class, 'GetAllColor'])->name('get-all-color');

/* -------- AUTHENTICATION ROUTE ....... */
//Auth Controller register login
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
//To otp generate ...
Route::post('otp-generate', [App\Http\Controllers\Api\AuthController::class, 'otpGenerate'])->name('otp-generate');
//forgot password......
Route::post('/update-password', [App\Http\Controllers\Api\AuthController::class, 'updatePassword'])->name('update-password');

//social login api route ..........
Route::post('social/register/google', [App\Http\Controllers\Api\SocialAuthController::class, 'socialRegisterGoogle']);
Route::post('social/login/google', [App\Http\Controllers\Api\SocialAuthController::class, 'socialLoginGoogle']);

Route::post('social/register/facebook', [App\Http\Controllers\Api\SocialAuthController::class, 'socialRegisterFacebook']);
Route::post('social/login/facebook', [App\Http\Controllers\Api\SocialAuthController::class, 'socialLoginFacebook']);

Route::post('social/register/apple', [App\Http\Controllers\Api\SocialAuthController::class, 'socialRegisterApple']);
Route::post('social/login/apple', [App\Http\Controllers\Api\SocialAuthController::class, 'socialLoginApple']);


//you may like product get ......
Route::get('/get-you-may-like-product/{id}', [App\Http\Controllers\Api\ProductController::class, 'getYouMayLikeProduct'])->name('get-you-may-like-product');

//product wishlist count ........
Route::get('/get-product-total-wishlist-count/{id}', [App\Http\Controllers\Api\WishlistController::class, 'getProductTotalWishlistCount'])->name('get-product-total-wishlist-count');

Route::group(['middleware' => 'auth:api'], function () {

    /* -------- PRODUCT ROUTE AFTER AUTH ....... */
    //get prduct after authentication .......
    Route::post('/get-product-sub-category-wise-auth/{id}', [App\Http\Controllers\Api\ProductController::class, 'getProductSubCategoryWiseAuth'])->name('get-product-sub-category-wise-auth');
    Route::post('/get-product-banner-category-wise-auth/{id}', [App\Http\Controllers\Api\ProductController::class, 'getProductBannerCategoryWiseAuth'])->name('get-product-banner-category-wise-auth');
    Route::get('/get-single-product-auth/{id}', [App\Http\Controllers\Api\ProductController::class, 'getSingleProductAuth'])->name('get-single-product-auth');

    //recent view product route here .........
    Route::get('/get-recent-view-product', [App\Http\Controllers\Api\RecentViewController::class, 'getRecentViewProduct'])->name('get-recent-view-product');
    Route::get('/add-recent-view-product/{id}', [App\Http\Controllers\Api\RecentViewController::class, 'addRecentViewProduct'])->name('add-recent-view-product');
    Route::get('/clear-recent-view-product', [App\Http\Controllers\Api\RecentViewController::class, 'clearRecentViewProduct'])->name('clear-recent-view-product');

    //you may like product auth get ......
    Route::get('/get-you-may-like-product-auth/{id}', [App\Http\Controllers\Api\ProductController::class, 'getYouMayLikeProductAuth'])->name('get-you-may-like-product-auth');

    //get keyword product .....
    Route::post('/get-product-keyword-wise-auth/{id}', [App\Http\Controllers\Api\ProductController::class, 'getProductKeywordWiseAuth'])->name('get-product-keyword-wise-auth');

    /* -------- PROFILE ROUTE ....... */
    //profile route here .........
    Route::get('/profile', [App\Http\Controllers\Api\AuthController::class, 'getProfileData'])->name('profile');
    Route::post('/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword'])->name('change-password');
    Route::post('/profile-data-update', [App\Http\Controllers\Api\AuthController::class, 'profileDataUpdate'])->name('profile-data-update');
    //delete account ......
    Route::get('/delete-account', [App\Http\Controllers\Api\AuthController::class, 'deleteAccount'])->name('delete-account');
    //To logout customer...
    Route::get('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');


    /* -------- WISHLIST ROUTE ....... */
    //wishlist route here .........
    Route::post('/get-wishlist', [App\Http\Controllers\Api\WishlistController::class, 'getWishList'])->name('get-wishlist');
    Route::get('/add-wishlist/{id}', [App\Http\Controllers\Api\WishlistController::class, 'addWishList'])->name('add-wishlist');
    Route::get('/delete-wishlist/{id}', [App\Http\Controllers\Api\WishlistController::class, 'deleteWishlist'])->name('delete-wishlist');
    Route::get('/delete-wishlist-product-list/{id}', [App\Http\Controllers\Api\WishlistController::class, 'deleteWishlistProductList'])->name('delete-wishlist-product-list');
    Route::get('/clear-wishlist', [App\Http\Controllers\Api\WishlistController::class, 'clearWishlist'])->name('clear-wishlist');

    /* -------- CART ROUTE ....... */
    //cart route here .........
    Route::get('/get-cart', [App\Http\Controllers\Api\CartController::class, 'getCart'])->name('get-cart');
    Route::post('/add-cart', [App\Http\Controllers\Api\CartController::class, 'addCart'])->name('add-cart');
    Route::post('/update-cart/{id}', [App\Http\Controllers\Api\CartController::class, 'updateCart'])->name('update-cart');
    Route::get('/delete-cart/{id}', [App\Http\Controllers\Api\CartController::class, 'deleteCart'])->name('delete-cart');


    /* -------- ADDRESS ROUTE ....... */
    //address route here .........
    Route::get('/get-all-address-customer-wise', [App\Http\Controllers\Api\AddressController::class, 'getAllAddressCustomerWise'])->name('get-all-address-customer-wise');
    Route::post('/add-new-address', [App\Http\Controllers\Api\AddressController::class, 'addNewAddress'])->name('add-new-address');
    Route::get('/active-address/{id}', [App\Http\Controllers\Api\AddressController::class, 'activeAddress'])->name('active-address');
    Route::get('/delete-address/{id}', [App\Http\Controllers\Api\AddressController::class, 'deleteAddress'])->name('delete-address');
    Route::get('/get-all-country', [App\Http\Controllers\Api\AddressController::class, 'getAllCountry'])->name('get-all-country');
    Route::get('/get-city-country-wise/{id}', [App\Http\Controllers\Api\AddressController::class, 'getCityCountryWise'])->name('get-city-country-wise');
    Route::get('/get-all-institution ', [App\Http\Controllers\Api\AddressController::class, 'getAllInstitution'])->name('get-all-institution');


    /* -------- CHECKOUT ROUTE ....... */
    Route::post('/checkout', [App\Http\Controllers\Api\CheckoutController::class, 'checkout'])->name('checkout');

    //create access token ........
    Route::post('/create-access-token', [App\Http\Controllers\Api\OrderController::class, 'createAccessToken'])->name('create-access-token');
    Route::post('/verify-transaction', [App\Http\Controllers\Api\OrderController::class, 'verifyTransaction'])->name('verify-transaction');

    Route::get('/get-order', [App\Http\Controllers\Api\OrderController::class, 'getOrder'])->name('get-order');
    Route::get('/get-order-product-order-wise/{orderId}', [App\Http\Controllers\Api\OrderController::class, 'getOrderProductOrderWise'])->name('get-order-product-order-wise');
    Route::get('/payment-cancel/{orderId}', [App\Http\Controllers\Api\OrderController::class, 'paymentCancel'])->name('payment-cancel');
});