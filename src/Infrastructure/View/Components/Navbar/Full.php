<?php

namespace Thehouseofel\Hexagonal\Infrastructure\View\Components\Navbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\Layout\NavbarItemCollection;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\NavbarItemDo;
use Thehouseofel\Hexagonal\Infrastructure\Facades\LayoutService;

class Full extends Component
{
    public $showSearch;
    public $searchAction;
    public $items;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->showSearch = config('template.navbar.search.show');
        $this->searchAction = getUrlFromRoute(config('template.navbar.search.route'));
        $this->items = NavbarItemCollection::fromArray(config('template.navbar.items'));

        $this->items = $this->items->map(function (NavbarItemDo $item) {
            if (!is_null($dropdown = $item->dropdown) && !is_null($action = $dropdown->get_data_action)) {
                switch ($action) {
                    case 'getNavbarNotifications':
                        $dropdown->setItems(LayoutService::$action());
                        break;
                    case 'getUserInfo':
                        $dropdown->setUserInfo(LayoutService::$action());
                        break;
                }
            }
            return $item;
        });

        return view('components.navbar.full');
    }
}
