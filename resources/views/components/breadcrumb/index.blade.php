@props(['place' => 'start'])

<nav aria-label="Breadcrumb" @class(['mb-5 flex', 'justify-end' => $place === 'end'])>
    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2 rtl:space-x-reverse">
        {{ $slot }}
    </ol>
</nav>
