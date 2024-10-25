@aware(['bigList', 'bigSquare'])
@props(['href' => '#', 'text', 'icon', 'time'])

@if($bigList)
    <a href="{{ $href }}" class="flex border-b px-4 py-3 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">
        <div class="flex-shrink-0 h-11 w-11">
            {{ $icon ?? '' }}
        </div>
        <div class="w-full pl-3">
            <div class="mb-1.5 text-sm font-normal text-gray-500 dark:text-gray-400">
                {{ $slot }}
            </div>
            @isset($time)
                <div class="text-blue-600 dark:text-blue-500 text-xs font-medium">{{ $time }}</div>
            @endisset
        </div>
    </a>
@elseif($bigSquare)
    <a href="{{ $href }}" class="group block rounded-lg p-4 text-center hover:bg-gray-100 dark:hover:bg-gray-600">
        <div class="mx-auto mb-1 h-7 w-7 text-gray-400 group-hover:text-gray-500 dark:text-gray-400 dark:group-hover:text-gray-400">
            {{ $slot }}
        </div>
        <div class="text-sm text-gray-900 dark:text-white">{{ $text }}</div>
    </a>
@else
    <li>
        <a href="{{ $href }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
            {{ $slot }}
        </a>
    </li>
@endif



