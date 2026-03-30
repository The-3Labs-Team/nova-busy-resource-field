<?php

namespace Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use The3labsTeam\NovaBusyResourceField\FieldServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [FieldServiceProvider::class];
    }
}
