<?php

namespace Thehouseofel\Hexagonal\Infrastructure\View\Components\Navbar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\Collections\NavbarItemCollection;
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
     *
     * @return View|Closure|string
     */
    public function render()
    {
        $this->showSearch = config('hexagonal_layout.navbar.search.show');
        $this->searchAction = getUrlFromRoute(config('hexagonal_layout.navbar.search.route'));
        $this->items = NavbarItemCollection::fromArray(config('hexagonal_layout.navbar.items') ?? []);

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

        return view('hexagonal::components.navbar.full');
    }
}
