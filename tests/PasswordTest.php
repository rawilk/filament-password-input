<?php

declare(strict_types=1);

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Rawilk\FilamentPasswordInput\Password;
use Rawilk\FilamentPasswordInput\Tests\Fixtures\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

test('all three actions can be used at the same time', function () {
    registerComponent(PasswordWithAllThree::class);

    get('/_test')
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper
                ->contains('.fi-pw-reveal-button')
                ->contains('.fi-icon-btn', [
                    'wire:click' => 'mountFormComponentAction(\'password\', \'regeneratePassword\')',
                ])
                ->contains('.fi-icon-btn', [
                    'text' => 'Copy to clipboard',
                ]);
        });
});

test('additional suffix actions can be rendered', function () {
    registerComponent(PasswordWithAdditionalActions::class);

    get('/_test')
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper
                ->contains('.fi-pw-reveal-button')
                ->contains('.fi-icon-btn', [
                    'wire:click' => 'mountFormComponentAction(\'password\', \'regeneratePassword\')',
                ])
                ->contains('.fi-icon-btn', [
                    'text' => 'Copy to clipboard',
                ])
                ->contains('.fi-icon-btn', [
                    'wire:click' => 'mountFormComponentAction(\'password\', \'myAction\')',
                ]);
        });
});

it('can attempt to prevent password managers from injecting their buttons into the input', function () {
    registerComponent(PasswordHidePasswordManagers::class);

    get('/_test')
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper->contains('input', [
                'data-1p-ignore' => '',
                'data-lpignore' => 'true',
            ]);
        });
});

class PasswordWithAllThree extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->copyable()
                ->regeneratePassword(),
        ]);
    }
}

class PasswordWithAdditionalActions extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->copyable()
                ->regeneratePassword()
                ->suffixActions([
                    Action::make('myAction')
                        ->icon('heroicon-o-eye')
                        ->action(fn () => ''),
                ]),
        ]);
    }
}

class PasswordHidePasswordManagers extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->hidePasswordManagerIcons(),
        ]);
    }
}
