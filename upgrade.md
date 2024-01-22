# Upgrade Guide

## Upgrading to 2.0 from 1.x

I've attempted to document every breaking change, however I may have missed some. If you're having an issue upgrading, please raise an issue and/or PR an update to the upgrade guide if applicable.

## Updating Dependencies

Likelihood of impact: High

### Filament

This package now requires [Filament](https://filamentphp.com) 3.2.6 or greater.

## Password Reveal

Likelihood of impact: Medium

In 2.0, I've removed my custom action for revealing the password in favor of filament's native reveal functionality on the text input.

### Methods

The following methods for revealing password functionality have either changed or been removed in 2.0:

-   `canRevealPassword` is now `revealable`
-   `showPasswordIcon` is removed
-   `hidePasswordIcon` is removed
-   `showPasswordText` is removed
-   `hidePasswordText` is removed
-   `passwordInitiallyHidden` is removed

## Copy password

Likelihood of impact: Medium

The action for copying the password to clipboard has been extracted to a dedicated action class, and some of the method signatures revolving around it on the component have either changed or been removed.

### Copyable Method

In addition to receiving a condition, a second parameter has been added to customize the icon color. It can be used like this:

```php
Password::make()
    ->copyable(condition: true, color: 'primary')
```

### Methods

The following methods have either changed or been removed:

-   `copyIcon` is removed - use icon aliases instead
-   `copyIconColor` is removed - see [Copyable Method](#copyable-method)
-   `copyTooltip` is removed - modify language lines instead now

### Customization

Further customization required for the action can be done in a service provider by configuring the `Rawilk\ProfileFilament\Actions\CopyToClipboardAction`.

## Password Generation

Likelihood of impact: Medium

The action for generating a new password has been extracted to a dedicated action class, and some of the method signatures revolving around it on the component have either changed or been removed.

### Regenerate Method

The method signature for this has been modified to now accept arguments to customize the color of the action icon, provide a custom callback to generate the password, and a boolean flag on whether to show the success notification. The method can be used like this now:

```php
Password::make()
    ->regeneratePassword(
        condition: true,
        color: 'primary',
        using: fn () => 'my callback',
        notify: true,
    )
```

### Methods

The following methods have either changed or been removed:

-   `generatePasswordUsing` is removed - see [Regenerate Method](#regenerate-method)
-   `regeneratePasswordIcon` is removed - use icon aliases instead
-   `regeneratePasswordIconColor` is removed - see [Regenerate Method](#regenerate-method)
-   `regeneratePasswordTooltip` is removed - modify language lines instead now
-   `notifyOnPasswordRegenerate` is removed - see [Regenerate Method](#regenerate-method)
-   `passwordRegeneratedMessage` is removed - modify language lines instead now

### Customization

Further customization required for the action can be done in a service provider by configuring the `Rawilk\ProfileFilament\Actions\RegeneratePasswordAction`.

## Icons

Likelihood of impact: Low

The icons can be modified using filament's icon alias system now. See [Icons](https://github.com/rawilk/filament-password-input/blob/main/README.md#icons) for more information.

## Views

Likelihood of impact: Low

2.0 of this package doesn't require any custom views, so they've all been removed.

## Styles

Likelihood of impact: Low

2.0 of this package doesn't require any custom styles, so they've all been removed.

### Selectors

Since we're not using any custom views or selectors anymore, you will need to target filament's input selector's instead if you were relying on that for custom css styling in 1.x of this package.
