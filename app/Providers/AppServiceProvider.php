<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

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

        Bugsnag::registerCallback(function ($report) {
            $report->setMetaData([
                'account' => [
                    'name' => 'Car Flo',
                    'files' => $_FILES,
                    'post_array' => $_POST,
                ]
            ]);
        });
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
