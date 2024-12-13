@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\SidebarItemDo $item */ @endphp

@props(['item', 'level'])

@if($item->is_separator)
    <x-hexagonal::sidebar.separator/>
@else
    <x-hexagonal::sidebar.item
            :href="$item->hasDropdown() ? null : $item->getHref()"
            :counter="$item->hasCounter() ? $item->getCounter() : null"
            :level="$level"
    >
        @if(!is_null($item->icon))
            <x-slot:icon>
                <x-hexagonal::render-icon :icon="$item->icon" />
            </x-slot:icon>
        @endif
        {{ $item->text }}
        @if($item->hasDropdown())
            @php($level++)
            <x-slot:dropdown :id="$item->getCode()">
                @foreach($item->dropdown as $subItem)
                    <x-hexagonal::sidebar.item-auto :item="$subItem" :level="$level"/>
                @endforeach
            </x-slot:dropdown>
        @endif
    </x-hexagonal::sidebar.item>
@endif