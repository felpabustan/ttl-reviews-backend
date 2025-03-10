<?php

namespace App\Providers;

use App\Repositories\ApiToken\ApiTokenRepository;
use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Client\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(ApiTokenRepositoryInterface::class, ApiTokenRepository::class);        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
