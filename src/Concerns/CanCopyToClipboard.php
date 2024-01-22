<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Concerns;

use Closure;
use Rawilk\FilamentPasswordInput\Actions\CopyToClipboardAction;

/**
 * @mixin \Filament\Forms\Components\TextInput
 */
trait CanCopyToClipboard
{
    protected string|Closure|null $copyMessage = null;

    protected int|Closure|null $copyMessageDuration = null;

    public function copyable(
        bool|Closure $condition = true,
        string|array|Closure|null $color = null,
    ): static {
        $action = CopyToClipboardAction::make()->visible($condition);

        if ($color) {
            $action->color($color);
        }

        $this->suffixActions([
            $action,
        ]);

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

    public function getCopyMessage(): string
    {
        return $this->evaluate($this->copyMessage) ?? __('filament::components/copyable.messages.copied');
    }

    public function getCopyMessageDuration(): int
    {
        return $this->evaluate($this->copyMessageDuration) ?? 2000;
    }
}
