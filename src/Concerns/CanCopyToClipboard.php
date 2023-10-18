<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Concerns;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Js;

/**
 * This will behave very similar to filament's CanBeCopied trait.
 *
 * Big difference is we determine the state from the input's current
 * value instead of defining it with php.
 */
trait CanCopyToClipboard
{
    protected bool|Closure $isCopyable = false;

    protected string|Closure|null $copyMessage = null;

    protected int|Closure|null $copyMessageDuration = null;

    protected string|Closure|null $copyIcon = null;

    protected string|Closure|array|null $copyIconColor = null;

    protected string|Closure|null $copyTooltip = null;

    public function copyable(bool|Closure $condition = true): static
    {
        $this->isCopyable = $condition;

        return $this;
    }

    public function copyMessage(string|Closure|null $message): static
    {
        $this->copyMessage = $message;

        return $this;
    }

    public function copyMessageDuration(int|Closure|null $duration): static
    {
        $this->copyMessageDuration = $duration;

        return $this;
    }

    public function copyIcon(string|Closure|null $icon): static
    {
        $this->copyIcon = $icon;

        return $this;
    }

    public function copyIconColor(string|Closure|array|null $color): static
    {
        $this->copyIconColor = $color;

        return $this;
    }

    public function copyTooltip(string|Closure|null $tooltip): static
    {
        $this->copyTooltip = $tooltip;

        return $this;
    }

    public function isCopyable(): bool
    {
        return (bool) $this->evaluate($this->isCopyable);
    }

    public function getCopyMessage(): string
    {
        return $this->evaluate($this->copyMessage) ?? __('filament::components/copyable.messages.copied');
    }

    public function getCopyMessageDuration(): int
    {
        return $this->evaluate($this->copyMessageDuration) ?? 2000;
    }

    public function getCopyIcon(): string
    {
        return $this->evaluate($this->copyIcon) ?? 'heroicon-m-clipboard';
    }

    public function getCopyIconColor(): string|array|null
    {
        return $this->evaluate($this->copyIconColor);
    }

    public function getCopyTooltip(): string
    {
        return $this->evaluate($this->copyTooltip) ?? __('filament-password-input::password.actions.copy.tooltip');
    }

    public function getCopyToClipboardAction(): Action
    {
        $copyDuration = Js::from($this->getCopyMessageDuration());
        $copyMessage = Js::from($this->getCopyMessage());
        $tooltip = $this->getCopyTooltip();

        $action = Action::make('copyToClipboard')
            ->livewireClickHandlerEnabled(false)
            ->icon($this->getCopyIcon())
            ->iconButton()
            ->tooltip($tooltip)
            ->label($tooltip)
            ->extraAttributes([
                'x-on:click' => new HtmlString(<<<JS
                const text = \$wire.get('{$this->getStatePath()}');
                window.navigator.clipboard.writeText(text);
                \$tooltip({$copyMessage}, { theme: \$store.theme, timeout: {$copyDuration} });
                JS),
                // IMO it's weird when the title and tooltip show at the same time...
                'title' => '',
            ]);

        if ($color = $this->getCopyIconColor()) {
            $action->color($color);
        }

        return $action;
    }
}
