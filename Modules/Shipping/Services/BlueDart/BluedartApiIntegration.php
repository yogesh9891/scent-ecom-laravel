<?php

namespace Modules\Shipping\Services\BlueDart;


use Illuminate\Support\ServiceProvider;

class BluedartApiIntegration extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->make('jetbro\bluedart\BluedartController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        // $this->loadMigrationsFrom(__DIR__.'/migrations');
        // $this->loadViewsFrom(__DIR__.'/views', 'todolist');
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/wisdmlabs/todolist'),
        // ]);
    }
}
