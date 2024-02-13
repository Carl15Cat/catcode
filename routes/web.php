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

    Route::get('/me', [UserController::class, 'myProfileView'])->name('myProfile');

    Route::middleware('admin')->group(function() {
        Route::get('/users', [UserController::class, 'userlistView'])->name('userlist');
        Route::get('/users/add', [UserController::class, 'addUserView'])->name('add_user');
        Route::get('/users/{id}', [UserController::class, 'userView'])->name('user');
        Route::get('/users/{id}/edit', [UserController::class, 'editUserView'])->name('edit_user');

        Route::post('/users/add', [UserController::class, 'addUser']);
        Route::post('/users/{id}/edit', [UserController::class, 'editUser']);
    });

});