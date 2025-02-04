@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\NavbarItemDo $item */ @endphp
@php /** @var \Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\NavbarItemDo $subItem */ @endphp

<!-- New -->
<x-hexagonal::navbar>
    <x-slot:left-side>
        <x-hexagonal::navbar.hamburger-icon/>

        <x-hexagonal::navbar.brand/>

        @if($showSearch)
            <x-hexagonal::navbar.search-form/>
        @endif
    </x-slot:left-side>

    <x-slot:right-side>
        @if($showSearch)
            <!-- Toggle sidebar mobile search -->
            <x-hexagonal::navbar.search-toggle-mobile/>
        @endif

        @foreach($items as $item)
            @if($item->is_theme_toggle)
                <!-- Theme toggle -->
                <x-hexagonal::navbar.theme-toggle/>
            @else
                <!-- {{ $item->getCode() }} -->
                <x-hexagonal::navbar.item :id="$item->getCode()" :text="$item->text" :user="$item->is_user">
                    <!-- Item icon -->
                    @if($item->is_user)
                        <x-hexagonal::icon.user-profile class="h-8 w-8 hover:bg-gray-700 hover:dark:bg-gray-300"/>
                    @else
                        <x-hexagonal::render-icon :icon="$item->icon" />
                    @endif

                    @if($item->hasDropdown())
                        <x-slot:dropdown>
                            <x-hexagonal::navbar.dropdown
                                :big-list="$item->dropdown->is_list"
                                :big-square="$item->dropdown->is_square"
                                :header="$item->dropdown->header"
                            >
                                @if($item->is_user)
                                    <x-slot:header href="#">
                                        <x-hexagonal::navbar.dropdown.user-info :name="$item->dropdown->userInfo->name" :email="$item->dropdown->userInfo->email"/>
                                    </x-slot:header>
                                @endif

                                @foreach($item->dropdown->items as $subItem)
                                    @if($item->dropdown->is_list)
                                        <x-hexagonal::navbar.dropdown.link :href="$subItem->getHref()" :time="$subItem->time">
                                            <x-slot:icon>
                                                <x-hexagonal::render-icon :icon="$subItem->icon" />
                                            </x-slot:icon>
                                            {{ $subItem->text }}
                                        </x-hexagonal::navbar.dropdown.link>
                                    @elseif($item->dropdown->is_square)
                                        <x-hexagonal::navbar.dropdown.link :href="$subItem->getHref()" :text="$subItem->text">
                                            <x-hexagonal::render-icon :icon="$subItem->icon" />
                                        </x-hexagonal::navbar.dropdown.link>
                                    @elseif($subItem->is_separator)
                                        <x-hexagonal::navbar.dropdown.separator/>
                                    @else
                                        <x-hexagonal::navbar.dropdown.link :href="$subItem->getHref()" :is_post="$subItem->is_post">
                                            @if($subItem->icon) <x-hexagonal::render-icon :icon="$subItem->icon" class="size-5 mr-2"/> @endif
                                            {{ $subItem->text }}
                                        </x-hexagonal::navbar.dropdown.link>
                                    @endif
                                @endforeach

                                @if($item->dropdown->footer)
                                    <x-slot:footer :href="$item->dropdown->footer->getHref()">
                                        <x-hexagonal::render-icon :icon="$item->dropdown->footer->icon" />
                                        {{ $item->dropdown->footer->text }}
                                    </x-slot:footer>
                                @endif
                            </x-hexagonal::navbar.dropdown>

                        </x-slot:dropdown>
                    @endif
                </x-hexagonal::navbar.item>
            @endif
        @endforeach

    </x-slot:right-side>
</x-hexagonal::navbar>