<?php

namespace App\Providers;

use App\Models\Worker;
use App\Observers\WorkerObserver;
use App\Models\Brand;
use App\Observers\BrandObserver;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Brand::observe(BrandObserver::class);
        Worker::observe(WorkerObserver::class);
        Inertia::share('csrf_token', csrf_token());


    }
}

