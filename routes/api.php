<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
