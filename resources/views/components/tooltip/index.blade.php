@props(['id'])

<div id="{{ $id }}" role="tooltip" class="tooltip invisible absolute z-10 inline-block rounded-lg bg-gray-900 px-3 py-2 text-sm font-medium text-white opacity-0 shadow-sm transition-opacity duration-300 dark:bg-gray-700">
    {{ $slot }}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
