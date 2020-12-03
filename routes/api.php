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
Route::post('register_doctor',[App\Http\Controllers\DoctorController::class, 'register']);
Route::post('details', [App\Http\Controllers\API\UserController::class, 'details'])->middleware('doctor', 'auth:api');
// List all doctors
Route::get('/doctors',  [App\Http\Controllers\API\UserController::class, 'list_doctors'])->middleware( 'auth:api');

// Permissions
// List all users + permissions.
Route::get('/patients',  [App\Http\Controllers\API\UserController::class, 'list_users'])->middleware( 'auth:api', 'doctor');
// Handle permissions. tf = 1 -> permission is given, tf = 0 -> permission is revoke.
Route::post('users/admin/{user_id}/{tf}',  [App\Http\Controllers\API\UserController::class, 'handlePermissionsAdmin'])->middleware( 'auth:api', 'elevated');
// Doctor: add mobile_phone in post.
Route::post('users/doctor/{user_id}/{tf}',  [App\Http\Controllers\API\UserController::class, 'handlePermissionsDoctor'])->middleware( 'auth:api', 'elevated');


/*
 *  Medication CRUD
 */
Route::get('/medications', [App\Http\Controllers\API\MedicationController::class, 'index']);
Route::post('/medications', [App\Http\Controllers\API\MedicationController::class, 'store'])->middleware('auth:api', 'elevated');
Route::get('/medications/{id}', [App\Http\Controllers\API\MedicationController::class, 'show']);
Route::put('/medications/{id}', [App\Http\Controllers\API\MedicationController::class, 'update']);
Route::post('/medications/{id}', [App\Http\Controllers\API\MedicationController::class, 'destroy'])->middleware('auth:api');



