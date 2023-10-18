<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\FilamentPasswordInput\FilamentPasswordInputServiceProvider;

class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected $enablesPackageDiscoveries = true;

    protected function getPackageProviders($app): array
    {
        return [
            FilamentPasswordInputServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('view.paths', [
            ...$app['config']->get('view.paths'),
            __DIR__ . '/resources/views',
        ]);
    }
}
