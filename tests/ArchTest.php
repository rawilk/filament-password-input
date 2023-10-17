<?php

declare(strict_types=1);

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'ddd'])
    ->each->not->toBeUsed();

test('strict types are used')
    ->expect('Rawilk\FilamentPasswordInput')
    ->toUseStrictTypes();

test('strict types are used in tests')
    ->expect('Rawilk\FilamentPasswordInput\Tests')
    ->toUseStrictTypes();
