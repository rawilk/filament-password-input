@php
    use Filament\Support\Facades\FilamentAsset;
    use Rawilk\FilamentPasswordInput\FilamentPasswordInputServiceProvider;

    $css = FilamentAsset::getStyleHref('filament-password-input', package: FilamentPasswordInputServiceProvider::PACKAGE_ID);
@endphp

data-dispatch="pw-loaded"
x-load-css="[@js($css)]"
x-on:pw-loaded-css.window.once="() => {
    if (window.__pwStylesLoaded === true) { return }
    const style = document.head.querySelector('link[href=\'{{ $css }}\']');
    style && style.remove();
    style && document.head.prepend(style);
    window.__pwStylesLoaded = true;
}"
