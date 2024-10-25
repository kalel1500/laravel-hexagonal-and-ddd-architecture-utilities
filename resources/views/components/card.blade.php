@props(['title', 'contentId' => ''])

<div {{ $attributes->merge(['class' => 'block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-900 dark:border-gray-700 dark:shadow-2xl']) }}>
    @isset($title)
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
    @endisset
    <p class="font-normal text-gray-700 dark:text-gray-400" id="{{ $contentId }}">{{ $slot }}</p>
</div>
