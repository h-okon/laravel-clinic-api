<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Authentication routes
 */
Route::post('login', [App\Http\Controllers\API\UserController::class, 'login']); //-> name('login');
Route::post('register', [App\Http\Controllers\API\UserController::class, 'register']);

Route::post('details', [App\Http\Controllers\API\UserController::class, 'details'])->middleware('auth:api');

/*
 *  Medication CRUD
 */
Route::get('/medications', [App\Http\Controllers\API\MedicationController::class, 'index']);
Route::post('/medications', [App\Http\Controllers\API\MedicationController::class, 'store'])->middleware('auth_api');
Route::get('/medications/{id}', [App\Http\Controllers\API\MedicationController::class, 'show']);
Route::get('/medications/{id}/edit', [App\Http\Controllers\API\MedicationController::class, 'edit']);
Route::put('/medications/{id}', [App\Http\Controllers\API\MedicationController::class, 'update']);
Route::post('/medications/{id}', [App\Http\Controllers\API\MedicationController::class, 'destroy'])->middleware('auth_api');




