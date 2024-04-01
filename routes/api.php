<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('challenges', App\Http\Controllers\ChallengeController::class);
Route::resource('companies', App\Http\Controllers\CompanyController::class);
Route::resource('programs', App\Http\Controllers\ProgramController::class);
Route::resource('program_participants', App\Http\Controllers\ProgramParticipantController::class);
Route::post('massive_generator', [\App\Http\Controllers\UserController::class, 'massiveGenerator']);
