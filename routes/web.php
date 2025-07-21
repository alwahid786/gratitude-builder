<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GratitudeController;
use App\Http\Controllers\BookController;

Route::get('/', [GratitudeController::class, 'index'])->name('home');         
Route::get('/check', [GratitudeController::class, 'check'])->name('check');         
Route::post('/gratitude', [GratitudeController::class, 'updateGratitude'])->name('updateGratitude');
Route::post('/gratitude-story', [GratitudeController::class, 'getGratitudeStory'])->name('getGratitudeStory');