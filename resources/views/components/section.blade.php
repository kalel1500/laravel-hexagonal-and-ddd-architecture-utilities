<section {{ $attributes->mergeTailwind('bg-white dark:bg-gray-800 p-5 rounded dark:text-gray-400 ' . get_shadow_classes('border border-gray-200 dark:border-gray-700')) }}>
    {{ $slot }}
</section>