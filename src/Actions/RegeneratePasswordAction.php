<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Actions;

use Closure;
use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Set;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\Str;

class RegeneratePasswordAction extends Action
{
    use CanCustomizeProcess;

    protected const DEFAULT_MAX_LENGTH = 32;

    protected bool|Closure|null $notifyOnSuccess = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-password-input::password.actions.regenerate.tooltip'));

        $this->icon(FilamentIcon::resolve('filament-password-input::regenerate') ?? 'heroicon-o-key');

        $this->color('gray');

        $this->successNotificationTitle(__('filament-password-input::password.actions.regenerate.success_message'));

        $this->action(function (Set $set, Component $component) {
            $secret = $this->process(function (Component $component) {
                $maxLength = rescue(
                    callback: fn () => $component->getNewPasswordLength() ?? static::DEFAULT_MAX_LENGTH,
                    rescue: fn () => static::DEFAULT_MAX_LENGTH,
                    report: false,
                );

                return Str::password(max(3, $maxLength));
            });

            // Not sure if I'm doing something wrong here, but using ->getStatePath()
            // doesn't work here, but using ->getName() sets the correct path
            // to set the value.
            $set($component->getName(), $secret);

            if ($this->shouldNotifyOnSuccess()) {
                $this->success();
            }
        });
    }

    public static function getDefaultName(): ?string
    {
        return 'regeneratePassword';
    }

    public function notifyOnSuccess(bool|Closure $condition = true): static
    {
        $this->notifyOnSuccess = $condition;

        return $this;
    }

    public function shouldNotifyOnSuccess(): bool
    {
        return $this->evaluate($this->notifyOnSuccess) ?? true;
    }

    public function isHidden(): bool
    {
        $isHidden = parent::isHidden();

        if ($isHidden) {
            return true;
        }

        return $this->getComponent()->isDisabled() ||
            $this->getComponent()->isReadOnly();
    }
}
