<?php

use Illuminate\Support\Facades\Route;


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



Auth::routes(['verify' => true]);

Route::middleware(['twofactor'])->group(function() {
 Route::get('/cookie-policy', [App\Http\Controllers\HomeController::class, 'showCookiePolicy'])->name('cookie-policy');
 Route::middleware('cookie-consent')->group(function() {
    Route::get('/catalog', [App\Http\Controllers\CategoryController::class, 'index'])->name('home'); ///
    Route::get('catalog/{title}',[App\Http\Controllers\CategoryController::class,'view_category']);
    Route::get('/contacts',[App\Http\Controllers\ContactController::class,'index']);
    Route::get('/',[App\Http\Controllers\HomeController::class, 'index']);

    Route::middleware('auth')->group(function() {
    
        Route::middleware('verified')->group(function(){
            Route::get('verify/resend', 'App\Http\Controllers\Auth\TwoFactorController@resend')->name('verify.resend');
            Route::resource('verify', 'App\Http\Controllers\Auth\TwoFactorController')->only(['index', 'store']);
            Route::post('two-factor/enable', 'App\Http\Controllers\Auth\TwoFactorController@enable')->name('two-factor.enable');
            Route::post('two-factor/disable', 'App\Http\Controllers\Auth\TwoFactorController@disable')->name('two-factor.disable');
        });

        Route::prefix('my')->group(function() {
            Route::get('security', [App\Http\Controllers\User\UserController::class, 'index'])->name('profile-security');
            Route::post('security', [App\Http\Controllers\User\UserController::class, 'updateUser'])->name('update-profile');
            Route::get('account', [App\Http\Controllers\User\UserController::class, 'show'])->name('profile-account');
            Route::get('personal', [App\Http\Controllers\User\UserDetailsController::class, 'index'])->name('profile-personal');
            Route::post('personal', [App\Http\Controllers\User\UserDetailsController::class, 'storeOrUpdate'])->name('update-personal');
            Route::get('orders',[App\Http\Controllers\Cart\CartController::class,'myOrders'])->name('myorders');
            Route::get('orderdetails/{code}',[App\Http\Controllers\Cart\CartController::class,'myOrderDetails'])->name('myorderdetails')->middleware('check.order.access');;
            Route::get('cart',[App\Http\Controllers\Cart\CartController::class,'cartList'])->name('mycart');
        });
        
        Route::post('add-to-cart', [App\Http\Controllers\Cart\CartController::class, 'addToCart']);
        Route::post('update-cart', [App\Http\Controllers\Cart\CartController::class, 'updateCart']);
        Route::post('remove-cart',[App\Http\Controllers\Cart\CartController::class,'removeCart']);
    
        Route::get('ordernow',[App\Http\Controllers\Cart\CartController::class,'orderNow']);
        Route::post('orderplace',[App\Http\Controllers\Cart\CartController::class,'orderPlace']);
    
        Route::get('/change-password', [App\Http\Controllers\User\UserController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [App\Http\Controllers\User\UserController::class, 'updatePassword'])->name('update-password');
        
    Route::middleware(['permission:иметь доступ к главной административной панели'])->prefix('administration')->group(function() {
        Route::get('/',[App\Http\Controllers\Admin\AdminController::class, 'index'])->name('adminHome');
        Route::prefix('category/export')->group(function(){
            Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'export'])->name('category.export');
            Route::get('simple',[App\Http\Controllers\Admin\CategoryController::class,'categoriesExport'])->name('category.simpleexport');
            Route::get('smart',[App\Http\Controllers\Admin\CategoryController::class,'categoryExport'])->name('category.smartexport');
        });
         Route::prefix('category/import')->group(function(){
             Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'import'])->name('category.import');
             Route::post('smart',[App\Http\Controllers\Admin\CategoryController::class,'categoryImport'])->name('category.smartimport');
             Route::post('images',[App\Http\Controllers\Admin\CategoryController::class,'importImages'])->name('category.importImages');
         });
        
        Route::resource('category', App\Http\Controllers\Admin\CategoryController::class);
        Route::get('subcategory/{title}',[App\Http\Controllers\Admin\CategoryController::class,'show'])->name('subcategory.index');
        Route::prefix('service/import')->group(function(){
             Route::get('/', [App\Http\Controllers\Admin\ServiceController::class, 'import'])->name('service.import');
             Route::post('smart',[App\Http\Controllers\Admin\ServiceController::class,'serviceImport'])->name('service.smartimport');
             Route::post('images',[App\Http\Controllers\Admin\ServiceController::class,'importImages'])->name('service.importImages');
         });
        Route::prefix('service/export')->group(function(){
            Route::get('/', [App\Http\Controllers\Admin\ServiceController::class, 'export'])->name('service.export');
            Route::get('simple',[App\Http\Controllers\Admin\ServiceController::class,'servicesExport']);
            Route::get('smart',[App\Http\Controllers\Admin\ServiceController::class,'serviceExport'])->name('service.smartexport');
        });
        Route::resource('service', App\Http\Controllers\Admin\ServiceController::class);
        Route::resource('c-service', App\Http\Controllers\Admin\CategoryServiceController::class);
        Route::resource('usAbout', App\Http\Controllers\Admin\UsersAboutController::class);
        Route::resource('roles', App\Http\Controllers\Admin\RolesController::class);
        Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
        Route::get('get-services-by-category/{category_id}', [App\Http\Controllers\Admin\OrderController::class,'getServicesByCategory'])->name('get-services-by-category');
        Route::get('calculate-cost', [App\Http\Controllers\Admin\OrderController::class,'calculateCost'])->name('calculateCost');
        Route::post('remove-orderItem',[App\Http\Controllers\Admin\OrderController::class,'removeItem'])->name('removeOrderItem');
        Route::post('add-orderItem',[App\Http\Controllers\Admin\OrderController::class,'addOrderItem'])->name('addOrderItem');
        Route::post('update-order', [App\Http\Controllers\Admin\OrderController::class, 'updateOrder'])->name('update-order');
        Route::post('update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('update-status');;
    });
   });
});
});
