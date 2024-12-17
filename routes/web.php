<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

// Route::get('/storage-link', function () {
//     $targetFolder = base_path().'/storage/app/public';
//     $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/kasir/public/storage';
//     symlink($targetFolder, $linkFolder);
//     return 'Storage linked succesfully. target-> '.$targetFolder;
// });

// Route::post('/pos/store', 'Modules\Sale\Http\Controllers\PosController@store')->name('app.pos.store');

Route::post('/pos/store', [\Modules\Sale\Http\Controllers\PosController::class, 'store'])->name('app.pos.store');
// Route::get('/app/pos', [\Modules\Sale\Http\Controllers\PosController::class, 'index']);



Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')
        ->name('sales-purchases.chart');

    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')
        ->name('current-month.chart');

    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')
        ->name('payment-flow.chart');
});

