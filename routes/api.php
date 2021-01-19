<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
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
Route::post('register', [App\Http\Controllers\API\UserController::class, 'register']); // -> name('register)
Route::post('register_doctor',[App\Http\Controllers\DoctorController::class, 'register']);
Route::post('details', [App\Http\Controllers\API\UserController::class, 'details'])->middleware('doctor', 'auth:api');
// List all doctors
Route::get('/doctors',  [App\Http\Controllers\API\UserController::class, 'list_doctors'])->middleware( 'auth:api');

// Permissions
// List all users + permissions.
Route::get('/patients',  [App\Http\Controllers\API\UserController::class, 'list_users'])->middleware( 'auth:api', 'doctor');
Route::post('users/admin/{user_id}/{tf}',  [App\Http\Controllers\API\UserController::class, 'handlePermissionsAdmin'])->middleware( 'auth:api', 'elevated');

Route::post('/visits', [App\Http\Controllers\API\VisitController::class, 'store']);

Route::get('/doctors_specialization', [App\Http\Controllers\DoctorController::class, 'list_doc_spec']);
/*
 *  Prescriptions
 */
Route::post('prescription', [App\Http\Controllers\PrescriptionController::class, 'store'])->middleware('doctor', 'auth:api');

// Show all prescriptions for given patient {id}
Route::get('p_prescriptions/{id}', [App\Http\Controllers\PrescriptionController::class, 'show_prescription_for_patient'])->middleware('auth:api');




