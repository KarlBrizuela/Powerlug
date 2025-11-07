<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalkInController; // Add this import

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    // Policy routes
    Route::get('/policy', function () {
        return view('pages.policy');
    })->name('policy');
    
    Route::post('/policies', [App\Http\Controllers\PolicyController::class, 'store'])->name('policies.store');
    Route::resource('policies', App\Http\Controllers\PolicyController::class)->except(['create']);

    // Claims routes
    Route::get('/claims/create', function () {
        return view('pages.claim');
    })->name('claims.create');
    
    Route::get('/claims', function () {
        return view('pages.walk-in');
    })->name('claims.index');

    // Walk-in routes - FIXED: Added to protected group and used correct controller
    Route::get('walk-in/create', [WalkInController::class, 'create'])->name('walk-in.create');
    Route::post('walk-in', [WalkInController::class, 'store'])->name('walk-in.store');

    // Client Management routes
    Route::resource('clients', 'App\Http\Controllers\ClientController');

    // Insurance Provider routes
    Route::resource('providers', 'App\Http\Controllers\InsuranceProviderController');

    // Collection Management routes
    Route::get('/collections', function () {
        return view('pages.collections');
    })->name('collections.index');

    // Audit Trail route
    Route::get('/audit-trail', function () {
        return view('pages.audit-trail');
    })->name('audit-trail');

    // Commission route
    Route::get('/commission', function () {
        return view('pages.commission');
    })->name('commission');
});

// Authentication routes
Route::get('/forgot-password', function () {
    return 'Forgot password page coming soon!';
})->name('password.request');

Route::get('/register', function () {
    return 'Registration page coming soon!';
})->name('register');