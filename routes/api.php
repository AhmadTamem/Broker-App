<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarDetailController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\PropertyDetailController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
    Route::get('profile','profile')->middleware('auth:sanctum');
    Route::get('logout','logout')->middleware('auth:sanctum');
    Route::put('changePassword','changePassword')->middleware('auth:sanctum');
    Route::put('changePhoneNumber','changePhoneNumber')->middleware('auth:sanctum');
});
Route::controller(AdController::class)->group(function(){
    Route::post('ad/store','store')->middleware('auth:sanctum');
    Route::get('ad/index','index');
    Route::get('ad/user','ad_user')->middleware('auth:sanctum');
    Route::get('ad/show/{ad}','show')->middleware('auth:sanctum');
    Route::put('ad/update/{ad}','update')->middleware('auth:sanctum');
    Route::delete('ad/delete/{ad}','destroy')->middleware('auth:sanctum');
    Route::post('search','searchAds')->middleware('auth:sanctum');
    Route::post('views/{ad}','view');

});
Route::controller(RatingController::class)->group(function(){
    Route::post('rating/store/{ad}','store')->middleware('auth:sanctum');
    Route::get('rating/index/{ad}','index')->middleware('auth:sanctum');;
});
Route::post('upload_image/{ad}',[ImageController::class,'uploadImage'])->middleware('auth:sanctum');

Route::post('cars_detail/{ad}',[CarDetailController::class,'store'])->middleware('auth:sanctum');
Route::post('property_detail/{ad}',[PropertyDetailController::class,'store'])->middleware('auth:sanctum');
Route::put('update/property_detail/{id}',[PropertyDetailController::class,'update'])->middleware('auth:sanctum');
Route::put('update/cars_detail/{id}',[CarDetailController::class,'update'])->middleware('auth:sanctum');
Route::get('cardetail/index',[CarDetailController::class,'index'])->middleware('auth:sanctum');
Route::get('propertydetail/index',[PropertyDetailController::class,'index'])->middleware('auth:sanctum');
///////////////////////////////////////
Route::post("sendEmail",[ForgotPasswordController::class,"sendEmail"]);
Route::post('submitForgetPasswordForm', [ForgotPasswordController::class, 'submitForgetPasswordForm']);
Route::post('sendVerificationEmail', [ForgotPasswordController::class, 'sendVerificationEmail']);
////////////////////////


Route::group([
    "middleware" => ["auth:sanctum"]
], function(){

        //////
        Route::post('password/email', [ForgotPasswordController::class, 'forgot']);
        Route::post('password/reset', [ForgotPasswordController::class, 'reset']);
        //////////
});
Route::middleware('auth:sanctum')->group(function (){

    Route::apiResource('chat', \App\Http\Controllers\Api\ChatController::class)->only(['index','store','show']);
    Route::apiResource('chat_message', \App\Http\Controllers\Api\ChatMessageController::class)->only(['index','store']);
    Route::apiResource('user', UserController::class)->only(['index']);

});