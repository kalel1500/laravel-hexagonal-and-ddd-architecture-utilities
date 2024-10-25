@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\SidebarItemDo $item */ @endphp
@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\SidebarItemDo $subItem */ @endphp

<x-hexagonal::sidebar>
    @if($showSearch)
        <x-slot:header>
            <x-hexagonal::sidebar.search-from :action="$searchAction"/>
        </x-slot:header>
    @endif

    @foreach($items as $item)
        @if($item->is_separator)
            <x-hexagonal::sidebar.separator/>
        @else
            <x-hexagonal::sidebar.item
                :href="$item->hasDropdown() ? null : $item->getHref()"
                :counter="$item->hasCounter() ? $item->getCounter() : null"
            >
                @if(!is_null($item->icon))
                    <x-slot:icon>
                        {!! $item->icon !!}
                    </x-slot:icon>
                @endif
                {{ $item->text }}
                @if($item->hasDropdown())
                    <x-slot:dropdown :id="$item->getCode()">
                        @foreach($item->dropdown as $subItem)
                            <x-hexagonal::sidebar.item subitem :href="$subItem->getHref()">{{ $subItem->text }}</x-hexagonal::sidebar.item>
                        @endforeach
                    </x-slot:dropdown>
                @endif
            </x-hexagonal::sidebar.item>
        @endif
    @endforeach

    @if($hasFooter)
        <x-slot:footer>
            <x-hexagonal::sidebar.footer>
                @foreach($footer as $item)
                    <x-hexagonal::sidebar.footer.item
                        :href="$item->hasDropdown() ? null : $item->getHref()"
                        :id="$item->code ?? null"
                        :tooltip="$item->tooltip ?? null"
                    >
                        {!! $item->icon !!}
                        @if($item->hasDropdown())
                            <x-slot:dropdown>
                                @foreach($item->dropdown as $subItem)
                                    <x-hexagonal::sidebar.footer.subitem>
                                        {!! $subItem->icon !!}
                                        {{ $subItem->text }}
                                    </x-hexagonal::sidebar.footer.subitem>
                                @endforeach
                            </x-slot:dropdown>
                        @endif
                    </x-hexagonal::sidebar.footer.item>
                @endforeach
            </x-hexagonal::sidebar.footer>
        </x-slot:footer>
    @endif
</x-hexagonal::sidebar>
