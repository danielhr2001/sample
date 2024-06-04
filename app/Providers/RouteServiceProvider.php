<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(40)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            foreach (glob(base_path('routes/api/v1/admin/*.php')) as $file) {
                Route::prefix('api/v1/admin')
                    ->middleware(['api', 'auth:sanctum', 'is.admin', 'is.activated', 'is.ban', 'user.id.setter.admin'])
                    ->group($file);
            }

            foreach (glob(base_path('routes/api/v1/user/*.php')) as $file) {
                Route::prefix('api/v1/user')
                    ->middleware(['api', 'user.id.setter', 'auth:sanctum', 'is.activated', 'is.ban'])
                    ->group($file);
            }

            foreach (glob(base_path('routes/api/v1/client/*.php')) as $file) {
                Route::prefix('api/v1/client')
                    ->middleware(['api'])
                    ->group($file);
            }

            Route::prefix('api/v1')->middleware('api')
                ->group(base_path('routes/api/v1/Auth.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
