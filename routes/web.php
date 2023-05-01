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


Route::get('/',[ UiController::class,'index'])->name('index');
Route::get('/user/{id}',[ UiController::class,'user'])->name('user');
Route::get('/me',[ UiController::class,'me'])->name('me');
Route::get('/cv/{id}',[ UiController::class,'cv'])->name('cv');
Route::get('/dashboard', function () {
    return redirect('/admin');
})->name('admin');


// to void the problem of login route not founf 
//if the user change hid password form the dashboard
Route::get('/login', function () {
    return redirect('/admin');
})->name('login');

Route::get('/email/verify/already-success', function(){
   return view('VerificationAlreadyVerified');
}) ;
Route::get('/email/verify/success',function(){
   return view('VerificationSuccessful');
}) ;




       
