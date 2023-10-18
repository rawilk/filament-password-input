<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Concerns;

use Closure;

trait CanRevealPassword
{
    protected bool|Closure $canRevealPassword = true;

    protected bool|Closure $passwordInitiallyHidden = true;

    protected string|Closure $showPasswordIcon = 'heroicon-m-eye';

    protected string|Closure $hidePasswordIcon = 'heroicon-m-eye-slash';

    protected string|Closure|null $hidePasswordText = null;

    protected string|Closure|null $showPasswordText = null;

    public function canRevealPassword(bool|Closure $condition = true): static
    {
        $this->canRevealPassword = $condition;

        return $this;
    }

    public function passwordInitiallyHidden(bool|Closure $condition = true): static
    {
        $this->passwordInitiallyHidden = $condition;

        return $this;
    }

    public function showPasswordIcon(string|Closure $icon): static
    {
        $this->showPasswordIcon = $icon;

        return $this;
    }

    public function hidePasswordIcon(string|Closure $icon): static
    {
        $this->hidePasswordIcon = $icon;

        return $this;
    }

    public function showPasswordText(string|Closure|null $text): static
    {
        $this->showPasswordText = $text;

        return $this;
    }

    public function hidePasswordText(string|Closure|null $text): static
    {
        $this->hidePasswordText = $text;

        return $this;
    }

    public function getShowPasswordIcon(): string
    {
        return $this->evaluate($this->showPasswordIcon);
    }

    public function getHidePasswordIcon(): string
    {
        return $this->evaluate($this->hidePasswordIcon);
    }

    public function isPasswordRevealable(): bool
    {
        return (bool) $this->evaluate($this->canRevealPassword);
    }

    public function isPasswordInitiallyHidden(): bool
    {
        return (bool) $this->evaluate($this->passwordInitiallyHidden);
    }

    public function getShowPasswordText(): string
    {
        return $this->evaluate($this->showPasswordText) ?? __('filament-password-input::password.actions.reveal.show');
    }

    public function getHidePasswordText(): string
    {
        return $this->evaluate($this->hidePasswordText) ?? __('filament-password-input::password.actions.reveal.hide');
    }
}
