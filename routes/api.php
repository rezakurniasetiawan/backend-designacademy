<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\pdfController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\HipotesisController;
use App\Http\Controllers\API\EvaluationController;
use App\Http\Controllers\API\DivisionOfTaskController;
use App\Http\Controllers\API\TaskCompletionController;

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

Route::prefix('users')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function () {
    
    //Evaluation
    Route::prefix('evaluation')->group(function () {
        Route::get('/status', [EvaluationController::class, 'getEvaluationStatus']);
        Route::get('/all', [EvaluationController::class, 'getEvaluationAll']);

        Route::get('/hipotesis/{id}', [EvaluationController::class, 'getHipotesisById']);
        Route::get('/division/{id}', [EvaluationController::class, 'getDivisionById']);
        Route::get('/completion/{id}', [EvaluationController::class, 'getCompletionById']);
    });

    //Division
    Route::prefix('division')->group(function () {
        Route::post('/created', [DivisionOfTaskController::class, 'createDivisionOfTask']);
        Route::get('/{id}', [DivisionOfTaskController::class, 'getDivisionOfTaskById']);
    });
    
    //Hipotesis
    Route::prefix('hipotesis')->group(function () {
        Route::post('/created', [HipotesisController::class, 'createdHipotesis']);
        Route::get('/{id}', [HipotesisController::class, 'getHipotesisById']);
    });
    
    //Task Completion
    Route::prefix('completion')->group(function () {
        Route::post('/created', [TaskCompletionController::class, 'createdTaskCompletion']);
        Route::get('/{id}', [TaskCompletionController::class, 'getTaskCompletionById']);
    });

    Route::prefix('content')->group(function () {
        Route::post('/', [ContentController::class, 'createdContent']);
        Route::get('/', [ContentController::class, 'getUserInterface']);
        Route::get('/tujuanmanfaat', [ContentController::class, 'getTujuanManfaat']);
        Route::get('/prinsipdesain', [ContentController::class, 'getPrinsipDesain']);
        Route::get('/interaksipengguna', [ContentController::class, 'getInteraksiPengguna']);
    });

});