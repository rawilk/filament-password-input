<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\FilamentPasswordInput\FilamentPasswordInputServiceProvider;

class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    protected function getPackageProviders($app): array
    {
        return [
            FilamentPasswordInputServiceProvider::class,
        ];
    }
}
