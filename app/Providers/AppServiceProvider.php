<?php

namespace App\Providers;

use App\Models\M_voucher;
use App\Observers\VoucherObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
// use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Barryvdh\DomPDF\ServiceProvider::class;
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // URL::forceScheme('https');
        Paginator::useBootstrapFive();

        Gate::define('admin', function (User $user) {
            return $user->role === 'Admin';
        });
         M_voucher::observe(VoucherObserver::class);
    }
}
