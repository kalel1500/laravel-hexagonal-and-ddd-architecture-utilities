<x-kal::layout.app package title="Example 2">

    <x-slot:breadcrumb>
        <x-kal::breadcrumb>
            <x-kal::breadcrumb.item first>
                <x-slot:icon>
                    {{--<svg class="me-2.5 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>--}}
                    <x-kal::icon.home class="size-5 me-2.5" />
                </x-slot:icon>
                Home
            </x-kal::breadcrumb.item>
            <x-kal::breadcrumb.item>Users</x-kal::breadcrumb.item>
            <x-kal::breadcrumb.item>Settings</x-kal::breadcrumb.item>
        </x-kal::breadcrumb>
    </x-slot>

    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center h-24 rounded-sm bg-white dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded-sm bg-white dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded-sm bg-white dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded-sm bg-white dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                <x-kal::icon.plus class="size-5" />
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded-sm bg-white dark:bg-gray-800">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                <x-kal::icon.plus class="size-5" />
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-white h-28 dark:bg-gray-800">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    {{--<svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>--}}
                    <x-kal::icon.plus class="size-5" />
                </p>
            </div>
        </div>

    </div>

</x-kal::layout.app>
