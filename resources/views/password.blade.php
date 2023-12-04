@php
    $datalistOptions = $getDatalistOptions();
    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $id = $getId();
    $isDisabled = $isDisabled();
    $isReadOnly = $isReadOnly();
    $isConcealed = $isConcealed();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $mask = $getMask();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $suffixActions = $getSuffixActions();
    $statePath = $getStatePath();

    $isPasswordRevealable = $isPasswordRevealable();
    $isPasswordInitiallyHidden = $isPasswordInitiallyHidden();
    $shouldHidePasswordManagerIcons = $shouldHidePasswordManagerIcons();

    $inputTypeToggle = $isPasswordRevealable
        ? [':type' => 'show ? \'text\' : \'password\'']
        : [];

    $extraAlpineAttributes = [...$extraAlpineAttributes, ...$inputTypeToggle];

    $hasInlineSuffix = $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel));
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            @if ($isPasswordRevealable)
                show: @js(! $isPasswordInitiallyHidden),
                revealMessage: @js($getShowPasswordText()),
                maskMessage: @js($getHidePasswordText()),
            @endif
        }"
        @include('filament-password-input::partials.load-css')
    >
        <x-filament::input.wrapper
            :disabled="$isDisabled"
            :inline-prefix="$isPrefixInline"
            :inline-suffix="$isSuffixInline"
            :prefix="$prefixLabel"
            :prefix-actions="$prefixActions"
            :prefix-icon="$prefixIcon"
            :suffix="$suffixLabel"
            :suffix-icon="$suffixIcon"
            :suffix-actions="$suffixActions"
            :valid="! $errors->has($statePath)"
            class="fi-fo-text-input fi-pw-input-wrapper"
            :attributes="
                \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                    ->class(['overflow-hidden'])
            "
        >
            <div @class([
                'flex relative' => $isPasswordRevealable,
            ])>
                <x-filament::input
                    :attributes="
                        \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                            ->merge($extraAlpineAttributes, escape: false)
                            ->merge([
                                'class' => 'fi-pw-input',
                                'autocomplete' => $getAutocomplete(),
                                'autofocus' => $isAutofocused(),
                                'disabled' => $isDisabled,
                                'id' => $id,
                                'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                                'inlineSuffix' => $hasInlineSuffix,
                                'inputmode' => $getInputMode(),
                                'list' => $datalistOptions ? $id . '-list' : null,
                                'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                                'minlength' => (! $isConcealed) ? $getMinLength() : null,
                                'placeholder' => $getPlaceholder(),
                                'readonly' => $isReadOnly,
                                'required' => $isRequired() && (! $isConcealed),
                                $applyStateBindingModifiers('wire:model') => $statePath,
                                'type' => $isPasswordRevealable ? null : 'password',
                                'data-1p-ignore' => $shouldHidePasswordManagerIcons ? '' : null,
                                'data-lpignore' => $shouldHidePasswordManagerIcons ? 'true' : null,
                                'x-data' => (count($extraAlpineAttributes) || filled($mask)) ? '{}' : null,
                                'x-mask' . ($mask instanceof \Filament\Support\RawJs ? ':dynamic' : '') => filled($mask) ? $mask : null,
                            ], escape: false)
                    "
                />

                @if ($isPasswordRevealable && ! $isDisabled)
                    <button
                        type="button"
                        @click="show = ! show"
                        @class([
                            'fi-pw-reveal-button',
                            'text-gray-500 dark:text-gray-400',
                            'px-1.5' => $hasInlineSuffix,
                            'ltr:mr-2.5 rtl:ml-2.5' => ! $hasInlineSuffix,
                        ])
                        x-cloak
                        x-tooltip="{
                            content: show ? maskMessage : revealMessage,
                            theme: $store.theme,
                        }"
                    >
                        <span class="sr-only" x-text="show ? maskMessage : revealMessage"></span>

                        <x-filament::icon
                            :icon="$getShowPasswordIcon()"
                            class="fi-pw-reveal-icon h-5 w-5"
                            x-show="! show"
                        />

                        <x-filament::icon
                            :icon="$getHidePasswordIcon()"
                            class="fi-pw-reveal-icon h-5 w-5"
                            x-show="show"
                        />
                    </button>
                @endif
            </div>
        </x-filament::input.wrapper>

        @if ($datalistOptions)
            <datalist id="{{ $id }}-list">
                @foreach ($datalistOptions as $option)
                    <option value="{{ $option }}" />
                @endforeach
            </datalist>
        @endif
    </div>
</x-dynamic-component>
