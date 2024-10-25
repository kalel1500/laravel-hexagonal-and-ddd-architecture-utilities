@php /** @var Src\Shared\Domain\Objects\DataObjects\NavbarItemDo $item */ @endphp
@php /** @var Src\Shared\Domain\Objects\DataObjects\NavbarItemDo $subItem */ @endphp

<!-- New -->
<x-navbar>
    <x-slot:left-side>
        <x-navbar.hamburger-icon/>

        <x-navbar.brand/>

        @if($showSearch)
            <x-navbar.search-form/>
        @endif
    </x-slot:left-side>

    <x-slot:right-side>
        @if($showSearch)
            <!-- Toggle sidebar mobile search -->
            <x-navbar.search-toggle-mobile/>
        @endif

        @foreach($items as $item)
            @if($item->is_theme_toggle)
                <!-- Theme toggle -->
                <x-navbar.theme-toggle/>
            @else
                <!-- {{ $item->getCode() }} -->
                <x-navbar.item :id="$item->getCode()" :text="$item->text" :user="$item->is_user">
                    <!-- Item icon -->
                    @if($item->is_user)
                        <x-icon.user class="h-8 w-8 hover:bg-gray-700 hover:dark:bg-gray-300"/>
                    @else
                        {!! $item->icon !!}
                    @endif

                    @if($item->hasDropdown())
                        <x-slot:dropdown>
                            <x-navbar.dropdown
                                :big-list="$item->dropdown->is_list"
                                :big-square="$item->dropdown->is_square"
                                :header="$item->dropdown->header"
                            >
                                @if($item->is_user)
                                    <x-slot:header href="#">
                                        <x-navbar.dropdown.user-info :name="$item->dropdown->userInfo->name" :email="$item->dropdown->userInfo->email"/>
                                    </x-slot:header>
                                @endif

                                @foreach($item->dropdown->items as $subItem)
                                    @if($item->dropdown->is_list)
                                        <x-navbar.dropdown.link :href="$subItem->getHref()" :time="$subItem->time">
                                            <x-slot:icon>
                                                <x-dynamic-component :component="$subItem->icon" />
                                            </x-slot:icon>
                                            {{ $subItem->text }}
                                        </x-navbar.dropdown.link>
                                    @elseif($item->dropdown->is_square)
                                        <x-navbar.dropdown.link :href="$subItem->getHref()" :text="$subItem->text">
                                            {!! $subItem->icon !!}
                                        </x-navbar.dropdown.link>
                                    @elseif($subItem->is_separator)
                                        <x-navbar.dropdown.separator/>
                                    @else
                                        <x-navbar.dropdown.link href="#">
                                            @if($subItem->icon) {!! $subItem->icon !!} @endif
                                            {{ $subItem->text }}
                                        </x-navbar.dropdown.link>
                                    @endif
                                @endforeach

                                @if($item->dropdown->footer)
                                    <x-slot:footer :href="$item->dropdown->footer->getHref()">
                                        {!! $item->dropdown->footer->icon !!}
                                        {{ $item->dropdown->footer->text }}
                                    </x-slot:footer>
                                @endif
                            </x-navbar.dropdown>

                        </x-slot:dropdown>
                    @endif
                </x-navbar.item>
            @endif
        @endforeach

    </x-slot:right-side>
</x-navbar>