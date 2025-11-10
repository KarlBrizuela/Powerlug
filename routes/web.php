<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalkInController; // Add this import
use App\Http\Controllers\ClientController; // Add this import
use App\Http\Controllers\InsuranceProviderController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AuditTrailController;

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
    Route::resource('walk-in', WalkInController::class);
    Route::get('/walk-in', [WalkInController::class, 'index'])->name('walk-in.index');
 Route::get('/walk-in', [WalkInController::class, 'index'])->name('walk-in.index');
// Route::get('/walk-in/create', [WalkInController::class, 'create'])->name('walk-in.create');
    Route::post('walk-in', [WalkInController::class, 'store'])->name('walk-in.store');

    // Client Management routes
      Route::resource('clients', ClientController::class);
    Route::get('/client-list', [ClientController::class, 'index'])->name('client-list.index');

   
 // In your web.php routes file
Route::middleware(['auth'])->group(function () {
    // Collection Management routes
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
});

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

// Insurance Provider routes - Consistent naming
Route::resource('providers', InsuranceProviderController::class);
Route::get('/providers/create', [InsuranceProviderController::class, 'create'])->name('providers.create');
Route::get('/providers', [InsuranceProviderController::class, 'index'])->name('providers.index');

// routes/web.php
Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit-trail.index');
Route::get('/audit/{id}/details', [AuditTrailController::class, 'show'])->name('audit-trail.show');
Route::delete('/audit/{id}', [AuditTrailController::class, 'destroy'])->name('audit-trail.destroy');
Route::post('/audit/clear', [AuditTrailController::class, 'clear'])->name('audit-trail.clear');