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

Route::controller(App\Http\Controllers\CommissionController::class)->group(function () {
    Route::get('/output', 'index')->name('index');
    Route::get('/output-csv', 'outputCsvFile')->name('outputCsvFile');
});
Route::controller(App\Services\FileService::class)->group(function () {
    Route::get('/download-csv', 'downloadFile')->name('downloadCsv');
});

