@props(['active' => false, 'href' => '#'])

@php
    $classes_common = 'inline-block rounded-t-lg border-b-2 p-2';
    $classes_normal = 'border-transparent hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300';
    $classes_active = 'border-blue-600 text-blue-600 dark:border-blue-500 dark:text-blue-500';
    $classes_case = $active ? $classes_active : $classes_normal;
    $classes = $classes_common . ' ' . $classes_case;
@endphp

<li class="me-2">
    <a href="{{ $href }}" class="{{ $classes }}" @if($active) aria-current="page" @endif>{{ $slot }}</a>
</li>