<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Rawilk\FilamentPasswordInput\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

// Helpers

function registerComponent(string $className): void
{
    $template = <<<HTML
    @livewire({$className}::class)
    HTML;

    Route::get('/_test', fn () => Blade::render($template));
}
