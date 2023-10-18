<?php

declare(strict_types=1);

namespace Rawilk\FilamentPasswordInput\Tests\Fixtures;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Livewire extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render(): View
    {
        return view('fixtures.form');
    }
}
