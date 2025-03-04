@php($theme = \Thehouseofel\Hexagonal\Infrastructure\Services\CookieService::readOrNew()->preferences()->theme())
{{--<x-hexagonal::navbar.item
    id="theme-toggle"
    text="Theme toggle"
    tooltip="Toggle dark mode"
>
    <x-hexagonal::icon.moon id="theme-toggle-dark-icon" @class(['hidden' => $dark_theme])/>
    <x-hexagonal::icon.sun id="theme-toggle-light-icon" @class(['hidden' => !$dark_theme])/>
</x-hexagonal::navbar.item>--}}

<x-hexagonal::navbar.item id="theme-dark" tooltip="{{ __('Switch to dark mode') }}" @class(['hidden', 'block!' => $theme->isSystem()])>
    <x-hexagonal::icon.moon/>
</x-hexagonal::navbar.item>

<x-hexagonal::navbar.item id="theme-light" tooltip="{{ __('Switch to light mode') }}" @class(['hidden', 'block!' => $theme->isDark()])>
    <x-hexagonal::icon.sun/>
</x-hexagonal::navbar.item>

<x-hexagonal::navbar.item id="theme-system" tooltip="{{ __('Switch to system mode') }}" @class(['hidden', 'block!' => $theme->isLight()])>
    <x-hexagonal::icon.indeterminate/>
</x-hexagonal::navbar.item>
