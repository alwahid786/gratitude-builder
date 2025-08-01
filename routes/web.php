<?php


use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatGPTController;
use App\Http\Controllers\GratitudeController;

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
// Release Agreement Routes
Route::get('/release', function () {
    return view('Release');
})->name('release');
Route::post('/release', [AuthController::class, 'storeRelease'])->name('release.store');

Route::get('/gratitude', [GratitudeController::class, 'index'])->name('home');
Route::post('/gratitude', [GratitudeController::class, 'updateGratitude'])->name('updateGratitude');
Route::post('/gratitude-story', [GratitudeController::class, 'getGratitudeStory'])->name('getGratitudeStory');
    Route::post('/chat', [ChatGPTController::class, 'ask'])->name('chatgpt-response');
// Add logout route here
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// new code - Admin Routes
Route::middleware(['auth', Admin::class])->prefix('admin')->name('admin.')->group(function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/settings', 'settings')->name('settings');
        Route::put('/settings', 'updateSettings')->name('settings.update');
        Route::get('/users', 'users')->name('users');
        Route::get('/users/{user}/stories', 'userStories')->name('users.stories');
        Route::get('/stories', 'stories')->name('stories');
        Route::delete('/stories/{story}', 'deleteStory')->name('stories.delete');
        Route::get('/stories/export-pdf', 'exportStoriesPdf')->name('stories.export-pdf');
    });
});