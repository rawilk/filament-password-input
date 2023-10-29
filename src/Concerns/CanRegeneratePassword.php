<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Concerns;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

trait CanRegeneratePassword
{
    protected bool|Closure $regeneratePassword = false;

    protected ?Closure $generatePasswordUsing = null;

    protected string|Closure|null $regeneratePasswordIcon = null;

    protected string|Closure|array|null $regeneratePasswordIconColor = null;

    protected string|Closure|null $regeneratePasswordTooltip = null;

    protected bool $notifyOnPasswordRegenerate = true;

    protected string|Closure|null $passwordRegeneratedMessage = null;

    public function regeneratePassword(bool|Closure $condition = true): static
    {
        $this->regeneratePassword = $condition;

        return $this;
    }

    public function generatePasswordUsing(Closure $closure): static
    {
        $this->generatePasswordUsing = $closure;

        return $this;
    }

    public function regeneratePasswordIcon(string|Closure|null $icon): static
    {
        $this->regeneratePasswordIcon = $icon;

        return $this;
    }

    public function regeneratePasswordIconColor(string|Closure|array|null $color): static
    {
        $this->regeneratePasswordIconColor = $color;

        return $this;
    }

    public function regeneratePasswordTooltip(string|Closure|null $tooltip): static
    {
        $this->regeneratePasswordTooltip = $tooltip;

        return $this;
    }

    public function notifyOnPasswordRegenerate(bool $condition): static
    {
        $this->notifyOnPasswordRegenerate = $condition;

        return $this;
    }

    public function passwordRegeneratedMessage(string|Closure|null $message): static
    {
        $this->passwordRegeneratedMessage = $message;

        return $this;
    }

    public function canRegeneratePassword(): bool
    {
        return (bool) $this->evaluate($this->regeneratePassword);
    }

    public function getRegeneratePasswordIcon(): string
    {
        return $this->evaluate($this->regeneratePasswordIcon) ?? 'heroicon-o-key';
    }

    public function getRegeneratePasswordIconColor(): string|array|null
    {
        return $this->evaluate($this->regeneratePasswordIconColor);
    }

    public function getRegeneratePasswordTooltip(): string
    {
        return $this->evaluate($this->regeneratePasswordTooltip) ?? __('filament-password-input::password.actions.regenerate.tooltip');
    }

    public function getPasswordRegeneratedMessage(): string
    {
        return $this->evaluate($this->passwordRegeneratedMessage) ?? __('filament-password-input::password.actions.regenerate.success_message');
    }

    public function generateNewSecret(mixed $state): string
    {
        $callback = $this->generatePasswordUsing;
        if (is_callable($callback)) {
            return $this->evaluate($callback, [
                'state' => $state,
            ]);
        }

        $maxLength = $this->getMaxLength() ?? 32;

        return Str::password(max(3, $maxLength));
    }

    public function getRegeneratePasswordAction(): Action
    {
        $tooltip = $this->getRegeneratePasswordTooltip();

        $action = Action::make('regeneratePassword')
            ->icon($this->getRegeneratePasswordIcon())
            ->iconButton()
            ->tooltip($tooltip)
            ->label($tooltip)
            ->extraAttributes([
                // IMO it's weird when the title and tooltip show at the same time...
                'title' => '',
            ])
            ->action(function (Set $set, $state) {
                $set($this->getName(), $this->generateNewSecret($state));

                if ($this->notifyOnPasswordRegenerate) {
                    Notification::make()
                        ->title($this->getPasswordRegeneratedMessage())
                        ->success()
                        ->send();
                }
            });

        if ($color = $this->getRegeneratePasswordIconColor()) {
            $action->color($color);
        }

        return $action;
    }
}
