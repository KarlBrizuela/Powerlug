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
        // Automatically register all models for audit trail tracking
        $this->registerAuditObservers();
    }

    /**
     * Register audit observers for all models in the app
     */
    protected function registerAuditObservers()
    {
        try {
            $modelsPath = app_path('Models');
            $modelFiles = glob($modelsPath . '/*.php');
            
            foreach ($modelFiles as $modelFile) {
                $modelName = basename($modelFile, '.php');
                
                // Skip the AuditTrail model itself to prevent infinite loop
                if ($modelName === 'AuditTrail') {
                    continue;
                }
                
                $modelClass = "App\\Models\\{$modelName}";
                
                if (class_exists($modelClass)) {
                    $modelClass::observe(\App\Observers\AuditObserver::class);
                }
            }
        } catch (\Throwable $e) {
            // If models are not available during some artisan commands, ignore
            logger()->info('Audit observer registration skipped: ' . $e->getMessage());
        }
    }
}
