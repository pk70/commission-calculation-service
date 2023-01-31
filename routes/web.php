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
Route::group(['middleware' => ['web']], function () {
Route::controller(App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/upload', 'upload')->name('upload');
});
Route::controller(App\Http\Controllers\CommissionController::class)->group(function () {
    Route::get('/output', 'output')->name('output');
});
Route::controller(App\Services\FileService::class)->group(function () {
    Route::get('/download-csv', 'downloadFile')->name('downloadCsv');
});
});

