@props(['href', 'dropdown', 'tooltip', 'id' => ''])

@php
    $isDropdown = isset($dropdown);
    $hasTooltip = isset($tooltip);
    $itemClasses = 'inline-flex cursor-pointer justify-center rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white';
@endphp

@if(!$isDropdown)

    <a href="{{ $href }}" @if($hasTooltip) data-tooltip-target="tooltip-{{ $id }}" @endif class="{{ $itemClasses }}">
        {{ $slot }}
    </a>

    @if($hasTooltip)
        <x-tooltip id="tooltip-{{ $id }}">{{ $tooltip }}</x-tooltip>
    @endif

@else

    <button type="button" data-dropdown-toggle="dropdown-{{ $id }}" class="{{ $itemClasses }}">
        {{ $slot }}
    </button>
    <!-- Dropdown -->
    <div class="z-50 my-4 hidden list-none divide-y divide-gray-100 rounded bg-white text-base shadow dark:bg-gray-700" id="dropdown-{{ $id }}">
        <ul class="py-1" role="none">
            {{ $dropdown }}
        </ul>
    </div>

@endif
