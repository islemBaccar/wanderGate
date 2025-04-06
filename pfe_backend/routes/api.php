<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BudgetController;

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

Route::post('/register', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'loginUser']);
Route::post('/logout', [UserController::class, 'logoutUser'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/profile', [UserController::class, 'getProfile']);

Route::middleware('auth:sanctum')->post('/trips', [TripController::class, 'store']);
Route::middleware('auth:sanctum')->post('/recommend-activities', [TripController::class, 'recommendActivities']);

// Trip Routes
Route::apiResource('trips', TripController::class);
Route::put('/activities/{id}', [ActivityController::class, 'update']);
Route::delete('/activities/{id}', [ActivityController::class, 'destroy']);


// Activity Routes
Route::apiResource('activities', ActivityController::class);
Route::get('trips/{trip}/activities', [ActivityController::class, 'getActivitiesByTrip']);

// Budget Routes
Route::get('trips/{trip}/budget', [BudgetController::class, 'getBudget']);
Route::post('trips/{trip}/budget', [BudgetController::class, 'createBudget']);
Route::post('trips/{trip}/expenses', [BudgetController::class, 'addExpense']);
