@php /** @var \Src\Admin\Domain\Objects\DataObjects\ViewTagsDto $data */ @endphp
@php /** @var \Src\Shared\Domain\Objects\Entities\TagTypeEntity $tagType */ @endphp

<x-hexagonal::layout.app title="{{ config('app.name')}} - Tags">

    <div class="flex items-center gap-3">
        <x-hexagonal::heading type="h2">Tags</x-hexagonal::heading>
    </div>

    <x-hexagonal::section class="w-full justify-self-center">
        <x-hexagonal::tab>
            <x-hexagonal::tab.item :active="is_null($data->currentTagType)" :href="route('tags')">Todos</x-hexagonal::tab.item>
            @foreach($data->tagTypes as $tagType)
                <x-hexagonal::tab.item :active="$data->currentTagType?->id->value() === $tagType->id->value()" :href="route('tags', $tagType->code->value())">{{ $tagType->name }}</x-hexagonal::tab.item>
            @endforeach
        </x-hexagonal::tab>


        <div id="table-tags"></div>
    </x-hexagonal::section>

</x-hexagonal::layout.app>
