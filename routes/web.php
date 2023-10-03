<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;

/* ======================================================================================================== */

/* Login */
Route::get('/', [LoginController::class, 'loginScreen'])->name('loginScreen');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/* ======================================================================================================== */

/* Register */
Route::post('/register', [LoginController::class, 'register'])->name('register');

/* ======================================================================================================== */

/* Home */
Route::get('/home', [LoginController::class, 'home'])->name('home')->middleware('auth');
Route::get('/showUsers', [LoginController::class, 'showUsers'])->name('showUsers');

//Messages
Route::get('/showMessages', [MessageController::class, 'showMessages'])->name('showMessages');
Route::post('/sendMessage', [MessageController::class, 'sendMessage'])->name('sendMessage');

//Verification
Route::get('/newMessage', [MessageController::class, 'newMessage'])->name('newMessage');
Route::get('/updateRefresh', [MessageController::class, 'updateRefresh'])->name('updateRefresh');
Route::get('/readMessage', [MessageController::class, 'readMessage'])->name('readMessage');
/* ======================================================================================================== */

/* Profile */
Route::get('/dataUser', [LoginController::class, 'dataUser'])->name('dataUser');
Route::post('/updateUser', [LoginController::class, 'updateUser'])->name('updateUser');
