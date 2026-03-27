<?php

namespace App\Providers;

use App\Models\BusinessProfile;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useTailwind();
        Vite::prefetch(concurrency: 3);

        View::composer('*', function ($view): void {
            if (! Schema::hasTable('business_profiles')) {
                return;
            }

            $profileQuery = BusinessProfile::query();

            if (Schema::hasTable('store_locations')) {
                $profileQuery->with([
                    'locations' => fn ($query) => $query->active()->ordered(),
                ]);
            }

            $view->with(
                'businessProfile',
                $profileQuery->first() ?? new BusinessProfile(BusinessProfile::defaultAttributes()),
            );
        });
    }
}
