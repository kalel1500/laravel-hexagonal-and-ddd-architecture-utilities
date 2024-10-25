<?php

namespace Thehouseofel\Hexagonal\Infrastructure\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\Layout\SidebarItemCollection;
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
        $this->showSearch = config('template.sidebar.search.show');
        $this->searchAction = getUrlFromRoute(config('template.sidebar.search.route'));
        $this->items = SidebarItemCollection::fromArray(config('template.sidebar.items'));
        $this->footer = SidebarItemCollection::fromArray(config('template.sidebar.footer'));
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
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.full');
    }
}
