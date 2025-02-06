@php /** @var \Src\Dashboard\Domain\Objects\DataObjects\DashboardDataDto $data */ @endphp
@php /** @var \Src\Shared\Domain\Objects\Entities\PostEntity $post */ @endphp

<x-hexagonal::layout.app title="{{ config('app.name')}} - Dashboard">

{{--    <h1 class="mb-4 text-5xl font-bold dark:text-white">Posts</h1>--}}
    <h2 class="mb-4 text-4xl font-bold dark:text-white">Posts</h2>
{{--    <h3 class="mb-4 text-3xl font-bold dark:text-white">Posts</h3>--}}
{{--    <h4 class="text-2xl font-bold dark:text-white">Heading 4</h4>--}}
{{--    <h5 class="text-xl font-bold dark:text-white">Heading 5</h5>--}}
{{--    <h6 class="text-lg font-bold dark:text-white">Heading 6</h6>--}}

    <x-hexagonal::section>

        <div class="grid grid-cols-4 gap-4">
            @foreach($data->posts as $post)
                {{--<a href="#" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $post->title->value() }}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{ $post->content->value() }}</p>
                </a>--}}

                <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white hover:text-gray-700 hover:dark:text-gray-300">{{ $post->title->value() }}</h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $post->content->value() }}</p>
                    <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Read more
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>

            @endforeach
        </div>

    </x-hexagonal::section>

</x-hexagonal::layout.app>
