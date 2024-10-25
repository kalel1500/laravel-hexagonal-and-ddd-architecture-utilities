@props(['icon'])

@isset($icon)
    <li class="inline-flex items-center">
        @if($attributes->has('href'))
            <a href="{{ $attributes->get('href') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                {{ $icon }}
                {{ $slot }}
            </a>
        @else
            <span class="inline-flex items-center text-gray-500 dark:text-gray-500">
                {{ $icon }}
                {{ $slot }}
            </span>
        @endif
    </li>
@else
    <li>
        <div class="flex items-center">
            <svg class="h-6 w-6 text-gray-400 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            @if($attributes->has('href'))
                <a href="{{ $attributes->get('href') }}" class="ms-1 text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white md:ms-2">{{ $slot }}</a>
            @else
                <span class="ms-1 text-gray-500 dark:text-gray-500 md:ms-2">{{ $slot }}</span>
            @endif
        </div>
    </li>
@endisset
