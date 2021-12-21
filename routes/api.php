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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('adminlogin', [\App\Http\Controllers\Auth\AdminController::class, 'login']);
Route::post('adminregister', [\App\Http\Controllers\Auth\AdminController::class, 'register']);




Route::middleware('auth:sanctum')->group(function () {
    Route::put('updateProfile', [\App\Http\Controllers\Auth\AuthController::class, 'updateProfile']);
    Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    Route::post('SendInterest/{id}', [\App\Http\Controllers\InterestController::class, 'sendInterest']);
    Route::get('ViewInterestReceived', [\App\Http\Controllers\InterestController::class, 'viewInterest']);
    Route::get('sentInterests', [\App\Http\Controllers\InterestController::class, 'getsentInterest']);
    Route::get('UserList', [\App\Http\Controllers\Auth\AuthController::class, 'getUserList']);
    Route::get('VerifiedUsers', [\App\Http\Controllers\Auth\AuthController::class, 'getVerifiedUser']);
    Route::get('UnverifiedUsers', [\App\Http\Controllers\Auth\AuthController::class, 'getUnverifiedUser']);
    Route::post('BlockUser/{id}', [\App\Http\Controllers\Auth\AuthController::class, 'blockUser']);
    Route::post('UnblockUser/{id}', [\App\Http\Controllers\Auth\AuthController::class, 'unblockUser']);
    Route::post('VerifyUser/{id}', [\App\Http\Controllers\Auth\AuthController::class, 'verifyUser']);

    Route::apiResource('SuccessStory', \App\Http\Controllers\SuccessStoryController::class);
});



// Verify email
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Resend link to verify email
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
