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
        ->assertElementExists('.fi-pw-input-wrapper', function (AssertElement $wrapper) {
            $wrapper->contains('.fi-icon-btn', [
                'wire:click' => 'mountFormComponentAction(\'password\', \'regeneratePassword\')',
            ]);
        });
});

test('a custom icon can be used for the button', function () {
    $input = Password::make('password')
        ->regeneratePasswordIcon('my-icon');

    expect($input->getRegeneratePasswordIcon())->toBe('my-icon')
        ->and($input->getRegeneratePasswordAction()->getIcon())->toBe('my-icon');
});

test('a custom color can be specified for the button', function () {
    $input = Password::make('password')
        ->regeneratePasswordIconColor('success');

    expect($input->getRegeneratePasswordIconColor())->toBe('success')
        ->and($input->getRegeneratePasswordAction()->getColor())->toBe('success');
});

test('a custom tooltip can be provided', function () {
    $input = Password::make('password')
        ->regeneratePasswordTooltip('my tooltip');

    $action = $input->getRegeneratePasswordAction();

    expect($input->getRegeneratePasswordTooltip())->toBe('my tooltip')
        ->and($action->getTooltip())->toBe('my tooltip')
        ->and($action->getLabel())->toBe('my tooltip');
});

test('a custom message can be used for the notification when a new password is generated', function () {
    $input = Password::make('password')
        ->passwordRegeneratedMessage('my message');

    expect($input->getPasswordRegeneratedMessage())->toBe('my message');
});

it('accepts a custom callback to generate a new password with', function () {
    $input = Password::make('password')
        ->generatePasswordUsing(fn () => 'my new password');

    expect($input->generateNewSecret(null))->toBe('my new password');
});

it("respects the input's maxlength when generating a new password with the default generator", function () {
    $input = Password::make('password')
        ->maxlength(3);

    expect($input->generateNewSecret(null))->toHaveLength(3);
});

test('a minimum of 3 characters is required when using the default password generator helper on the string class', function (int $minLength) {
    $input = Password::make('password')
        ->maxLength($minLength);

    expect($input->generateNewSecret(null))->toHaveLength(3);
})->with([
    0,
    1,
    2,
]);

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
