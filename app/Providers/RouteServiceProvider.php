<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register any bindings or configurations here if needed
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register your middleware here
        $this->app['router']->aliasMiddleware('locale', \App\Http\Middleware\LocaleMiddleware::class);

        // Define route model bindings, pattern filters, and other route configurations here
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for your application.
     *
     * These routes all receive session state, CSRF protection, and cookie encryption.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for your application.
     *
     * These routes are stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(base_path('routes/api.php'));
    }
}
