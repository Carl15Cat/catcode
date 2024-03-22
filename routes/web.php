<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AutotestController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CompilerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariableTypeController;

// Главная
Route::get('/', function () { return view('welcome'); })->name('/');

// Компилятор
Route::get('/compiler', [CompilerController::class, 'freeCompilerView'])->name('compiler');

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

    // Только для студентов
    Route::middleware('student')->group(function() { 
        Route::get('/myTasks', [TaskController::class, 'studentTasksView'])->name('studentTasks');
        Route::get('/solution/{solutionId}', [SolutionController::class, 'solutionStudentView'])->name('solutionStudent');
    });

    // Для преподавателей и администраторов
    Route::middleware('teacher')->group(function() {
        
        // Управлние заданиями
        Route::controller(TaskController::class)->prefix('/tasks')->group(function() {
            Route::get('/', 'taskListView')->name('tasklist');
            Route::get('/add', 'addTaskView')->name('addTask');
            Route::get('/{id}', 'taskView')->name('task');
            Route::get('/{id}/edit', 'editTaskView')->name('editTask');
            Route::get('/{taskId}/give/{groupId}', 'giveTaskView')->name('giveTask');
            Route::get('/edit/{assignmentId}', [AssignmentController::class, 'editAssignmentView'])->name('editAssignment');

            Route::post('/add', 'addTask');
            Route::post('/{id}/edit', 'editTask');
            Route::post('/{id}/delete', 'deleteTask')->name('deleteTask');
            Route::post('/{taskId}/give/{groupId}', 'giveTask');
            Route::post('/{taskId}/cancel/{groupId}', 'cancelTask')->name('cancelTask');
            Route::post('/edit/{assignmentId}', [AssignmentController::class, 'editAssignment']);
        });

        // Управление автотестами
        Route::controller(AutotestController::class)->prefix('/tasks/{taskId}/autotests')->group(function() {
            Route::get('/', 'autotestlistView')->name('autotestlist');
            Route::get('/add', 'addAutotestView')->name('addAutotest');

            Route::post('/add', 'addAutotest')->name('addAutotest');
            Route::post('/{id}/delete', 'deleteAutotest')->name('deleteAutotest');
        });

        // Управление решениями студентов
        Route::controller(SolutionController::class)->prefix('/solutions')->group(function() {
            Route::get('/{solutionId}','solutionTeacherView')->name('solutionTeacher');

            Route::post('/{solutionId}/grade','setGrade')->name('grade');
        });

        // Управление группами
        Route::controller(GroupController::class)->prefix('/groups')->group(function() {
            Route::get('/', 'grouplistView')->name('grouplist');
            Route::get('/add', 'addGroupView')->name('addGroup');
            Route::get('/{id}', 'groupView')->name('group');
            Route::get('/{id}/addUsers', 'addUsersView')->name('addUsersToGroup');
            Route::get('/give/{taskId}', 'searchToGiveView')->name('searchGroupToGiveTask');
            Route::get('/journal/{groupId}', 'journalView')->name('journalGroup');
            Route::get('/journal/task/{assignmentId}', 'journalTaskView')->name('journalTask');

            Route::post('/add', 'addGroup');
            Route::post('/{id}/edit', 'editGroup')->name('editGroup');
            Route::post('/{id}/delete', 'deleteGroup')->name('deleteGroup');
            Route::post('/{groupId}/addUsers/{userId}', 'addUser')->name('addUserToGroup');
            Route::post('/{groupId}/deleteUser/{userId}', 'deleteUser')->name('deleteUserFromGroup');
        });
    });

    // Только для администраторов
    Route::middleware('admin')->group(function() {
        
        // Управление пользователями
        Route::controller(UserController::class)->prefix('/users')->group(function() {

            Route::get('/', 'userlistView')->name('userlist');
            Route::get('/add', 'addUserView')->name('addUser');
            Route::get('/{id}', 'userView')->name('user');
            Route::get('/{id}/edit', 'editUserView')->name('editUser');
    
            Route::post('/add', 'addUser');
            Route::post('/{id}/edit', 'editUser');
        });

    });

    // Получение данных
    Route::get('/getVariableTypes', [VariableTypeController::class, 'getVariableTypes']);
});