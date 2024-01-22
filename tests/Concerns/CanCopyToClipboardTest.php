<?php

declare(strict_types=1);

use Filament\Forms\Form;
use Rawilk\FilamentPasswordInput\Password;
use Rawilk\FilamentPasswordInput\Tests\Fixtures\Livewire;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('can show a button to copy to clipboard', function () {
    registerComponent(CanCopyWithButton::class);

    get('/_test')
        ->assertElementExists('.fi-input-wrp', function (AssertElement $wrapper) {
            $wrapper->contains('.fi-icon-btn', [
                'text' => 'Copy to clipboard',
            ]);
        });
});

test('a custom copy message can be supplied', function () {
    $input = Password::make('password')
        ->copyMessage('my message');

    expect($input->getCopyMessage())->toBe('my message');
});

test('a custom duration can be used for the tooltip that is shown on copy', function () {
    $input = Password::make('password')
        ->copyMessageDuration(3000);

    expect($input->getCopyMessageDuration())->toBe(3000);
});

class CanCopyWithButton extends Livewire
{
    public function form(Form $form): Form
    {
        return $form->schema([
            Password::make('password')
                ->copyable(),
        ]);
    }
}
