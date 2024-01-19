<?php

namespace The3labsTeam\NovaBusyResourceField;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        // Traits
        $this->publishes([
            __DIR__.'/App/Traits' => app_path('Traits'),
        ], 'nova-busy-resource-field-traits');

        // Migration
        $this->publishes([
            __DIR__.'/../database/migrations/2024_01_16_104203_create_busiable_table.php' => database_path('migrations/2024_01_16_104203_create_busiable_table.php'),
        ], 'nova-busy-resource-field-migrations');

        // Config
        $this->publishes([
            __DIR__.'/../config/nova-busy-resource-field.php' => config_path('nova-busy-resource-field.php'),
        ], 'nova-busy-resource-field-config');

        $this->commands([
            \The3labsTeam\NovaBusyResourceField\App\Console\Commands\BusyCommand::class,
        ]);

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-busy-resource-field', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-busy-resource-field', __DIR__.'/../dist/css/field.css');
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->group(__DIR__.'/../routes/api.php');
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
