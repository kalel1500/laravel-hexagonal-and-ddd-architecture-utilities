@props(['editId', 'cancelId', 'addId'])

<div class="flex gap-3">
    <x-hexagonal::button id="{{ $editId }}" class="px-2 py-1" color="yellow"><x-hexagonal::icon.pencil-square size="5"/></x-hexagonal::button>
    <x-hexagonal::button id="{{ $cancelId }}" class="px-2 py-1 hidden" color="gray"><x-hexagonal::icon.x-circle size="5"/></x-hexagonal::button>
    <x-hexagonal::button id="{{ $addId }}" class="px-2 py-1" color="blue"><x-hexagonal::icon.plus-circle size="5"/></x-hexagonal::button>
</div>