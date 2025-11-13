<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register model observers for audit trail
        try {
            \App\Models\Policy::observe(\App\Observers\AuditObserver::class);
            \App\Models\Client::observe(\App\Observers\AuditObserver::class);
            \App\Models\InsuranceProvider::observe(\App\Observers\AuditObserver::class);
            \App\Models\Collection::observe(\App\Observers\AuditObserver::class);
            \App\Models\WalkIn::observe(\App\Observers\AuditObserver::class);
            // Add more models here if you want auditing on other entities
        } catch (\Throwable $e) {
            // If models are not available during some artisan commands, ignore
            logger()->info('Audit observer registration skipped: ' . $e->getMessage());
        }
    }
}
