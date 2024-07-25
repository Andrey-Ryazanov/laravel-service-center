<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\CartController;
use App\Http\Controllers\Main\OrderController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserDetailController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Main\ContactController;
use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\Main\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoryServiceController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderItemsController as AdminOrderItemsController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ServiceContactController;
use App\Http\Controllers\Admin\ServiceDeliveryMethodController;

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
 Route::get('/cookie-policy', [HomeController::class, 'showCookiePolicy'])->name('cookie-policy');
 Route::middleware('cookie-consent')->group(function() {
    Route::get('/catalog', [CategoryController::class, 'index'])->name('home'); 
    Route::get('catalog/{title}',[CategoryController::class,'view_category']);
    Route::get('/contacts',[ContactController::class,'index']);
    Route::get('/',[HomeController::class, 'index']);
    Route::middleware('auth')->group(function() {
        Route::middleware('verified')->group(function(){
            Route::get('verify/resend', [TwoFactorController::class,'resend'])->name('verify.resend');
            Route::resource('verify', TwoFactorController::class)->only(['index', 'store']);
            Route::post('two-factor/enable', [TwoFactorController::class,'enable'])->name('two-factor.enable');
            Route::post('two-factor/disable', [TwoFactorController::class,'disable'])->name('two-factor.disable');
        });
        Route::prefix('my')->group(function() {
            Route::get('security', [UserController::class, 'index'])->name('profile-security');
            Route::post('security', [UserController::class, 'updateUser'])->name('update-profile');
            Route::get('account', [UserController::class, 'show'])->name('profile-account');
            Route::get('personal', [UserDetailController::class, 'index'])->name('profile-personal');
            Route::post('personal', [UserDetailController::class, 'storeOrUpdate'])->name('update-personal');
            Route::get('orders',[OrderController::class,'myOrders'])->name('myorders');
            Route::get('orderdetails/{code}',[OrderController::class,'myOrderDetails'])->name('myorderdetails')->middleware('check.order.access');;
            Route::get('cart',[CartController::class,'cartList'])->name('mycart');
        });  
        Route::post('add-to-cart', [CartController::class, 'addToCart']);
        Route::post('update-cart', [CartController::class, 'updateCart']);
        Route::post('remove-cart',[CartController::class,'removeCart']);
        Route::get('ordernow',[OrderController::class,'orderNow']);
        Route::post('orderplace',[OrderController::class,'orderPlace']);
        Route::get('/change-password', [UserController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [UserController::class, 'updatePassword'])->name('update-password');
        
    Route::middleware(['permission:иметь доступ к главной административной панели'])->prefix('administration')->group(function() {
        Route::get('/',[AdminController::class, 'index'])->name('adminHome');
        Route::prefix('category/export')->group(function(){
            Route::get('/', [ExportController::class, 'exportCat'])->name('category.export');
            Route::get('simple',[ExportController::class,'categoriesExport'])->name('category.simpleexport');
            Route::get('smart',[ExportController::class,'categoryExport'])->name('category.smartexport');
        });
         Route::prefix('category/import')->group(function(){
             Route::get('/', [ImportController::class, 'importCat'])->name('category.import');
             Route::post('smart',[ImportController::class,'categoryImport'])->name('category.smartimport');
             Route::post('images',[ImportController::class,'importImagesCat'])->name('category.importImages');
         });
        
        Route::resource('category', AdminCategoryController::class);
        Route::get('subcategory/{title}',[AdminCategoryController::class,'show'])->name('subcategory.index');
        Route::prefix('service/import')->group(function(){
             Route::get('/', [ImportController::class, 'importServ'])->name('service.import');
             Route::post('smart',[ImportController::class,'serviceImport'])->name('service.smartimport');
             Route::post('images',[ImportController::class,'importImagesServ'])->name('service.importImages');
         });
        Route::prefix('service/export')->group(function(){
            Route::get('/', [ExportController::class, 'exportServ'])->name('service.export');
            Route::get('simple',[ExportController::class,'servicesExport']);
            Route::get('smart',[ExportController::class,'serviceExport'])->name('service.smartexport');
        });
        Route::resource('service', ServiceController::class);
        Route::resource('c-service', CategoryServiceController::class);
        Route::resource('usAbout', AdminUserController::class);
        Route::resource('roles', RoleController::class);
        
        Route::resource('orders', AdminOrderController::class);
        Route::post('update-status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        Route::post('update-deadline', [AdminOrderController::class, 'updateDeadline'])->name('update-deadline');
        Route::post('calculate-deadline', [AdminOrderController::class, 'calculateDeadline'])->name('calculate-deadline');
        Route::get('get-services-by-category/{category_id}', [AdminOrderItemsController::class,'getServicesByCategory'])->name('get-services-by-category');
        Route::get('calculate-cost', [AdminOrderItemsController::class,'calculateCost'])->name('calculateCost');
        Route::post('remove-orderItem',[AdminOrderItemsController::class,'removeItem'])->name('removeOrderItem');
        Route::post('add-orderItem',[AdminOrderItemsController::class,'addOrderItem'])->name('addOrderItem');
        Route::post('update-orderItemsCount', [AdminOrderItemsController::class, 'updateOrderItemsCount'])->name('update-orderItemsCount');
        
        Route::get('contact/edit', [ServiceContactController::class, 'edit'])->name('contact.edit');
        Route::put('contact/update', [ServiceContactController::class, 'update'])->name('contact.update');
        
        Route::resource('sdms', ServiceDeliveryMethodController::class);
    });
   });
});
});
