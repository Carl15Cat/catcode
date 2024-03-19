<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\CompilerController;
use App\Http\Controllers\SolutionController;
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
    Route::post('/', 'runFreeCompiler')->name('createSubmission'); // Запуск свободного компилятора
    Route::get('/{token}', 'getSubmission')->name('getSubmission'); // Проверка выполнения сабмишна свободного компилятора
});

Route::controller(SolutionController::class)->middleware(['web'])->group(function() {
    Route::post('/solution/{solutionId}', 'runAutotests')->name('runAutotests'); // Запуск автотестов решения
    Route::get('/solution/{solutionId}', 'checkAutotestsStatus')->name('checkAutotests'); // Проверка выполнения автотестов
});

Route::put('/api/setComplete/{solutionId}/{autotestId}', function() { Log::error("put"); });