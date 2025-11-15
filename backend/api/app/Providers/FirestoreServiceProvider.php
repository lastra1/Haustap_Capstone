<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Firebase\FirestoreClient;
use App\Repositories\Firebase\BookingsRepository;
use App\Repositories\Firebase\UsersRepository;
use App\Repositories\Firebase\ProvidersRepository;
use App\Repositories\Firebase\ServicesRepository;
use App\Repositories\Firebase\CategoriesRepository;
use App\Repositories\Firebase\ApplicantsRepository;

class FirestoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Firestore Client as singleton
        $this->app->singleton(FirestoreClient::class, function ($app) {
            return new FirestoreClient();
        });

        // Register Firebase repositories
        $this->app->singleton(BookingsRepository::class, function ($app) {
            return new BookingsRepository($app->make(FirestoreClient::class));
        });

        $this->app->singleton(UsersRepository::class, function ($app) {
            return new UsersRepository($app->make(FirestoreClient::class));
        });

        $this->app->singleton(ProvidersRepository::class, function ($app) {
            return new ProvidersRepository($app->make(FirestoreClient::class));
        });

        $this->app->singleton(ServicesRepository::class, function ($app) {
            return new ServicesRepository($app->make(FirestoreClient::class));
        });

        $this->app->singleton(CategoriesRepository::class, function ($app) {
            return new CategoriesRepository($app->make(FirestoreClient::class));
        });

        $this->app->singleton(ApplicantsRepository::class, function ($app) {
            return new ApplicantsRepository($app->make(FirestoreClient::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Override default database connection if Firestore is configured
        if (config('database.default') === 'firestore') {
            $this->configureFirestoreAsDefault();
        }
    }

    /**
     * Configure Firestore as the default database connection
     */
    private function configureFirestoreAsDefault(): void
    {
        // Set up Firestore configuration
        $firestoreConfig = config('database.connections.firestore');
        
        if (empty($firestoreConfig['project_id'])) {
            // Fallback to environment variable if config is not set
            config(['database.connections.firestore.project_id' => env('FIREBASE_PROJECT_ID', 'haustap-booking-system')]);
        }

        // Log Firestore configuration for debugging
        if (config('app.debug')) {
            \Log::info('Firestore configured as default database', [
                'project_id' => config('database.connections.firestore.project_id'),
                'driver' => config('database.connections.firestore.driver')
            ]);
        }
    }
}