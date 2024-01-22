<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Concerns;

use Closure;
use Rawilk\FilamentPasswordInput\Actions\RegeneratePasswordAction;

/**
 * @mixin \Filament\Forms\Components\Component
 */
trait CanRegeneratePassword
{
    protected int|Closure|null $newPasswordLength = null;

    public function regeneratePassword(
        bool|Closure $condition = true,
        string|array|Closure|null $color = null,
        ?Closure $using = null,
        bool|Closure|null $notify = null,
    ): static {
        $action = RegeneratePasswordAction::make()->visible($condition);

        if ($color) {
            $action->color($color);
        }

        if ($using) {
            $action->using($using);
        }

        if (filled($notify)) {
            $action->notifyOnSuccess($notify);
        }

        $this->suffixActions([
            $action,
        ]);

        return $this;
    }

    public function newPasswordLength(int|Closure|null $length = null): static
    {
        $this->newPasswordLength = $length;

        return $this;
    }

    public function getNewPasswordLength(): ?int
    {
        return $this->evaluate($this->newPasswordLength) ?? $this->getMaxLength();
    }
}
