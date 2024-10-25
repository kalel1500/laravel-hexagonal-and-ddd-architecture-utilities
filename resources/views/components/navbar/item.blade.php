@props(['dropdown', 'tooltip', 'text', 'user' => false])

@php
    $hasDropdown = isset($dropdown);
    $hasTooltip = isset($tooltip);
    $itemClasses = $user
        ? 'mx-3 flex rounded-full text-sm focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 md:mr-0'
        : 'mr-1 rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:ring-4 focus:ring-gray-300 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600';
@endphp

<button type="button"
        @if($hasDropdown)
            data-dropdown-toggle="dropdown-{{ $attributes->get('id') }}" class="{{ $itemClasses }}"
        @else
            {{ $attributes->merge(['class' => $itemClasses ]) }}
        @endif
        @if($hasTooltip) data-tooltip-target="tooltip-{{ $attributes->get('id') }}" @endif
        >
    <span class="sr-only">{{ $text }}</span>
    {{ $slot }}
</button>

@if($hasTooltip)
    <x-tooltip id="tooltip-{{ $attributes->get('id') }}">
        {{ $tooltip }}
    </x-tooltip>
@endif

@if($hasDropdown)
    {{ $dropdown }}
@endif
