<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Message;
use App\Observers\MessageObserver;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        \Schema::defaultStringLength(191);
        
        // Message observer
        Message::observe(MessageObserver::class);
        URL::forceScheme("https");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
