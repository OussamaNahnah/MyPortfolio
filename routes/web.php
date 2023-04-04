<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/',[ UiController::class,'display_me'])->name('index');
Route::get('/users',[ UiController::class,'display_all'])->name('users');
Route::get('/user/{id}',[ UiController::class,'user'])->name('user');
Route::get('/about',[ UiController::class,'about'])->name('about');
//Route::get('/','App\Http\Controllers\UiController@display_me')