@props(['color' => 'blue'])

@php
    $classes = 'mb-2 rounded-lg px-5 py-2.5 text-sm font-medium focus:outline-none focus:ring-4';
    $btnClasses = match($color) {
        'blue'      => '                       bg-blue-700     text-white      hover:bg-blue-800   focus:ring-blue-300                             dark:bg-blue-600                                                dark:hover:bg-blue-700      dark:focus:ring-blue-800',
        'dark'      => '                       bg-gray-800     text-white      hover:bg-gray-900   focus:ring-gray-300     dark:border-gray-700    dark:bg-gray-800                                                dark:hover:bg-gray-700      dark:focus:ring-gray-700',
        'green'     => '                       bg-green-700    text-white      hover:bg-green-800  focus:ring-green-300                            dark:bg-green-600                                               dark:hover:bg-green-700     dark:focus:ring-green-800',
        'red'       => '                       bg-red-700      text-white      hover:bg-red-800    focus:ring-red-300                              dark:bg-red-600                                                 dark:hover:bg-red-700       dark:focus:ring-red-900',
        'Purple'    => '                       bg-purple-700   text-white      hover:bg-purple-800 focus:ring-purple-300                           dark:bg-purple-600                                              dark:hover:bg-purple-700    dark:focus:ring-purple-900',
        'Light'     => 'border border-gray-300 bg-white        text-gray-900   hover:bg-gray-100   focus:ring-gray-100     dark:border-gray-600    dark:bg-gray-800    dark:text-white dark:hover:border-gray-600  dark:hover:bg-gray-700      dark:focus:ring-gray-700',
        'yellow'    => '                       bg-yellow-400   text-white      hover:bg-yellow-500 focus:ring-yellow-300                                                                                                                       dark:focus:ring-yellow-900',
    };
@endphp

<button type="button" {{ $attributes->merge(['class' => $classes.' '.$btnClasses]) }}>{{ $slot }}</button>
