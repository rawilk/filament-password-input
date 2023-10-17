<?php

declare(strict_types=1);

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Facade;

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'ddd'])
    ->each->not->toBeUsed();

test('strict types are used')
    ->expect('VendorName\Skeleton')
    ->toUseStrictTypes();

test('only facades are placed in the Facades directory')
    ->expect('VendorName\Skeleton\Facades')
    ->toBeClasses()
    ->toExtend(Facade::class)
    ->classes()
    ->not->toHaveSuffix('Facade');

test('commands are defined correctly')
    ->expect('VendorName\Skeleton\Commands')
    ->toBeClasses()
    ->toExtend(Command::class)
    ->toHaveMethod('handle');

test('strict types are used in tests')
    ->expect('VendorName\Skeleton\Tests')
    ->toUseStrictTypes();
