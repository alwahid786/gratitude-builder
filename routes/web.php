<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GratitudeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;

// Guest Routes
Route::middleware('guest')->group(function () {
Route::get('/', function () {
return view('pages.login');
})->name('login');

Route::get('/sign-up', fn () => view('pages.signup'))->name('signup');
Route::get('/forgot-password', fn () => view('pages.forgot-password'))->name('forgetpassword');
Route::get('/verify-otp', fn () => view('pages.otp-code'))->name('verifyOTP');
Route::get('/reset-password', fn () => view('pages.reset-password'))->name('resetpassword');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/sign-in', [AuthController::class, 'signin'])->name('loginpost');
Route::post('/forget', [AuthController::class, 'forget'])->name('forgetpasswordpost');
Route::post('/otp', [AuthController::class, 'verifyOTP'])->name('verifyOTPpost');
Route::post('/reset', [AuthController::class, 'updatePassword'])->name('resetpasswordpost');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
Route::get('/gratitude', [GratitudeController::class, 'index'])->name('home');
Route::post('/gratitude', [GratitudeController::class, 'updateGratitude'])->name('updateGratitude');
Route::post('/gratitude-story', [GratitudeController::class, 'getGratitudeStory'])->name('getGratitudeStory');

// Add logout route here
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});