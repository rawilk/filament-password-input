<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput;

use Closure;
use Filament\Forms\Components\TextInput;
use Rawilk\FilamentPasswordInput\Concerns\CanCopyToClipboard;
use Rawilk\FilamentPasswordInput\Concerns\CanRegeneratePassword;
use Rawilk\FilamentPasswordInput\Concerns\CanRevealPassword;

class Password extends TextInput
{
    use CanCopyToClipboard;
    use CanRegeneratePassword;
    use CanRevealPassword;

    protected string $view = 'filament-password-input::password';

    protected bool|Closure $hidePasswordManagerIcons = false;

    /**
     * Prevent password managers like 1password or LastPass from injecting buttons
     * into the password field.
     */
    public function hidePasswordManagerIcons(bool|Closure $condition = true): static
    {
        $this->hidePasswordManagerIcons = $condition;

        return $this;
    }

    public function shouldHidePasswordManagerIcons(): bool
    {
        return (bool) $this->evaluate($this->hidePasswordManagerIcons);
    }

    public function getSuffixActions(): array
    {
        if ($this->cachedSuffixActions) {
            return $this->cachedSuffixActions;
        }

        $isDisabled = $this->isDisabled();
        $isReadonly = $this->isReadOnly();

        if (! $isDisabled && $this->isCopyable()) {
            $this->suffixActions([$this->getCopyToClipboardAction()], $this->isSuffixInline);
        }

        if (! ($isDisabled || $isReadonly) && $this->canRegeneratePassword()) {
            $this->suffixActions([$this->getRegeneratePasswordAction()], $this->isSuffixInline);
        }

        return parent::getSuffixActions();
    }
}
