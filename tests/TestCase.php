<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\FilamentPasswordInput\FilamentPasswordInputServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Rawilk\\FilamentPasswordInput\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_filament-password-input_table.php.stub';
        $migration->up();
        */
    }

    protected function getPackageProviders($app): array
    {
        return [
            FilamentPasswordInputServiceProvider::class,
        ];
    }
}
