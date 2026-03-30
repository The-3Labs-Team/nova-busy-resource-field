<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use The3labsTeam\NovaBusyResourceField\FieldServiceProvider;

class FieldServiceProviderTest extends TestCase
{
    public function test_it_registers_the_provider_merges_config_and_exposes_api_routes(): void
    {
        $this->assertTrue($this->app->providerIsLoaded(FieldServiceProvider::class));
        $this->assertSame(30, config('nova-busy-resource-field.threshold-old'));

        $routes = collect(Route::getRoutes()->getRoutes());

        $this->assertNotNull($routes->first(
            fn ($route) => $route->uri() === 'nova-vendor/the-3labs-team/nova-busy-resource-field/is-busy'
        ));
        $this->assertNotNull($routes->first(
            fn ($route) => $route->uri() === 'nova-vendor/the-3labs-team/nova-busy-resource-field/store-busy'
        ));
    }
}
