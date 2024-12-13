@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\SidebarItemDo $item */ @endphp
@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\SidebarItemDo $subItem */ @endphp

<x-hexagonal::sidebar>
    @if($showSearch)
        <x-slot:header>
            <x-hexagonal::sidebar.search-from :action="$searchAction"/>
        </x-slot:header>
    @endif

    @foreach($items as $item)
        <x-hexagonal::sidebar.item-auto :item="$item" level="0"/>
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
                        <x-hexagonal::render-icon :icon="$item->icon" />
                        @if($item->hasDropdown())
                            <x-slot:dropdown>
                                @foreach($item->dropdown as $subItem)
                                    <x-hexagonal::sidebar.footer.subitem>
                                        <x-hexagonal::render-icon :icon="$subItem->icon" />
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
