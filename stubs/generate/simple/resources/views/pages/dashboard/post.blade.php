@php /** @var \Src\Shared\Domain\Objects\Entities\PostEntity $post */ @endphp

<x-hexagonal::layout.app title="{{ config('app.name')}} - Dashboard">

    <x-hexagonal::section class="w-1/2 justify-self-center">
        <x-hexagonal::heading type="h2">{{ $post->title }}</x-hexagonal::heading>

        <x-hexagonal::text>{{ $post->content }}</x-hexagonal::text>

    </x-hexagonal::section>

</x-hexagonal::layout.app>
