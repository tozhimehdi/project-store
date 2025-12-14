<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;






//-----------------------------------------Authentication----------------------------------//
Route::middleware(['web','guest'])->group(function(){
    Route::get('/login',[AuthController::class,'login'])->name('auth.login');
    Route::get('/otp',[AuthController::class,'otp'])->name('auth.otp');
});


//-----------------------------------------Admin----------------------------------//
Route::middleware(['web'])->prefix('managment')->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('admin.index');

});


//-----------------------------------------Shop----------------------------------//

