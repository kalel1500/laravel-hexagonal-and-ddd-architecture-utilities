<?php

namespace Thehouseofel\Hexagonal\Infrastructure\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class App extends Component
{
    public $title;
    public $sidebarCollapsed;
    public $isFromPackage;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $title = null,
        bool $package = false
    )
    {
        $this->title = $title ?? config('app.name');

        $links = collect(config('hexagonal.sidebar.items'));
        $firstCollapsed = $links->flatMap(function ($item) {
            // Combinar el array con sus sub_links (si existen)
            return array_merge([$item], $item['sub_links'] ?? []);
        })->first(function ($item) {
            return Arr::get($item, 'route_name') === Route::currentRouteName(); // Puedes ajustar el filtro aquí
        });

        $this->sidebarCollapsed = Arr::get($firstCollapsed, 'collapsed', false);
        $this->isFromPackage = $package;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view('hexagonal::components.layout.app');
    }
}
