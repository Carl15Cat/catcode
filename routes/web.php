<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {

    Route::middleware('admin')->group(function() {
        Route::get('/userlist', [UserController::class, 'userlistView'])->name('userlist');
    });

});