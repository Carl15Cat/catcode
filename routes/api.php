<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompilerController;
use App\Http\Controllers\ProgrammingLanguageController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/languages', function() { return App\Models\ProgrammingLanguage::getAll(); })->name('getProgrammingLanguages');

Route::controller(CompilerController::class)->prefix('/submissions')->group(function() {
    Route::get('/{token}', 'getSubmission')->name('getSubmission');
    Route::post('/', 'runFreeCompiler')->name('createSubmission');
});


