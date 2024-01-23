# filament-password-input

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rawilk/filament-password-input.svg?style=flat-square)](https://packagist.org/packages/rawilk/filament-password-input)
![Tests](https://github.com/rawilk/filament-password-input/workflows/Tests/badge.svg?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/rawilk/filament-password-input.svg?style=flat-square)](https://packagist.org/packages/rawilk/filament-password-input)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/rawilk/filament-password-input?style=flat-square)](https://packagist.org/packages/rawilk/filament-password-input)
[![License](https://img.shields.io/github/license/rawilk/filament-password-input?style=flat-square)](https://github.com/rawilk/filament-password-input/blob/main/LICENSE.md)

![social image](https://banners.beyondco.de/Filament%20Password%20Input.png?theme=light&packageManager=composer+require&packageName=rawilk%2Ffilament-password-input&pattern=architect&style=style_1&description=Enhanced+password+input+component+for+filament.&md=1&showWatermark=0&fontSize=100px&images=lock-closed)

`filament-password-input` is a package built for [Filament](https://filamentphp.com) that provides an enhanced password input form component that offers you the ability to add the following
features to your password inputs:

-   Reveal password toggle
-   Copy to clipboard
-   Generate new password button

## Installation

> Upgrading to 2.0 from 1.x? Be sure to follow the [Upgrade](https://github.com/rawilk/filament-password-input/blob/main/upgrade.md) guide for breaking changes.

You can install the package via composer:

```bash
composer require rawilk/filament-password-input
```

That's it. There is no configuration file or migrations necessary for the package. Any customization is done directly on
the input itself, or [globally](#global-configuration) in a service provider, however there are a few language lines that can be overridden
if necessary in your application. You may publish the language files with:

```bash
php artisan vendor:publish --tag=filament-password-input-translations
```

## Usage

Inside a form schema, you can use the `Password` input like this:

```php
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Form;

public function form(Form $form): Form
{
    return $form
        ->schema([
            // ...
            Password::make('password')
                ->label('Password'),
        ]);
}
```

The code above will render a password input inside the form with a toggle button to show and hide the password.

![base input](https://github.com/rawilk/filament-password-input/raw/main/docs/images/base-input.png)

If you want to render a normal password input without the toggle, you may also do that with this field. The following code
will render the password input without the toggle button inside it:

```php
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Form;

public function form(Form $form): Form
{
    return $form
        ->schema([
            // ...
            Password::make('password')
                ->label('Password')
                ->revealable(false),
        ]);
}
```

## Copy to Clipboard

You can easily make any password input copyable by calling the `copyable()` method on the input. This will merge an action button in with any other `suffixActions`
you have defined on the input.

```php
Password::make('password')
    ->copyable(),
```

![copyable input](https://github.com/rawilk/filament-password-input/raw/main/docs/images/input-with-copy.png)

> **Note:** This button will not show up if the input is disabled.

If you'd like the copy button to show up as an inline suffix instead, you can simply call the `inlineSuffix()` method on the input.

### Icon Color

You can customize the color of the icon by passing in a color to the `copyable` method:

```php
Password::make('password')
    ->copyable(color: 'success'),
```

### Title/Label

When you hover over the copy button, a title saying `Copy to clipboard` will show up. You can customize this text globally
by overriding the `filament-password-input::password.actions.copy.tooltip` language key.

### Confirmation Text

Once clicked, a tooltip will appear with the text `Copied`. You can customize this text globally by overriding the `filament::components/copyable.messages.copied`
language key, or individually by using the `copyMessage` method:

```php
Password::make('password')
    ->copyable()
    ->copyMessage('Copied'),
```

### Copy Message Duration

The confirmation text that appears after clicking the copy button will disappear after 1 second by default. You can customize this with
the `copyMessageDuration` method:

```php
Password::make('password')
    ->copyable()
    ->copyMessageDuration(3000), // 3 seconds
```

> **Note:** The duration should be in milliseconds, and as an integer value.

## Password Generation

Another feature offered by this component is password generation. By calling the `regeneratePassword()` method on the input, a button will be
merged in with any other `suffixActions` you have defined on the input.

```php
Password::make('password')
    ->label('Password')
    ->regeneratePassword(),
```

![regenerate password](https://github.com/rawilk/filament-password-input/raw/main/docs/images/input-with-generate.png)

> **Note:** This button will not show up if the input is disabled or readonly.

As with the copy to clipboard action button, you can have this action rendered inline on the input as well by calling the `inlineSuffix()` method
on the input.

### Password Generation Method

By default, the password generation is handled with Laravel's `Str::password()` helper method. This will generate a random, strong password that is 32
characters long for you. If you have a `maxLength()` set on the input, that length will be used instead for the character length.

You may also use a completely custom generation method by providing a closure to the `regeneratePassword` method:

```php
Password::make('password')
    ->regeneratePassword(using: fn () => 'my-custom-password'),
```

Now when the button is clicked, `my-custom-password` will be filled into the input instead. Like with most callbacks in filament, you are able to inject
filament's utilities into the callback as well.

### Password Max Length

When using the default password generator (`Str::password()`), we will tell it to use the `maxLength()` that is set on the input. This means that
if you set a maximum length of 10 characters, the password generated by this action will be 10 characters long. By default, it is 32 characters long
if a max length is not set.

```php
Password::make('password')
    ->regeneratePassword()
    ->maxLength(10),
```

> **Note:** Due to how Laravel's `Str::password()` helper works, the password max length must be a minimum of 3 characters long.

If you want to use a different length than the input's max length, you can also use the `newPasswordLength` method as well:

```php
Password::make()
    ->regeneratePassword()
    ->newPasswordLength(8),
```

### Icon Color

You can customize the color of the icon by passing a color to the `regeneratePassword` method:

```php
Password::make('password')
    ->regeneratePassword(color: 'success'),
```

### Title/Label

When you hover the generate password action button, the text `Generate new password` will show up. You can customize this text globally
by overriding the `filament-password-input::password.actions.regenerate.tooltip` language key.

### Confirmation Message

Once a new password is generated and returned to the UI, the component will make use of a filament `Notification` with the text `New password was generated!`.
You can customize this globally by overriding the `filament-password-input::password.actions.regenerate.success_message` language key.

You may also disable this notification all-together by providing a `false` value to the `regeneratePassword` method:

```php
Password::make('password')
    ->regeneratePassword(notify: false),
```

## Password Managers

If you have a password manager installed, like 1Password or LastPass, you'll know that they automatically inject a button into password inputs.
Normally, this is a good thing, but there can be times when this is not desired, such as in local development or on a form where you're
inputting something other than your own password.

To disable password managers from injecting themselves into your password inputs, you may use the `hidePasswordManagerIcons()` method:

```php
Password::make('password')
    ->hidePasswordManagerIcons(),
```

This will add `data-1p-ignore` and `data-lpignore="true"` attributes to the input to attempt to block password managers from injecting their buttons. This isn't always
100% effective, but it should work in most cases. If you know of a better way to handle this, PR's are always welcome.

## Icons

The icons for used in the actions on this component can be customized in a service provider by registering their aliases with filament.

```php
\Filament\Support\Facades\FilamentIcon::register([
    'filament-password-input::regenerate' => 'heroicon-o-key',
])
```

Here are the aliases required to modify each icon:

-   `filament-password-input::copy` - copy to clipboard action
-   `filament-password-input::regenerate` - regenerate password action
-   `forms::components.text-input.actions.show-password` - show password reveal button
-   `forms::components.text-input.actions.hide-password` - hide password reveal button

## Kitchen Sink Example

Here is an example of an input with all the actions enabled:

```php
Password::make('password')
    ->label('Password')
    ->copyable(color: 'warning')
    ->regeneratePassword(color: 'primary')
    ->inlineSuffix(),
```

![kitchen sink](https://github.com/rawilk/filament-password-input/raw/main/docs/images/kitchen-sink.png)

## Global Configuration

Like most things in filament, you can customize a lot of the default behavior of this input in a service provider
using `configureUsing`:

```php
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Password::configureUsing(function (Password $password) {
            $password
                ->maxLength(24)
                ->copyable();
                // ->...
        });
    }
}
```

Any behavior defined here can still be overridden on individual inputs as needed.

## Scripts

### Setup

For convenience, you can run the setup bin script for easy installation for local development.

```bash
./bin/setup.sh
```

### Formatting

Although formatting is done automatically via workflow, you can format php code locally before committing with a composer script:

```bash
composer format
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](https://github.com/rawilk/filament-password-input/blob/main/CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/rawilk/filament-password-input/blob/main/.github/CONTRIBUTING.md) for details.

## Security

Please review [my security policy](https://github.com/rawilk/filament-password-input/blob/main/.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

-   [Randall Wilk](https://github.com/rawilk)
-   [All Contributors](https://github.com/rawilk/filament-password-input/graphs/contributors)

## Alternatives

-   [papalardo/filament-password-input](https://github.com/papalardo/filament-password-input)
-   [phpsa/filament-password-reveal](https://github.com/phpsa/filament-password-reveal)

## License

The MIT License (MIT). Please see [License File](https://github.com/rawilk/filament-password-input/blob/main/LICENSE.md) for more information.
