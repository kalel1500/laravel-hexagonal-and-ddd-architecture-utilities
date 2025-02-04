<?php

namespace Thehouseofel\Hexagonal\Infrastructure\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\Collections\SidebarItemCollection;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\Layout\SidebarItemDo;
use Thehouseofel\Hexagonal\Infrastructure\Facades\LayoutService;

class Full extends Component
{
    public $showSearch;
    public $searchAction;
    public $items;
    public $hasFooter;
    public $footer;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->showSearch = config('hexagonal_layout.sidebar.search.show');
        $this->searchAction = getUrlFromRoute(config('hexagonal_layout.sidebar.search.route'));
        $this->items = SidebarItemCollection::fromArray(config('hexagonal_layout.sidebar.items') ?? []);
        $this->footer = SidebarItemCollection::fromArray(config('hexagonal_layout.sidebar.footer') ?? []);
        $this->hasFooter = $this->footer->countInt()->isBiggerThan(0);

        $this->items = $this->items->map(function (SidebarItemDo $item) {
            if (!is_null($action = $item->counter_action)) {
                $item->setCounter(LayoutService::$action());
            }
            return $item;
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('hexagonal::components.sidebar.full');
    }
}
