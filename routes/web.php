<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;

// Главная
Route::get('/', function () { return view('welcome'); })->name('/');

// Аутентификация
Route::controller(UserController::class)->group(function() {

    Route::get('/login', 'loginView')->name('login');
    Route::get('/register', 'registerView')->name('register');

    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
});

// Только для зарегистрированных пользователей
Route::middleware('auth')->group(function() {

    // Управление своими данными
    Route::controller(UserController::class)->prefix('/me')->group(function() {
        
        Route::get('/', 'myProfileView')->name('myProfile');
        Route::get('/edit', 'editMyProfileView')->name('editMyProfile');

        Route::post('/edit', 'editUser');
    });

    // Для преподавателей и администраторов
    Route::middleware('teacher')->group(function() {
        
        // Управление группами
        Route::controller(GroupController::class)->prefix('/groups')->group(function() {

            Route::get('/', 'grouplistView')->name('grouplist');
            Route::get('/add', 'addGroupView')->name('addGroup');
            Route::get('/{id}', 'groupView')->name('group');

            Route::post('/add', 'addGroup');
        });
    });

    // Только для администраторов
    Route::middleware('admin')->group(function() {
        
        // Управление пользователями
        Route::controller(UserController::class)->prefix('/users')->group(function() {

            Route::get('/', 'userlistView')->name('userlist');
            Route::get('/add', 'addUserView')->name('add_user');
            Route::get('/{id}', 'userView')->name('user');
            Route::get('/{id}/edit', 'editUserView')->name('edit_user');
    
            Route::post('/add', 'addUser');
            Route::post('/{id}/edit', 'editUser');
        });

    });

});