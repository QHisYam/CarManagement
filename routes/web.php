<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Home / Welcome Route
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome'); // Show welcome page first
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard Route
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [CarController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Cars CRUD Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');           
    Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create'); 
    Route::post('/cars', [CarController::class, 'store'])->name('cars.store');         
    Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');      
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit'); 
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');  
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy'); 
});

/*
|--------------------------------------------------------------------------
| Settings Routes (Volt)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php'; // Make sure this exists and defines login/register routes

/*
|--------------------------------------------------------------------------
| Logout Route
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); // redirect to home (welcome page)
})->name('logout');
