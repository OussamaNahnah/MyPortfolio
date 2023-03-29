<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfNetController;
use App\Http\Controllers\EduController;
use App\Http\Controllers\PhoNumController;
use App\Http\Controllers\ExpController;
use App\Http\Controllers\ProjController;
use App\Http\Controllers\OtherInfoController;
use App\Http\Controllers\JobResController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([

    'middleware' => 'api',
    'prefix' => 'v1'

], function ($router) {
        Route::post('auth/register',[ AuthController::class,'register']);
        Route::post('auth/login',[ AuthController::class,'login']);
        Route::post('auth/profile',[ AuthController::class,'profile']);
        Route::post('auth/logout',[ AuthController::class,'logout']);
        Route::post('auth/update/',[ AuthController::class,'update']);
        Route::post('auth/updateimage',[ AuthController::class,'updateimage']);

        //3-Profissional Network
        Route::post('professional_network',[ ProfNetController::class,'store']);
        Route::put('professional_network/{id}',[ ProfNetController::class,'update']);
        Route::post('professional_network/{id}/updateimage',[ ProfNetController::class,'updateimage']);
        Route::delete('professional_network/{id}',[ ProfNetController::class,'destroy']);
        Route::get('professional_networks/{user_id}',[ ProfNetController::class,'index']);
        Route::get('professional_network/{id}',[ ProfNetController::class,'show']);

     //4-Education
        Route::post('education',[ EduController::class,'store']);
        Route::put('education/{id}',[ EduController::class,'update']);
        Route::delete('education/{id}',[ EduController::class,'destroy']);
        Route::get('educations/{user_id}',[ EduController::class,'index']);
        Route::get('education/{id}',[ EduController::class,'show']);

   

        //5-Phone Number 

        Route::post('phone_number',[ PhoNumController::class,'store']);
        Route::put('phone_number/{id}',[ PhoNumController::class,'update']);
        Route::delete('phone_number/{id}',[ PhoNumController::class,'destroy']);
        Route::get('phone_numbers/{user_id}',[ PhoNumController::class,'index']);
        Route::get('phone_number/{id}',[ PhoNumController::class,'show']);

        //6-Experience
        Route::post('experience',[ ExpController::class,'store']);
        Route::put('experience/{id}',[ ExpController::class,'update']);
        Route::delete('experience/{id}',[ ExpController::class,'destroy']);
        Route::get('experiences/{user_id}',[ ExpController::class,'index']);
        Route::get('experience/{id}',[ ExpController::class,'show']);
        

        //7-project
        Route::post('project',[ ProjController::class,'store']);
        Route::put('project{id}',[ ProjController::class,'update']);
        Route::delete('project{id}',[ ProjController::class,'destroy']);
        Route::get('project{id_user}',[ ProjController::class,'index']);

        //8- Other Info
        Route::post('other_infromation',[ OtherInfoController::class,'store']);
        Route::put('other_infromation',[ OtherInfoController::class,'update']);
        Route::delete('other_infromation',[ OtherInfoController::class,'destroy']);
        Route::get('other_infromation/{id}',[ OtherInfoController::class,'show']);

        //9- Job Responsibility
        Route::post('job_responsibility/{experience_id}',[ JobResController::class,'store']);
        Route::put('job_responsibility/{id}',[ JobResController::class,'update']);
        Route::delete('job_responsibility/{id}',[ JobResController::class,'destroy']);
        Route::get('job_responsibilities/{experience_id}',[ JobResController::class,'index']);
        Route::get('job_responsibility/{id}',[ JobResController::class,'show']);

        // Route::apiResource('user/{id}/professionalnetwork/', ProfNetController::class) ;

});

