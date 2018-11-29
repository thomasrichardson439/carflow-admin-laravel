<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(150);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require __DIR__ . '.' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Additional' . DIRECTORY_SEPARATOR . 'methods.php';
        require __DIR__ . '.' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Additional' . DIRECTORY_SEPARATOR . 'constants.php';
    }
}
