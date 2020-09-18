<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\SideMenuService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      //$this->app->bind('SideMenu', SideMenuService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
