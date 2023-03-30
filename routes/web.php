<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\SubscriberController;
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

Route::resource('subscriber', SubscriberController::class)
->except(['show'])
->middleware('check-api-key-exists');


Route::prefix('key')->group(function () {
    Route::patch('/validate', [ApiKeyController::class, 'validateApiKey'])->name('key.validate');
    Route::get('/save', [ApiKeyController::class, 'save'])->name('key.save');
});




