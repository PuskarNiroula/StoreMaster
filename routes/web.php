<?php

use App\Http\Controllers\AnalyticsContrller;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\mainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesPredictionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsLoggedIn;
use App\Http\Middleware\IsUserAdmin;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

// routes/web.php





Route::get('/',function(){
    return view('welcome');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(EnsureUserIsLoggedIn::class)->group(function(){
    Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

    Route::resource("products",ProductController::class);
    // Route::get('/search',[ProductController::class, 'search'])->name("products.search");

Route::resource("category",CategoryController::class);

Route::controller(BillController::class)->group(function(){
    Route::get('/bills','create')->name('bills.create');
    Route::post('/store','store')->name('bills.store');
    Route::get("/bills/print/{id}",'print')->name('bills.print');

    // Route::get('/bills/index','index')->name('bills.index');
});
Route::middleware(IsUserAdmin::class)->group(function(){

Route::controller(mainController::class)->group(function(){

  Route::get("dashboard","dashboard");
  Route::get("/","sells")->name('sell');

});
//

Route::controller(SalesController::class)->group(function(){
    Route::get("/revenueByCategory",'revenueByCategory');
    Route::get("/topSoldItemsByUnit",'topSoldItemsByUnit');
    Route::get("/topSoldItemsByRevenue",'topSoldItemsByRevenue');
    Route::get("/total-sales-per-month",'totalSalesPerMonth');
    Route::get("/get-monthly-sales",'getMonthlySalesData');
    Route::get("/get-weekly-sales",'getWeeklySalesData');
    Route::get("/get-daily-sales",'getTodaySalesData');

});
Route::get("/analytics",[AnalyticsContrller::class,'analyticsDashboard'])->name('analytics');


Route::get('/predict-sales', [SalesPredictionController::class, 'predictNextMonthSales']);

Route::controller(UserController::class)->group(function(){
    Route::get('/user/dashboard','dashboard')->name('user.dashboard');
    Route::get('/user/createNewUser','showCreateUserForm')->name('user.showCreate');
    Route::post('/user/store','storeUser')->name('users.store');

    Route::get('/user/edit/{id}','showEditUserForm')->name('user.edit');
    Route::put('/user/update/{user}','update')->name('users.update');

    Route::get('/user/changePassword/{id}','changePasswordForm')->name('users.showChangePasswordForm');
    Route::put('/user/edit/password/{user}','updatePassword')->name('users.updatePassword');
    Route::post('/user/{user}/stauts','userActivateOrDeactivate')->name('user.status');

});
});
});

