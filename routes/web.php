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
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('check.position:superadmin')
        ->name('dashboard');
    
    // Insurance Expiration Reminders (Superadmin only)
    Route::get('/expiration-reminders', [DashboardController::class, 'expirationReminders'])
        ->middleware('check.position:superadmin')
        ->name('expiration.reminders');
    
    // Payment Reminders (Superadmin only)
    Route::get('/payment-reminders', [DashboardController::class, 'paymentReminders'])
        ->middleware('check.position:superadmin')
        ->name('payment.reminders');
    
    // Mark payment as paid API
    Route::post('/api/mark-payment-paid', [DashboardController::class, 'markPaymentPaid'])
        ->middleware('check.position:superadmin')
        ->name('api.mark-payment-paid');
    
    // Mark policy as availed (Superadmin only)
    Route::patch('/policies/{policy}/mark-availed', [PolicyController::class, 'markAsAvailed'])
        ->middleware('check.position:superadmin')
        ->name('policies.markAsAvailed');

    // Sales Report (Superadmin only)
    Route::get('/sales-report', [SalesReportController::class, 'index'])
        ->middleware('check.position:superadmin')
        ->name('sales.report');

    // Policy routes
    Route::resource('policies', PolicyController::class);
    Route::get('/policy', [PolicyController::class, 'create'])->name('policy');
    Route::get('/policies/{policy}/installment', [PolicyController::class, 'installment'])->name('policies.installment');
    Route::post('/policies/{policy}/installment', [PolicyController::class, 'storeInstallment'])->name('policies.storeInstallment');
    Route::get('/policies/{policy}/installments', [PolicyController::class, 'listInstallments'])->name('policies.listInstallments');
    Route::delete('/policies/{policy}/file', [PolicyController::class, 'deleteFile'])->name('policies.deleteFile');
    Route::delete('/policies/{policy}/walkin-file', [PolicyController::class, 'deleteWalkinFile'])->name('policies.deleteWalkinFile');
    Route::get('/api/clients/{id}', [PolicyController::class, 'getClientDetails'])->name('clients.details');

    // Freebies
    // Explicit parameter name mapping to ensure route-model binding uses {freebie}
    Route::resource('freebies', FreebieController::class)->parameters([
        'freebies' => 'freebie'
    ]);

    // Client routes
    Route::resource('clients', ClientController::class);
    
    // Insurance Provider routes
    Route::resource('insurance-providers', InsuranceProviderController::class);    // Claims routes
    // Service routes
    Route::resource('services', ServiceController::class);
    // Claims: use controller resource for create/index/store
    Route::get('/claims/create', function () {
        // Load distinct client names from policies for the claim form dropdown
        $clients = \App\Models\Policy::select('client_name')
            ->whereNotNull('client_name')
            ->distinct()
            ->orderBy('client_name')
            ->get();
        
        // Load insurance providers
        $insuranceProviders = \App\Models\InsuranceProvider::orderBy('name')->get();
        
        // Load policies
        $policies = \App\Models\Policy::with('insuranceProvider')->orderBy('policy_number')->get();
        
        return view('pages.claim', compact('clients', 'insuranceProviders', 'policies'));
    })->name('claims.create');

    Route::get('/claims', [App\Http\Controllers\ClaimController::class, 'index'])->name('claims.index');
    Route::post('/claims', [App\Http\Controllers\ClaimController::class, 'store'])->name('claims.store');
    Route::get('/claims/{claim}', [App\Http\Controllers\ClaimController::class, 'show'])->name('claims.show');
    Route::get('/claims/{claim}/download', [App\Http\Controllers\ClaimController::class, 'download'])->name('claims.download');
    Route::delete('/claims/{claim}/file', [App\Http\Controllers\ClaimController::class, 'deleteFile'])->name('claims.deleteFile');
    Route::delete('/claims/{claim}', [App\Http\Controllers\ClaimController::class, 'destroy'])->name('claims.destroy');
    Route::patch('/claims/{claim}/admin-status', [App\Http\Controllers\ClaimController::class, 'updateAdminStatus'])->name('claims.update-admin-status');
    Route::patch('/claims/{claim}/superadmin-status', [App\Http\Controllers\ClaimController::class, 'updateSuperadminStatus'])->name('claims.update-superadmin-status');

    // Walk-in routes - Default to create form, with list accessible via button
    Route::get('/walk-in', [WalkInController::class, 'create'])->name('walk-in.create');
    Route::get('/walk-in/list', [WalkInController::class, 'index'])->name('walk-in.index');
    Route::post('/walk-in', [WalkInController::class, 'store'])->name('walk-in.store');
    // Individual walk-in actions
    Route::get('/walk-in/{walkIn}', [WalkInController::class, 'show'])->name('walk-in.show');
    Route::get('/walk-in/{walkIn}/download', [WalkInController::class, 'download'])->name('walk-in.download');
    Route::delete('/walk-in/{walkIn}', [WalkInController::class, 'destroy'])->name('walk-in.destroy');

    // Client Management routes
      Route::resource('clients', ClientController::class);
    Route::get('/client-list', [ClientController::class, 'index'])->name('client-list.index');

    // Collection Management routes
    // Only the list/index should be restricted to superadmin.
    Route::get('/collections', [CollectionController::class, 'index'])
        ->middleware('check.position:superadmin')
        ->name('collections.index');

    // Quick view route for AJAX details
    Route::get('/collections/{collection}/quick-view', [CollectionController::class, 'quickView'])->name('collections.quick-view');

    // The create/store/edit/update endpoints remain accessible to authenticated admins.
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
    Route::get('/commission/export', [App\Http\Controllers\CommissionController::class, 'export'])->name('commission.export');
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