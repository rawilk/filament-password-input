<?php

declare(strict_types=1);

use Filament\Forms\Form;
use Rawilk\FilamentPasswordInput\Password;
use Rawilk\FilamentPasswordInput\Tests\Fixtures\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('can show a button to generate a new password', function () {
    registerComponent(CanRegenerateWithButton::class);

    get('/_test')
        ->assertElementExists('.fi-input-wrp', function (AssertElement $wrapper) {
            $wrapper->contains('.fi-icon-btn', [
                'wire:click' => 'mountFormComponentAction(\'password\', \'regeneratePassword\')',
            ]);
        });
});

class CanRegenerateWithButton extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->regeneratePassword(),
        ]);
    }
}
