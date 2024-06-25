<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use App\Events\TransactionCreated;
// use App\Listeners\UpdateRFMScore;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // TransactionCreated::class => [
        //     UpdateRFMScore::class,
        // ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
