<?php

use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;






//-----------------------------------------Authentication----------------------------------//
Route::middleware(['web','guest'])->group(function(){
    Route::get('/login',[AuthController::class,'login'])->name('auth.login');
    Route::get('/otp',action: [AuthController::class,'otp'])->name('auth.otp');
    Route::get('/request-otp',action: [AuthController::class,'requestOtp'])->name('request.otp');
    Route::post('/request-otp',action: [AuthController::class,'verifyOtp'])->name('verify.otp');
    Route::get('/resend-otp',action: [AuthController::class,'resendOtp'])->name('resend.otp');

});

    Route::post('/logout',action: [AuthController::class,'logout'])->name('auth.logout');


//-----------------------------------------Admin----------------------------------//
Route::middleware(['web'])->prefix('managment')->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('admin.index');
    Route::resource('/articles',ArticleController::class);
});


//-----------------------------------------Shop----------------------------------//

