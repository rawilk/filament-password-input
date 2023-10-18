<?php

declare(strict_types=1);

use Filament\Forms\Form;
use Rawilk\FilamentPasswordInput\Password;
use Rawilk\FilamentPasswordInput\Tests\Fixtures\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('shows a password reveal button', function () {
    registerComponent(CanRevealWithReveal::class);

    get('/_test')
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper->contains('.fi-pw-reveal-button');
        });
});

test('password reveal button is optional', function () {
    registerComponent(CanRevealWithoutReveal::class);

    get('/_test')
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper->doesntContain('.fi-pw-reveal-button');
        });
});

it('does not show the password reveal button if the input is disabled', function () {
    registerComponent(CanRevealDisabled::class);

    get('/_test')
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper->doesntContain('.fi-pw-reveal-button');
        });
});

it('can initially show the password', function () {
    $input = Password::make('password')->passwordInitiallyHidden(false);

    expect($input->isPasswordInitiallyHidden())->toBeFalse();
});

it('accepts custom icons for showing/hiding the password button', function () {
    $input = Password::make('password')
        ->showPasswordIcon('my-show-icon')
        ->hidePasswordIcon(fn () => 'my-hide-icon');

    expect($input->getShowPasswordIcon())->toBe('my-show-icon')
        ->and($input->getHidePasswordIcon())->toBe('my-hide-icon');
});

it('accepts custom text for showing/hiding the password tooltip', function () {
    $input = Password::make('password')
        ->showPasswordText(fn () => 'my show text')
        ->hidePasswordText('my hide text');

    expect($input->getShowPasswordText())->toBe('my show text')
        ->and($input->getHidePasswordText())->toBe('my hide text');
});

class CanRevealWithReveal extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password'),
        ]);
    }
}

class CanRevealWithoutReveal extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->canRevealPassword(false),
        ]);
    }
}

class CanRevealDisabled extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->canRevealPassword(true)
                ->disabled(true),
        ]);
    }
}
