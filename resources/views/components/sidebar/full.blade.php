@php /** @var Src\Shared\Domain\Objects\DataObjects\SidebarItemDo $item */ @endphp
@php /** @var Src\Shared\Domain\Objects\DataObjects\SidebarItemDo $subItem */ @endphp

<x-sidebar>
    @if($showSearch)
        <x-slot:header>
            <x-sidebar.search-from :action="$searchAction"/>
        </x-slot:header>
    @endif

    @foreach($items as $item)
        @if($item->is_separator)
            <x-sidebar.separator/>
        @else
            <x-sidebar.item
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
                            <x-sidebar.item subitem :href="$subItem->getHref()">{{ $subItem->text }}</x-sidebar.item>
                        @endforeach
                    </x-slot:dropdown>
                @endif
            </x-sidebar.item>
        @endif
    @endforeach

    @if($hasFooter)
        <x-slot:footer>
            <x-sidebar.footer>
                @foreach($footer as $item)
                    <x-sidebar.footer.item
                        :href="$item->hasDropdown() ? null : $item->getHref()"
                        :id="$item->code ?? null"
                        :tooltip="$item->tooltip ?? null"
                    >
                        {!! $item->icon !!}
                        @if($item->hasDropdown())
                            <x-slot:dropdown>
                                @foreach($item->dropdown as $subItem)
                                    <x-sidebar.footer.subitem>
                                        {!! $subItem->icon !!}
                                        {{ $subItem->text }}
                                    </x-sidebar.footer.subitem>
                                @endforeach
                            </x-slot:dropdown>
                        @endif
                    </x-sidebar.footer.item>
                @endforeach
            </x-sidebar.footer>
        </x-slot:footer>
    @endif
</x-sidebar>
