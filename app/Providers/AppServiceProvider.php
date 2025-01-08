<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\Review\ReviewRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
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
