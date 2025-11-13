<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WalkInController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InsuranceProviderController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\FreebieController;

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
    // Dashboard (Superadmin only)
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->middleware('check.position:superadmin')->name('dashboard');

    // Sales Report (Superadmin only)
    Route::get('/sales-report', [SalesReportController::class, 'index'])
        ->middleware('check.position:superadmin')
        ->name('sales.report');

    // Policy routes
    Route::resource('policies', PolicyController::class);
    Route::get('/policy', [PolicyController::class, 'create'])->name('policy');

    // Freebies
    // Explicit parameter name mapping to ensure route-model binding uses {freebie}
    Route::resource('freebies', FreebieController::class)->parameters([
        'freebies' => 'freebie'
    ]);

    // Client routes
    Route::resource('clients', ClientController::class);
    
    // Insurance Provider routes
    Route::resource('insurance-providers', InsuranceProviderController::class);    // Claims routes
    Route::get('/claims/create', function () {
        // Load distinct client names from policies for the claim form dropdown
        $clients = \App\Models\Policy::select('client_name')
            ->whereNotNull('client_name')
            ->distinct()
            ->orderBy('client_name')
            ->get();
        return view('pages.claim', compact('clients'));
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

    // Collection Management routes
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/create', [CollectionController::class, 'create'])->name('collections.create');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::get('/collections/{collection}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
    Route::put('/collections/{collection}', [CollectionController::class, 'update'])->name('collections.update');

    // Audit Trail routes
    Route::get('/audit-trail', [App\Http\Controllers\AuditTrailController::class, 'index'])->name('audit-trail.index');
    Route::get('/audit/{id}/details', [App\Http\Controllers\AuditTrailController::class, 'show'])->name('audit-trail.show');
    Route::delete('/audit/{id}', [App\Http\Controllers\AuditTrailController::class, 'destroy'])->name('audit-trail.destroy');
    Route::post('/audit/clear', [App\Http\Controllers\AuditTrailController::class, 'clear'])->name('audit-trail.clear');

    // Commission routes
    Route::get('/commission', [App\Http\Controllers\CommissionController::class, 'index'])->name('commission.index');
    Route::get('/commission/create', [App\Http\Controllers\CommissionController::class, 'create'])->name('commission.create');
    Route::post('/commission', [App\Http\Controllers\CommissionController::class, 'store'])->name('commission.store');
    Route::get('/commission/{id}', [App\Http\Controllers\CommissionController::class, 'show'])->name('commission.show');
    Route::get('/commission/{id}/edit', [App\Http\Controllers\CommissionController::class, 'edit'])->name('commission.edit');
    Route::put('/commission/{id}', [App\Http\Controllers\CommissionController::class, 'update'])->name('commission.update');
    Route::delete('/commission/{id}', [App\Http\Controllers\CommissionController::class, 'destroy'])->name('commission.destroy');
    Route::get('/commission/{id}/details', [App\Http\Controllers\CommissionController::class, 'getDetails'])->name('commission.details');
    Route::get('/policy/{id}/data', [App\Http\Controllers\CommissionController::class, 'getPolicyData'])->name('policy.data');
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