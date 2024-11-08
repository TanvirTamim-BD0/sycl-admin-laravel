<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\SubCategoryController;
use App\Http\Controllers\backend\BannerCategoryController;
use App\Http\Controllers\backend\TopBannerController;
use App\Http\Controllers\backend\SquareBannerController;
use App\Http\Controllers\backend\BottomBannerController;
use App\Http\Controllers\backend\SizeController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\ProductKeywordController;
use App\Http\Controllers\backend\CountryController;
use App\Http\Controllers\backend\CityController;
use App\Http\Controllers\backend\UniversityController;
use App\Http\Controllers\backend\MiddleCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return redirect()->route('login');
});
Auth::routes();

Route::group(['middleware'=>['auth']],function(){

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);
    Route::get('/users/destroy/{id}', [App\Http\Controllers\backend\UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('customers', CustomerController::class);
    Route::get('/customers/destroy/{id}', [App\Http\Controllers\backend\CustomerController::class, 'destroy'])->name('customers.destroy');

    //profile route .............
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/security', [ProfileController::class, 'security'])->name('security');
    Route::post('/security/update', [ProfileController::class, 'securityUpdate'])->name('security.update');


    //category & mddlecategory & sub category route ...............
    Route::resource('category', CategoryController::class);
    Route::get('/category/destroy/{id}', [App\Http\Controllers\backend\CategoryController::class, 'destroy'])->name('category.destroy');
    
    Route::resource('middle-category', MiddleCategoryController::class);
    Route::get('/middle-category/destroy/{id}', [App\Http\Controllers\backend\MiddleCategoryController::class, 'destroy'])->name('middle-category.destroy');

    Route::resource('sub-category', SubCategoryController::class);
    Route::get('/sub-category/destroy/{id}', [App\Http\Controllers\backend\SubCategoryController::class, 'destroy'])->name('sub-category.destroy');


    //all banner route ...............
    Route::resource('banner-category', BannerCategoryController::class);
    Route::get('/banner-category/destroy/{id}', [App\Http\Controllers\backend\BannerCategoryController::class, 'destroy'])->name('banner-category.destroy');

    Route::resource('top-banner', TopBannerController::class);
    Route::get('/top-banner/destroy/{id}', [App\Http\Controllers\backend\TopBannerController::class, 'destroy'])->name('top-banner.destroy');

    Route::resource('square-banner', SquareBannerController::class);
    Route::get('/square-banner/destroy/{id}', [App\Http\Controllers\backend\SquareBannerController::class, 'destroy'])->name('square-banner.destroy');

    Route::resource('bottom-banner', BottomBannerController::class);
    Route::get('/bottom-banner/destroy/{id}', [App\Http\Controllers\backend\BottomBannerController::class, 'destroy'])->name('bottom-banner.destroy');


    //product management route ...............
    Route::resource('size', SizeController::class);
    Route::get('/size/destroy/{id}', [App\Http\Controllers\backend\SizeController::class, 'destroy'])->name('size.destroy');

    Route::resource('keyword', ProductKeywordController::class);
    Route::get('/keyword/destroy/{id}', [App\Http\Controllers\backend\ProductKeywordController::class, 'destroy'])->name('keyword.destroy');

    Route::resource('product', ProductController::class);
    Route::get('/product/destroy/{id}', [App\Http\Controllers\backend\ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/multiple-product-delete', [App\Http\Controllers\backend\ProductController::class, 'multipleDelete'])->name('multiple-product-delete');
    Route::post('/products', [App\Http\Controllers\backend\ProductController::class, 'productSearch'])->name('product.search');

    Route::get('/product-active/{id}', [App\Http\Controllers\backend\ProductController::class, 'active'])->name('product.active');
    Route::get('/product-inactive/{id}', [App\Http\Controllers\backend\ProductController::class, 'inactive'])->name('product.inactive');
   

    Route::post('/product-tile-add', [App\Http\Controllers\backend\ProductController::class, 'productTileAdd'])->name('product-tile-add');
    Route::post('/product-tile-update/{id}', [App\Http\Controllers\backend\ProductController::class, 'productTileUpdate'])->name('product-tile-update');

    Route::post('/color-management-submit', [App\Http\Controllers\backend\ProductController::class, 'colorManagementSubmit'])->name('color-management-submit');
    Route::post('/color-management-update/{id}', [App\Http\Controllers\backend\ProductController::class, 'colorManagementUpdate'])->name('color-management-update');

    Route::get('/product-color-delete/{id}', [App\Http\Controllers\backend\ProductController::class, 'productColorDelete'])->name('product-color-delete');

    
    Route::post('/get-size-color-wise', [App\Http\Controllers\backend\ProductController::class, 'getSizeColorWise'])->name('get-size-color-wise');
    Route::post('/add-product-quantity', [App\Http\Controllers\backend\ProductController::class, 'addProductQuantity'])->name('add-product-quantity');
    Route::post('/update-product-quantity/{id}', [App\Http\Controllers\backend\ProductController::class, 'updateProductQuantity'])->name('update-product-quantity');

    Route::post('/get-middle-category-category-wise', [App\Http\Controllers\backend\ProductController::class, 'getMiddleCategoryCategoryWise'])->name('get-middle-category-category-wise');
    Route::post('/get-sub-category-middle-category-wise', [App\Http\Controllers\backend\ProductController::class, 'getSubCategoryMiddleCategoryWise'])->name('get-sub-category-middle-category-wise');
    

    Route::resource('country', CountryController::class);
    Route::get('/country/destroy/{id}', [App\Http\Controllers\backend\CountryController::class, 'destroy'])->name('country.destroy');

    Route::resource('city', CityController::class);
    Route::get('/city/destroy/{id}', [App\Http\Controllers\backend\CityController::class, 'destroy'])->name('city.destroy');

    Route::resource('university', UniversityController::class);
    Route::get('/university/destroy/{id}', [App\Http\Controllers\backend\UniversityController::class, 'destroy'])->name('university.destroy');

    /* --------------order --------------- */
    Route::get('/order', [App\Http\Controllers\backend\OrderController::class, 'index'])->name('order');
    Route::get('/order-details/{id}', [App\Http\Controllers\backend\OrderController::class, 'orderDetails'])->name('order-details');

    //order satus update....
    Route::get('/order-accept/{id}', [App\Http\Controllers\backend\OrderController::class, 'orderAccept'])->name('order-accept');
    Route::get('/order-canceled/{id}', [App\Http\Controllers\backend\OrderController::class, 'orderCanceled'])->name('order-canceled');

    //delivery satus update....
    Route::get('/delivery-proccess/{id}', [App\Http\Controllers\backend\OrderController::class, 'deliveryProccess'])->name('delivery-proccess');
    Route::get('/out-for-delivery/{id}', [App\Http\Controllers\backend\OrderController::class, 'outForDelivery'])->name('out-for-delivery');
    Route::get('/delivery-rejected/{id}', [App\Http\Controllers\backend\OrderController::class, 'deliveryRejected'])->name('delivery-rejected');
    Route::get('/delivery-success/{id}', [App\Http\Controllers\backend\OrderController::class, 'deliverySuccess'])->name('delivery-success');

    Route::get('/push-notification', [App\Http\Controllers\backend\PushNotificationController::class, 'pushNotification'])->name('push-notification');

});